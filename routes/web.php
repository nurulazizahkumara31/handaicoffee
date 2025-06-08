<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
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
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SettingsController;


// Halaman utama
Route::get('/', function () {

    return view('index');
});
Route::get('/presensi/export-pdf', [PresensiExportController::class, 'exportPdf'])->name('presensi.export.pdf');

// Route ke halaman dashboard
Route::get('/dashboard', function () {
    return view('dashboard');})
->name('das')
->middleware('auth');


// Route untuk menampilkan halaman login (GET)
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

//     return Auth::check() ? redirect('/dashboard') : view('index');
// })->name('home');
// Route untuk menampilkan halaman home atau redirect
Route::get('/login', function () {
    return Auth::check() ? redirect('/dashboard') : view('index');
})->name('home');



// Rute autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'show'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/menu', [ProductController::class, 'index'])->name('menu')
->middleware('auth');;
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// routes/web.php
use App\Http\Controllers\CartController;

Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')
->middleware('auth');;
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');


// Rute untuk halaman konfirmasi

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')
->middleware('auth');

Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.page')->middleware('auth');
