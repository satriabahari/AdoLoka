<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::view('/', 'welcome');

Route::view('home', 'home')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::get('events', [EventController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('events');

Route::get('events/{event}', [EventController::class, 'show'])
    // Route::get('events/{slug}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('products', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('products');

Route::get('products/{product}', [ProductController::class, 'show'])
    // ->middleware(['auth', 'verified'])
    ->name('products.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});

require __DIR__ . '/auth.php';
