<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    private $books;

    function index()
    {
        $books = Book::all();

        return view('dashboard', [
            'books' => $books,
        ]);    
    }
}
