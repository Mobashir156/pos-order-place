<?php

use Illuminate\Support\Facades\Route;

Route::controller('PosController')->group(function () {
    Route::get('/pos', 'index')->name('pos.index');
    Route::post('/add-to-cart/{productId}', 'addToCart');
    Route::post('/order', 'submit');
    Route::get('/delete-from-cart/{productId}', 'remove');

});
