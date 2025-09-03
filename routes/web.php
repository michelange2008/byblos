<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Livewire\Authors;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Middleware\AdminOnly;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::middleware([AdminOnly::class])->prefix('admin')->group(function () {

    // Listes de livres de la page admin
    Route::get('/books', [AdminController::class, 'indexAdmin'])->name('admin.books');

    Route::get('downloads', [AdminController::class, 'indexDownloads'])->name('admin.downloads');

    Route::resource('users', UserController::class)->except(['show']);
    
    // Route::get('addUser', [UserController::class, 'add'])->name('user.add');

});


Route::middleware(['auth'])->group(function () {
    
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('/tags', function () {
        return view('admin.tags');
    })->name('admin.tags');

    Route::redirect('settings', 'settings/profile');

    Route::post('userStore', [UserController::class, 'store'])->name('user.store');

    Route::get('/authors', Authors::class)->name('authors.index');

    Route::post('/books/{book}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');

    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


});

Route::middleware(['auth'])->prefix('books')->group(function () {   
    // Prepare le téléchargement
    Route::get('/{book}/prepare-download', [BookController::class, 'prepareDownload'])
        ->name('books.prepareDownload');

    // Effectue le téléchargement
    Route::get('/{book}/stream', [BookController::class, 'stream'])
        ->name('books.stream');

    // Liste tous les livres    
    Route::get('/', [BookController::class, 'index'])->name('books.index');

    // Affiche le formulaire pour créer un nouveau livre
    Route::get('/create', [BookController::class, 'create'])->name('books.create');

    // Enregistre un nouveau livre
    Route::post('/', [BookController::class, 'store'])->name('books.store');

    // Affiche un livre spécifique
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');

    // Formulaire d'édition d'un livre
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');

    // **Update via POST au lieu de PUT/PATCH**
    Route::put('/update/{book}', [BookController::class, 'update'])->name('books.update');

    // Supprime un livre
    Route::delete('/{book}/destroy', [BookController::class, 'destroy'])->name('books.destroy');

});

require __DIR__ . '/auth.php';
