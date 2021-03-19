<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('restaurant')->middleware('auth')->group(function () {
    
    Route::get('/', 'DashboardController')->name('restaurant.dashboard');
    
    Route::resource('drivers', 'DriverController');
    Route::resource('waiters', 'WaiterController');
    Route::resource('tables', 'TableController');
    Route::resource('halls', 'HallController');
    Route::resource('menus', 'MenuController');
    Route::resource('orders', 'OrderController');
    Route::resource('cashiers', 'CashiersController',['as' => 'restaurant']);//->only(['index', 'show', 'edit', 'store', 'update']);
});