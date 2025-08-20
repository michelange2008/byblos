<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Library;
use App\Http\Controllers\LibraryController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');




Route::middleware(['auth'])->group(function () {

    Route::redirect('settings', 'settings/profile');

    // Route spécifique pour télécharger un livre
    Route::get('books/{book}/download', [BookController::class, 'download'])
        ->name('books.download');

    // Routes CRUD standard
    Route::resource('books', BookController::class);

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
