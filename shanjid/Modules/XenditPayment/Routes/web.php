<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['subdomain']], function () {
    Route::prefix('xenditpayment')->group(function () {
        Route::post('/student_fees_pay_xendti', 'XenditPaymentController@studentPay')->name('xenditpayment.feesPayment');
        Route::get('/payment_success_callback', 'XenditPaymentController@successCallBack')->name('xenditpayment.successCallBack');
        Route::get('/payment_fail_callback', 'XenditPaymentController@failCallBack')->name('xenditpayment.failCallBack');
    });
});