<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;

class BookSearch extends Component
{
    public $query = '';
    public $books = [];
    public $page = 1;
    public $perPage = 12;
    public $hasMore = true;

    protected $updatesQueryString = ['query'];

    public function mount()
    {
        $this->loadBooks();
    }

    public function updatedQuery()
    {
        $this->resetList();
        $this->loadBooks();
    }

    public function loadMore()
    {
        if ($this->hasMore) {
            $this->page++;
            $this->loadBooks();
        }
    }

    private function resetList()
    {
        $this->books = [];
        $this->page = 1;
        $this->hasMore = true;
    }

    private function loadBooks()
    {
        $query = Book::with('tags')
            ->when($this->query, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('title', 'like', '%' . $this->query . '%')
                        ->orWhere('author', 'like', '%' . $this->query . '%')
                        ->orWhereHas('tags', function ($tagQuery) {
                            $tagQuery->where('name', 'like', '%' . $this->query . '%');
                        });
                });
            })
            ->orderBy('lastName')
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        $this->books = array_merge($this->books, $query->items());

        if (!$query->hasMorePages()) {
            $this->hasMore = false;
        }
    }

    public function render()
    {
        return view('livewire.book-search');
    }
}
