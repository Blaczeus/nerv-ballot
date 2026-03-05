<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::inertia('/contestants', 'Contestants/Index')->name('contestants');
Route::inertia('/how-it-works', 'HowItWorks')->name('howItWorks');
Route::get('/contestants/{slug}', function (string $slug) {
    return Inertia::render('Contestants/Show', ['slug' => $slug]);
})->name('contestant');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

