<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ViewInfoController;
use App\Http\Controllers\RefundController;



Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/payment/{id}', [PaymentController::class, 'paymentIndex'])->name('payment.index');
Route::get('/payment/create/{id}/{type}', [PaymentController::class, 'create'])->name('create.payment');
Route::get('/payment/sucess/{id}', [PaymentController::class, 'PaymentSucess'])->name('sucess.payment');


Route::get('/view/info/{id}/{type}/{itemId}', [ViewInfoController::class, 'view'])->name('view.info');

Route::get('/refund/decline/{id}', [RefundController::class, 'decline'])->name('refund.decline');
Route::get('/refund/accept/{id}', [RefundController::class, 'accept'])->name('refund.accept');