<?php

use App\Http\Controllers\PokemonController;
use App\Http\Middleware\ValidateUuidMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('pokemon')->middleware('uuid')->group(callback: function () {
    Route::get('/', [PokemonController::class, 'index']);
});
