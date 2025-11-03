<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Livewire\Pages\Profile\Profile;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Auth\MultiStepRegistration;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Events (protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event:slug}', [EventController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Products (protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [ProductController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Services (protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('services')->name('services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Orders (protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('order')->name('order.')->group(function () {
    Route::post('/create/{product}', [OrderController::class, 'createOrder'])->name('create');

    Route::get('/success', [OrderController::class, 'success'])->name('success');
    Route::get('/pending',  [OrderController::class, 'pending'])->name('pending');
    Route::get('/failed',   [OrderController::class, 'failed'])->name('failed');
});

/*
|--------------------------------------------------------------------------
| Payment (unified)
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/{type}/{id}/create', [PaymentController::class, 'createOrder'])
        ->whereIn('type', ['product', 'service'])
        ->whereNumber('id')
        ->middleware(['auth'])
        ->name('create');

    Route::get('/status/{orderNumber}', [PaymentController::class, 'status'])
        ->middleware(['auth'])
        ->name('status');

    // Debug route opsional
    Route::get('/test-notification', [PaymentController::class, 'testNotification']);
    Route::get('/check-status/{orderNumber}', [PaymentController::class, 'checkStatus']);
    Route::post('/sync-status/{orderNumber}', [PaymentController::class, 'syncStatus']);
});

// Callback Midtrans (no CSRF)
Route::post('payment/notification', [PaymentController::class, 'notification'])
    ->withoutMiddleware([
        VerifyCsrfToken::class,
        ValidateCsrfToken::class
    ])
    ->name('payment.notification');

/*
|--------------------------------------------------------------------------
| Profile & Dashboard (protected)
|--------------------------------------------------------------------------
*/
Route::get('/profile', Profile::class)->middleware(['auth'])->name('profile');

/*
|--------------------------------------------------------------------------
| Google OAuth
|--------------------------------------------------------------------------
*/
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('/', [GoogleAuthController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [GoogleAuthController::class, 'callback'])->name('callback');
});

/*
|--------------------------------------------------------------------------
| Registration (public)
|--------------------------------------------------------------------------
*/
Route::get('/register', MultiStepRegistration::class)->name('register');
Route::get('/register/umkm', MultiStepRegistration::class)->name('register.umkm');

Route::get('/map', function () {
    return view('map');
})->name('map');


require __DIR__ . '/auth.php';
