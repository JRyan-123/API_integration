<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pay', [CheckoutController::class, 'index'])->name('pay');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment/success', [CheckoutController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [CheckoutController::class, 'cancel'])->name('payment.cancel');