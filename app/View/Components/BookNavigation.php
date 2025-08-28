<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BookNavigation extends Component
{
    public $books;
    public $currentBook;

    public function __construct($books, $currentBook)
    {
        $this->books = $books;
        $this->currentBook = $currentBook;
    }

    public function render()
    {
        return view('components.book-navigation');
    }
}
