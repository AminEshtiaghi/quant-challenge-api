<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Search\CurrencySearchController;
use App\Http\Controllers\Search\CurrencyDetailsController;

Route::post('/auth/login', [LoginController::class, 'do'])
    ->name('auth.login');

Route::post('/auth/logout', [LogoutController::class, 'do'])
    ->name('auth.logout')
    ->middleware(['auth:api']);

Route::get('/search/currencies', [CurrencySearchController::class, 'getCurrencies'])
    ->name('search.currencies')
    ->middleware(['auth:api']);

Route::get('/search/details/{symbol}', [CurrencyDetailsController::class, 'getDetails'])
    ->name('search.details')
    ->middleware(['auth:api']);