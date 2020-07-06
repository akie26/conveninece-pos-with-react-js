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

Route::get('/home', function () {
    return view('home');
});

Route::get('/barcode', 'BarcodeController@index')->name('barcode.index');
Route::get('/income/all', 'IncomeController@net')->name('income.all');
Route::post('/income/all/fetch_data', 'IncomeController@fetch_data')->name('income.all.fetch_data');
Auth::routes();
Route::resource('income', 'IncomeController');
Route::get('/income/income/{income}', 'IncomeController@showall');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('products', 'ProductController');
    Route::get('/admin', 'HomeController@index')->name('admin.index');
    Route::resource('orders', 'SaleController');
   
    
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart', 'CartController@store')->name('cart.store');
    Route::post('/cart/change-qty', 'CartController@changeQty');

    Route::delete('/cart/delete', 'CartController@delete');
    Route::delete('/cart/empty', 'CartController@empty');
});

