<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Book;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // 👇 Ajoute ce trait pour pouvoir utiliser $this->authorize()
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    /**
     * Stocker un nouveau commentaire
     */
    public function store(Request $request, Book $book)
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'book_id' => $book->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Commentaire ajouté.');
    }

    /**
     * Éditer un commentaire
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Mettre à jour un commentaire
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update($validated);

        return redirect()->route('books.show', $comment->book_id)
            ->with('success', 'Commentaire mis à jour.');
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Commentaire supprimé.');
    }
}
