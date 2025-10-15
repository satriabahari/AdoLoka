<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Livewire\Pages\Profile\Profile;
use App\Livewire\Profile\UpdateProfileInformation;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::view('/', 'welcome');

Route::get('home', [HomeController::class, 'index'])
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

Route::middleware(['auth'])->group(function () {
    // Create order and get snap token
    Route::post('/order/create/{product}', [OrderController::class, 'createOrder'])->name('order.create');

    // Payment result pages
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/pending', [OrderController::class, 'pending'])->name('order.pending');
    Route::get('/order/failed', [OrderController::class, 'failed'])->name('order.failed');
});

// Midtrans callback (no auth required)
Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

Route::get('/profile/test', Profile::class)
    ->middleware(['auth'])
    ->name('profile');;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile-old');

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});

require __DIR__ . '/auth.php';
