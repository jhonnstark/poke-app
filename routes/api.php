<?php

use App\Http\Controllers\FavoritoController;
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

Route::prefix('favorito')->middleware(ValidateUuidMiddleware::class)->group(callback: function () {
    Route::post('/', [FavoritoController::class, 'store']);
    Route::delete('/', [FavoritoController::class, 'destroy']);
});
