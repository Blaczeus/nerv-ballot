<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::inertia('/contestants', 'Contestants/Index')->name('contestants');
Route::inertia('/about', 'About')->name('about');
Route::inertia('/cart', 'Cart')->name('cart');
Route::inertia('/checkout', 'Checkout')->name('checkout');
Route::inertia('/vote-success', 'VoteSuccess')->name('voteSuccess');
Route::inertia('/leaderboard', 'Leaderboard')->name('leaderboard');
Route::get('/contestants/{slug}', function (string $slug) {
    return Inertia::render('Contestants/Show', ['slug' => $slug]);
})->name('contestant');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

