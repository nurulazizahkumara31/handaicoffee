<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PresensiExportController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\CobaMidtransController;
use App\Http\Controllers\GeminiController;
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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

//     return Auth::check() ? redirect('/dashboard') : view('index');
// })->name('home');
// Route untuk menampilkan halaman home atau redirect
Route::get('/login', function () {
    return Auth::check() ? redirect('/dashboard') : view('index');
})->name('home');

// Route::get('/register', [RegisterController::class, 'show'])->name('register');
// Route::post('/register', [RegisterController::class, 'store']);
Route::get('/register', [RegisterController::class, 'show'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class,'store']);


Route::post('/logout', [LoginController::class, 'logout'])->name('logout')
->middleware('auth');

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

Route::get('/tes-rupiah', function () {
    return rupiah(1500000); // Harusnya keluar: Rp 1.500.000
});

// Rute public
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// routes/web.php


Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')
->middleware('auth');;
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');


// Rute untuk halaman konfirmasi

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')
->middleware('auth');

Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.page')->middleware('auth');

Route::get('/payment/{orderId}', [PaymentController::class, 'show'])->name('payment.show')->middleware('auth');

Route::post('/payment/{orderId}/process', [PaymentController::class, 'processPayment'])
    ->name('payment.process')
    ->middleware('auth');

Route::post('/payment/token', [PaymentController::class, 'getSnapToken'])
    ->name('payment.token')
    ->middleware('auth');

    // routes/web.php
Route::post('/payment/{orderId}/pay', [PaymentController::class, 'pay'])->name('payment.pay')->middleware('auth');


Route::get('/coba-midtrans', [CobaMidtransController::class, 'index']);
Route::post('/payment/{order}/pay', [PaymentController::class, 'pay'])->name('payment.pay');
// Route::post('/payment/callback', [PaymentController::class, 'midtransCallback'])->name('payment.callback');
Route::post('/midtrans/callback', [PaymentController::class, 'midtransCallback']);


Route::get('/invoice', [PaymentController::class, 'success'])->name('payment.success');
// Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/{orderId}/invoice-pdf', [PaymentController::class, 'downloadInvoice'])
    ->name('payment.invoice.pdf')
    ->middleware('auth');


Route::get('/payment/invoice/{orderId}', [PaymentController::class, 'downloadInvoice'])->name('payment.invoice')->middleware('auth');
    
Route::get('/payment/{orderId}/invoice-pdf', [PaymentController::class, 'downloadInvoice'])
    ->name('payment.invoice.pdf')
    ->middleware('auth');

//api
Route::get('/api/news', [App\Http\Controllers\NewsController::class, 'index']);


//GEMIN
Route::post('/chatbot', [GeminiController::class, 'chat']);

