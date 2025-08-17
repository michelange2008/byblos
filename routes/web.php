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
    Route::get('/bibliotheque', [LibraryController::class, 'index'])->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Route::controller(BookController::class)->group(function () {

        Route::get('/livre/{book}', 'show');

        Route::post('/livre', 'store');
    });

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
