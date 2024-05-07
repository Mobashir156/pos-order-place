<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller('SiteController')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/order/', 'order')->name('order.index');
    Route::get('/order/search', 'search')->name('order.search');
});
Route::get('/link', function () {
    Artisan::call('storage:link');
    dd('done');
});