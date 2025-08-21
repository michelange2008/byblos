<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestBookController extends Controller
{
    public function edit($book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $book)
    {
        // Pour test, on affiche juste ce qui est reçu
        dd([
            'book' => $book,
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'file' => $request->file('cover'),
            'token' => $request->_token,
        ]);
    }
}
