<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Livewire\Pages\Profile\Profile;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Livewire\Pages\Auth\MultiStepRegistration;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('events', [EventController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('events');

Route::get('events/{event}', [EventController::class, 'show'])
    ->name('events.show');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Product Payment Routes
Route::post('/products/{product:slug}/payment', [ProductController::class, 'createPayment'])
    ->name('products.payment.create');
Route::get('/products/payment/status/{orderNumber}', [ProductController::class, 'paymentStatus'])
    ->name('products.payment.status');
Route::post('/products/payment/callback', [ProductController::class, 'paymentCallback'])
    ->name('products.payment.callback');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/order/create/{product}', [OrderController::class, 'createOrder'])->name('order.create');

    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/pending', [OrderController::class, 'pending'])->name('order.pending');
    Route::get('/order/failed', [OrderController::class, 'failed'])->name('order.failed');
});

Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

// Payment Routes
Route::post('/payment/create/{service}', [PaymentController::class, 'createOrder'])->name('payment.create');
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/status/{orderNumber}', [PaymentController::class, 'status'])->name('payment.status');

Route::get('/profile', Profile::class)
    ->middleware(['auth'])
    ->name('profile');;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});

// Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/register', MultiStepRegistration::class)->name('register');
Route::get('/register/umkm', MultiStepRegistration::class)->name('register.umkm');

require __DIR__ . '/auth.php';

// <?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\{
//     HomeController,
//     EventController,
//     ProductController,
//     ServiceController,
//     OrderController,
//     PaymentController,
//     GoogleAuthController
// };
// use App\Livewire\Pages\Auth\MultiStepRegistration;
// use App\Livewire\Pages\Profile\Profile;

// // -------------------------
// // Public (tanpa autentikasi)
// // -------------------------
// Route::get('/', [HomeController::class, 'index'])->name('home');

// // Events (index butuh verified, show publik)
// Route::get('events/{event}', [EventController::class, 'show'])
//     ->name('events.show');

// // Products
// Route::controller(ProductController::class)->group(function () {
//     Route::get('/products', 'index')->name('products.index');
//     Route::get('/products/{product:slug}', 'show')->name('products.show');

//     // Payment (produk) - public endpoints
//     Route::get('/products/payment/status/{orderNumber}', 'paymentStatus')
//         ->whereAlphaNumeric('orderNumber')
//         ->name('products.payment.status');

//     // Callback/webhook dari payment gateway (CSRF off via middleware exception)
//     Route::post('/products/payment/callback', 'paymentCallback')
//         ->middleware(['throttle:60,1']) // sesuaikan kebutuhan
//         ->name('products.payment.callback');
// });

// // Services
// Route::controller(ServiceController::class)->group(function () {
//     Route::get('/services', 'index')->name('services.index');
//     Route::get('/services/{service}', 'show')->name('services.show');
// });

// // Pendaftaran (Livewire)
// Route::get('/register', MultiStepRegistration::class)->name('register');
// Route::get('/register/umkm', MultiStepRegistration::class)->name('register.umkm');

// // -------------------------
// // Auth + Verified
// // -------------------------
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('events', [EventController::class, 'index'])->name('events');

//     Route::view('dashboard', 'dashboard')->name('dashboard');
// });

// // -------------------------
// // Hanya Auth
// // -------------------------
// Route::middleware('auth')->group(function () {
//     Route::post('/order/create/{product}', [OrderController::class, 'createOrder'])
//         ->name('order.create');

//     Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
//     Route::get('/order/pending', [OrderController::class, 'pending'])->name('order.pending');
//     Route::get('/order/failed', [OrderController::class, 'failed'])->name('order.failed');

//     Route::get('/profile', Profile::class)->name('profile');
// });

// // -------------------------
// // Payment (service) & Webhook
// // -------------------------
// Route::controller(PaymentController::class)->group(function () {
//     // order create bisa public atau auth — pilih salah satu.
//     // Jika harus login, pindahkan ke group('auth')
//     Route::post('/payment/create/{service}', 'createOrder')
//         ->name('payment.create');

//     // Notifikasi/Callback dari gateway (pastikan CSRF off)
//     Route::post('/payment/notification', 'notification')
//         ->middleware(['throttle:60,1'])
//         ->name('payment.notification');

//     // Halaman redirect finish/status (umumnya GET publik)
//     Route::get('/payment/finish', 'finish')->name('payment.finish');
//     Route::get('/payment/status/{orderNumber}', 'status')
//         ->whereAlphaNumeric('orderNumber')
//         ->name('payment.status');
// });

// // Midtrans callback (jika masih dipakai)
// Route::post('/midtrans/callback', [OrderController::class, 'callback'])
//     ->middleware(['throttle:60,1'])
//     ->name('midtrans.callback');

// // -------------------------
// // Google OAuth (hindari closure agar route:cache aman)
// // -------------------------
// Route::prefix('auth/google')->name('auth.google.')->group(function () {
//     Route::get('/', [GoogleAuthController::class, 'redirect'])->name('redirect');
//     Route::get('/callback', [GoogleAuthController::class, 'callback'])->name('callback');
// });

// // Auth scaffolding bawaan
// require __DIR__ . '/auth.php';
