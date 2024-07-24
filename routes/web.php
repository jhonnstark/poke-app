<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image-proxy', 'ImageProxyController@fetchImage')->name('image.proxy');
