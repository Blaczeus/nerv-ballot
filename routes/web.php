<?php

use App\Http\Controllers\ContestantController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LeaderboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::get('/contestants', [ContestantController::class, 'index'])->name('contestants.index');
Route::get('/contestants/cart-items', [ContestantController::class, 'cartItems'])->name('contestants.cart-items');
Route::get('/contestants/search', [ContestantController::class, 'search'])->name('contestants.search');
Route::inertia('/about', 'About')->name('about');
Route::inertia('/cart', 'Cart')->name('cart');
Route::inertia('/checkout', 'Checkout')->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])
    ->middleware('throttle:10,1')
    ->name('checkout.process');
Route::inertia('/vote-success', 'VoteSuccess')->name('voteSuccess');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::get('/contestants/{slug}', [ContestantController::class, 'show'])->name('contestant');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

