<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\Tag;

class BookTags extends Component
{
    public Book $book;
    public $tags = [];

    public function mount(Book $book)
    {
        $this->book = $book;
        $this->tags = Tag::orderBy('name')->get();
    }

    public function toggleTag($tagId)
    {
        if ($this->book->tags->contains($tagId)) {
            $this->book->tags()->detach($tagId);
        } else {
            $this->book->tags()->attach($tagId);
        }

        // Recharge les relations pour mettre à jour l’affichage
        $this->book->refresh();
    }

    public function render()
    {
        return view('livewire.book-tags');
    }
}
