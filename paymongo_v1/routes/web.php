<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/pay', [CheckoutController::class, 'index'])->name('pay');