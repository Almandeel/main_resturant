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

Route::prefix('cashier')->middleware(['auth'])->group(function() {
    Route::get('/', 'CashierController@index')->name('cashier.dashboard');
    Route::get('pos', 'CashierController@pos')->name('cashier.pos');
    Route::get('safe', 'CashierController@safe')->name('cashier.safe');
    Route::resource('drivers', 'DriverController',['as' => 'cashier'])->only(['index', 'show', 'update']);
    Route::resource('waiters', 'WaiterController',['as' => 'cashier'])->only(['show', 'index']);
    Route::resource('menus', 'MenuController',['as' => 'cashier'])->only(['index']);
    Route::resource('tables', 'TableController',['as' => 'cashier'])->only(['index', 'show']);
    Route::resource('halls', 'HallController',['as' => 'cashier'])->only(['index', 'show']);
    Route::resource('orders', 'OrderController',['as' => 'cashier'])->only(['index', 'show', 'edit', 'store', 'update']);
    ROute::get('reports', 'ReportsController@index')->name('cashier.reports.index');
    ROute::get('reports/orders', 'ReportsController@orders')->name('cashier.reports.orders');
});