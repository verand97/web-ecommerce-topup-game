<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ─── Built-in Auth (Laravel 11 Breeze-style manual) ───────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Public Routes ─────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Game catalog
Route::prefix('game')->name('catalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('{slug}', [CatalogController::class, 'show'])->name('show');
    Route::get('search/api', [CatalogController::class, 'search'])->name('search');
});

// Order flow
Route::prefix('order')->name('order.')->group(function () {
    Route::get('{productSlug}/checkout', [OrderController::class, 'create'])->name('create');
    Route::post('{productSlug}/checkout', [OrderController::class, 'store'])->name('store');
    Route::get('{orderNumber}/payment', [OrderController::class, 'payment'])->name('payment');
    Route::get('{orderNumber}/status', [OrderController::class, 'status'])->name('status');

    // Authenticated only
    Route::get('history', [OrderController::class, 'history'])->name('history')->middleware('auth');
});

// Payment webhook (no CSRF — excluded in bootstrap/app.php)
Route::post('payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// ─── Admin Routes ──────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Profile Settings
    Route::get('profile', [Admin\ProfileController::class, 'index'])->name('profile');
    Route::post('profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Products
    Route::resource('products', Admin\ProductController::class);

    // Orders
    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
});
