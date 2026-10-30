<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

// Home page and quotes feed (supports ?tab=all and ?tab=bookmarks)
Route::get('/', [QuoteController::class, 'index'])->name('home');

// Dedicated bookmarks page
Route::get('/bookmarks', [QuoteController::class, 'bookmarks'])->name('bookmarks');

// Quote CRUD actions
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
Route::put('/quotes/{quote}', [QuoteController::class, 'update'])->name('quotes.update');
Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');

// Bookmark feature: toggle bookmark status for a quote
Route::post('/quotes/{quote}/bookmark', [BookmarkController::class, 'toggle'])->name('quotes.bookmark');

// Authentication routes
Route::get('/signup', function () {
    return view('Authentication.SignUp', ['page' => 'Sign Up']);
})->name('signup');

Route::get('/login', function () {
    return view('Authentication.LogIn', ['page' => 'Log In']);
})->name('login');

Route::post('/signup', [AuthController::class, 'register'])
    ->name('signup.store');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->name('logout');
