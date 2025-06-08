<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CobaMidtransController;
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
    return view('dashboard');})
->name('das')
->middleware('auth');


// Route untuk menampilkan halaman login (GET)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Route untuk memproses login (POST)
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);



Route::post('/logout', [LoginController::class, 'logout'])->name('logout')
->middleware('auth');

Route::get('/menu', [ProductController::class, 'index'])->name('menu')
->middleware('auth');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// routes/web.php
use App\Http\Controllers\CartController;

Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')
->middleware('auth');   
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.delete');


// Rute untuk halaman konfirmasi

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')
->middleware('auth');

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

