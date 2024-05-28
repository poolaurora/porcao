<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CardApiController;


Route::post('/bin/checker', [PaymentController::class, 'checkBin'])->name('bin.checker');

Route::post('/card/payloader', [CardApiController::class, 'data'])->name('card.payloader');

Route::post('/payment/payloader', [PaymentController::class, 'recivePayment'])->name('payment.payloader');