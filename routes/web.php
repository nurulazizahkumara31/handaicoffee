<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Product\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//home
Route::get('/', function () {
    return view('index');
});


// Route ke halaman dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('das')->middleware('auth');


// Route untuk menampilkan halaman login (GET)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route untuk memproses login (POST)
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/menu', [ProductController::class, 'index'])->name('menu');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// routes/web.php
use App\Http\Controllers\CartController;

Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');


// Rute untuk halaman konfirmasi
Route::get('/order/confirmation', [CartController::class, 'confirmation'])->name('order.confirmation');



