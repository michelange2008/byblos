<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Download;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


use App\Services\OpenLibraryService;
use App\Traits\HandlesCovers;

class BookController extends Controller
{
    use HandlesCovers;

    protected $coverService;

    public function __construct(OpenLibraryService $coverService)
    {
        $this->coverService = $coverService;
    }

    // Affiche la liste des livres
    public function index()
    {
        $books = Book::orderBy('lastName')->get();

        // dd($books);
        return view('bibliotheque', compact('books'));
    }


    /** 
     * Permet de télécharger l'epub
     */
    public function prepareDownload(Book $book)
    {
        $userId = auth()->id();
        $filePath = "books/{$book->file}";

        try {
            if (!Storage::disk('local')->exists($filePath)) {
                Download::create([
                    'user_id'       => $userId,
                    'book_id'       => $book->id,
                    'downloaded_at' => now(),
                    'status'        => 'failed',
                    'message'       => 'Fichier introuvable',
                ]);

                return redirect()->back()->with('error', 'Le fichier demandé est introuvable.');
            } else {
                Download::create([
                    'user_id'       => $userId,
                    'book_id'       => $book->id,
                    'downloaded_at' => now(),
                    'status'        => 'success',
                    'message'       => null,
                ]);

                // Générer l'URL temporaire pour le téléchargement
                $signedUrl = URL::temporarySignedRoute(
                    'books.stream',
                    now()->addMinutes(2),
                    ['book' => $book->id]
                );

                return redirect($signedUrl)->with('success', 'Le téléchargement va démarrer !');
            }
        } catch (\Exception $e) {
            report($e);

            Download::create([
                'user_id'       => $userId,
                'book_id'       => $book->id,
                'downloaded_at' => now(),
                'status'        => 'failed',
                'message'       => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erreur lors du téléchargement : ' . $e->getMessage());
        }
    }

    public function stream(Book $book)
    {
        if (! request()->hasValidSignature()) {
            abort(403, 'Lien de téléchargement invalide ou expiré.');
        }

        $filePath = "books/{$book->file}";

        return Storage::disk('local')->download($filePath, $book->file);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_book');
    }

    /**
     * Récupère un epbu téléchargé et stocke les infos dans la BDD, le fichier epub dans private
     * et la couverture dans public.
     */
    public function store(Request $request)
    {
        $request->validate([
            'epub' => 'required|file|mimes:epub|max:10240', // ton fichier EPUB
            'description' => 'string|max:2000',     // description texte, max 2000 caractères
        ]);

        // 1️⃣ Stocker l'EPUB dans private
        $epubPath = $request->file('epub')->store('books', 'local');


        // 2️⃣ Lire le EPUB avec kiwilan/php-ebook

        $ebook = \Kiwilan\Ebook\Ebook::read(Storage::disk('local')->path($epubPath));

        // 3️⃣ Extraire métadonnées
        $title = $ebook->getTitle() ?? 'Titre inconnu';

        $authors = $ebook->getAuthors();
        $authorMain = $ebook->getAuthorMain();

        if ($authorMain && method_exists($authorMain, 'getName')) {
            $author = $authorMain->getName();
        } elseif (!empty($authors)) {
            $author = $authors[0]; // Premier auteur si getAuthorMain() absent
        } else {
            $author = 'Auteur inconnu';
        }

        $lastName = $author;
        if (count(explode(' ', $author)) > 1) {
            $parts = explode(' ', $author);
            $lastName = end($parts);
        }

        // Renommer le fichier dans le storage
        $safeTitle = Str::slug($title);
        $safeAuthor = Str::slug($author);
        $safeName = $safeTitle . "_" . $safeAuthor . '.epub';

        $newPath = 'books/' . $safeName;
        Storage::move($epubPath, $newPath);

        $authors = collect($ebook->getAuthors())
            ->map(fn($a) => $a?->name ?? '')
            ->filter()
            ->all(); // tableau d’auteurs

        $description   = $request->description ?? '';
        $publishedDate = $ebook->getPublishDate()?->format('Y-m-d') ?? null;
        $publisher     = $ebook->getPublisher()?->name ?? 'Inconnu';

        $coverContents = $ebook->getCover()?->getContents()
            ?? $this->coverService->fetchCover($title, $author);

        $coverPath = $this->storeCover($title, $coverContents);


        // 5️⃣ Enregistrer dans la base
        try {
            DB::transaction(function () use ($title, $author, $authors, $lastName, $newPath, $coverPath, $description, $publisher, $publishedDate) {
                $book = Book::create([
                    'title'        => $title,
                    'author'       => $author,
                    'authors'      => $authors,       // JSON géré automatiquement
                    'lastName'     => $lastName,
                    'file'         => basename($newPath),
                    'cover'        => $coverPath,
                    'description'  => $description,
                    'publisher'    => $publisher,
                    'publisheDate' => $publishedDate,
                ]);

                $book->users()->syncWithoutDetaching([auth()->id()]);
            });

            return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès !');
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => "Erreur lors de l'ajout du livre : " . $e->getMessage()]);
        }


        return redirect()->route('books.index')->with('success', 'Livre ajouté !');
    }


    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $books = Book::orderBy('lastName')->get(); // ou filtré selon ta logique
        return view('book', compact('book', 'books'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('edit_book', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            // Supprimer l’ancienne si elle existe
            if ($book->cover && Storage::exists($book->cover)) {
                Storage::delete($book->cover);
            }

            // Générer un nom de fichier personnalisé avec slug + extension
            $filename = Str::slug($validated['title']) . '.' . $request->file('cover')->getClientOriginalExtension();

            // Stocker dans storage/app/public/covers
            $path = $request->file('cover')->storeAs('covers', $filename, 'public');

            $validated['cover'] = $path;
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)
            ->with('success', 'Livre mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $epub = $book->file;

        Storage::disk('local')->delete("books/" . $epub);

        $book->delete();

        return redirect()->route('books.index');
    }
}
