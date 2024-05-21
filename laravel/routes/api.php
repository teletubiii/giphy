<?php

use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GiphyController;
use App\Http\Middleware\CustomAuthenticate;
use App\Http\Middleware\LogServiceInteraction;


Route::post('register', [RegisterController::class, 'register'])->name('register')->middleware([LogServiceInteraction::class]);
Route::post('login', [RegisterController::class, 'login'])->name('login')->middleware([LogServiceInteraction::class]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware(['auth:api',  LogServiceInteraction::class])->group( function () {
    Route::resource('giphy', GiphyController::class);
    Route::post('/gifs/favorite', [GiphyController::class, 'storeFavorite'])->name('giphy_favorite');
});