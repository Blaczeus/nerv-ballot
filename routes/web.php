<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::inertia('/contestants', 'Contestants/Index')->name('contestants');
Route::inertia('/how-it-works', 'HowItWorks')->name('howItWorks');
Route::inertia('/cart', 'Cart')->name('cart');
Route::inertia('/checkout', 'Checkout')->name('checkout');
Route::inertia('/vote-success', 'VoteSuccess')->name('voteSuccess');
Route::inertia('/leaderboard', 'Leaderboard')->name('leaderboard');
Route::get('/contestants/{slug}', function (string $slug) {
    $contestants = [
        'john-doe' => [
            'id' => 1,
            'slug' => 'john-doe',
            'name' => 'John Doe',
            'image' => '/tmp/images/products/womens/women-19.jpg',
            'hoverImage' => '/tmp/images/products/womens/women-20.jpg',
            'price' => '$219.99',
            'oldPrice' => '$98.00',
            'description' => 'Public voting nominee with strong stage presence and consistent fan engagement.',
            'availability' => 'Out of stock',
            'brand' => 'adidas',
        ],
        'amira-khan' => [
            'id' => 2,
            'slug' => 'amira-khan',
            'name' => 'Amira Khan',
            'image' => '/tmp/images/products/womens/women-29.jpg',
            'hoverImage' => '/tmp/images/products/womens/women-31.jpg',
            'price' => '$59.99',
            'oldPrice' => '$98.00',
            'description' => 'Category finalist recognized for advocacy impact and audience consistency.',
            'availability' => 'Out of stock',
            'brand' => 'LV',
        ],
        'emeka-ade' => [
            'id' => 3,
            'slug' => 'emeka-ade',
            'name' => 'Emeka Ade',
            'image' => '/tmp/images/products/womens/women-63.jpg',
            'hoverImage' => '/tmp/images/products/womens/women-64.jpg',
            'price' => '$219.95',
            'oldPrice' => '$98.00',
            'description' => 'Performance-driven nominee with measurable campaign results across regions.',
            'availability' => 'In stock',
            'brand' => 'nike',
        ],
    ];

    $contestant = $contestants[$slug] ?? [
        'id' => 0,
        'slug' => $slug,
        'name' => 'Contestant Profile',
        'image' => '/tmp/images/products/womens/women-19.jpg',
        'hoverImage' => '/tmp/images/products/womens/women-20.jpg',
        'price' => '$79.99',
        'description' => 'Contestant details will be connected to live data in the next phase.',
        'availability' => 'In stock',
        'brand' => 'modave',
    ];

    return Inertia::render('Contestants/ContestantDetails', ['contestant' => $contestant]);
})->name('contestant');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

