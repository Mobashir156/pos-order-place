<?php

use Illuminate\Support\Facades\Route;


Route::controller('ProductController')->group(function () {
    Route::get('/product/create', 'create')->name('product.create');
    Route::get('/product/edit/{id}', 'edit')->name('product.edit');
    Route::post('/product/edit/submit/{id}', 'update')->name('product.update');
    Route::get('/product/delete/{id}', 'delete')->name('product.delete');
    Route::post('/product/submit', 'submit')->name('product.submit');
});
