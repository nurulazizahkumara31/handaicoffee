<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SettingsController;

// Halaman utama
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : view('index');
})->name('home');

// Rute autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'show'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Rute terproteksi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/menu', [ProductController::class, 'index'])->name('menu');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.page');
});


// Rute public
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
