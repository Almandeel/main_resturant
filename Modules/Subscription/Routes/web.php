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

Route::prefix('subscription')->group(function() {
    Route::get('/', 'SubscriptionController@dashboard')->name('subscription.dashboard');
    Route::get('subscriptions/barcode/{id}', 'SubscriptionController@barcode')->name('subscriptions.barcodes');
    Route::get('subcustomers/card/{id}', 'SubscriptionController@card')->name('subcustomers.card');
    Route::resources([
        'subscriptions' => 'SubscriptionController',
        'plans' => 'PlanController',
        'subcustomers' => 'CustomerController',
        'settings' => 'SettingController',
        ]
    );
});
