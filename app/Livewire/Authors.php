<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;

class Authors extends Component
{
    public $query = '';
    public $authors;
    public $books;

    public function mount()
    {
        $this->loadData();
    }

    public function updatedQuery()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Récupère tous les auteurs distincts
        $this->authors = Book::select('author', 'lastName')
            ->when($this->query, function ($q) {
                $q->where('lastName', 'like', "%{$this->query}%")
                    ->orWhere('title', 'like', "%{$this->query}%");
            })
            ->distinct()
            ->orderBy('lastName')
            ->get();
        // Récupère tous les livres correspondant à la recherche
        $this->books = Book::when($this->query, fn($q) =>
        $q->where('title', 'like', "%{$this->query}%")
            ->orWhere('lastName', 'like', "%{$this->query}%"))
            ->orderBy('lastName')
            ->get();
    }

    public function render()
    {
        return view('livewire.authors');
    }
}
