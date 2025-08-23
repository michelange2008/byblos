<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {

    Route::redirect('settings', 'settings/profile');

    Route::get('addUser', [UserController::class, 'add'])->name('user.add');

    Route::post('userStore', [UserController::class, 'store'])->name('user.store');

    // Route spécifique pour télécharger un livre
    Route::get('books/{book}/download', [BookController::class, 'download'])
        ->name('books.download');

    // Liste tous les livres
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Affiche le formulaire pour créer un nouveau livre
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');

    // Enregistre un nouveau livre
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // Affiche un livre spécifique
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

    // Formulaire d'édition d'un livre
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');

    // **Update via POST au lieu de PUT/PATCH**
    Route::put('/books/update/{book}', [BookController::class, 'update'])->name('books.update');

    // Supprime un livre
    Route::get('/books/{book}/destroy', [BookController::class, 'destroy'])->name('books.destroy');


    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
