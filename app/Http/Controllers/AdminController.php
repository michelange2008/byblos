<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;

class AdminController extends Controller
{

    // Affiche dans la page d'administration la liste des livres avec date et nom de celui qui l'a mis
    public function indexAdmin()
    {
        // Récupère tous les livres avec l'utilisateur lié, triés du plus récent au plus ancien
        $books = Book::with('users')
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::with('books')->get();

        return view('admin.index_books', compact('books', 'users'));
    }


    public function indexDownloads()
    {
        $downloads = Download::with(['user', 'book'])
            ->orderByDesc('downloaded_at')
            ->paginate(20); // 20 téléchargements par page

        return view('admin.downloads', compact('downloads'));
    }
}
