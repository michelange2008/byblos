<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Intl\Languages;
use App\Services\OpenLibraryService;
use SebLucas\EPubMeta\EPub;
use ZipArchive;
use SimpleXMLElement;

class BookController extends Controller
{
    protected $coverService;

    public function __construct(OpenLibraryService $coverService)
    {
        $this->coverService = $coverService;
    }

    // Affiche la liste des livres
    public function index()
    {
        $books = Book::all();
        // dd($books);
        return view('dashboard', compact('books'));
    }

    /** 
     * Permet de télécharger l'epub
     */
    public function download(Book $book)
    {
        $path = Storage::disk('local')->path('books/' . $book->file);

        return response()->download($path, $book->title . '.epub');
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
        $author = $ebook->getAuthorMain()->getName() ?? ($authors[0] ?? 'Auteur inconnu');

        $lastName = $author;
        if ( count(explode(' ', $author)) > 1  ) {
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
        
        $coverObj = $ebook->getCover();
        
        if ($coverObj) {
            // Récupérer le contenu binaire de l'image
            $cover = $coverObj->getContents(); // méthode recommandée par la lib
        } else {
            // fallback : récupérer depuis Open Library
            $cover = $this->coverService->fetchCover($title, $author);
        }
            
            // Sauvegarde
            $coverPath = 'covers/' . Str::slug($title) . '.jpg';
            Storage::disk('public')->put($coverPath, $cover);
            
        // 5️⃣ Enregistrer dans la base
        $book = Book::create([
            'title'        => $title,
            'author'       => $author,
            'authors'      => $authors,       // Laravel gère le JSON automatiquement
            'lastName'     => $lastName,
            'file'         => basename($newPath),
            'cover'        => $coverPath,
            'description'  => $description,
            'publisher'    => $publisher,
            'publisheDate' => $publishedDate,
        ]);

        return redirect()->route('books.index')->with('success', 'Livre ajouté !');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('book', ['book' => $book]);
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
        if ($book->cover && \Storage::exists($book->cover)) {
            \Storage::delete($book->cover);
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

        Storage::disk('local')->delete("books/".$epub);
        
        $book->delete();
        
        return redirect()->route('books.index');
    }

    function cover_edit(Book $book)
    {
        return view('books.covers.cover.edit', ['book' => $book]);    
    }

    function cover_store(Request $request, Book $book)
    {
        
    }
}
