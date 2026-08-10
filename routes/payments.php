<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register payment routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
|-------------------------------------------------------------------------
 */
Route::name('premium.payment.')->prefix('payment')->namespace('Payments')->middleware('license:2')->group(function () {
    Route::post('balance', 'Balance\ProcessController@execute')->name('balance');
    Route::post('manual/{id}', 'Manual\ProcessController@execute')->name('manual');
    Route::get('paypal', 'Paypal\ProcessController@execute')->name('paypal');
    Route::get('stripe', 'Stripe\ProcessController@execute')->name('stripe');
    Route::get('mollie', 'Mollie\ProcessController@execute')->name('mollie');
    Route::post('razorpay', 'Razorpay\ProcessController@execute')->name('razorpay');
    Route::post('paystack', 'Paystack\ProcessController@execute')->name('paystack');
    Route::post('coinbase-commerce', 'CoinbaseCommerce\ProcessController@execute')->name('Coinbase-commerce');
    Route::post('coingate', 'Coingate\ProcessController@execute')->name('coingate');
});