<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Search\CurrencySearchController;
use App\Http\Controllers\Search\CurrencyDetailsController;
use App\Http\Controllers\Search\CurrencyVolumeController;

/**
 * the auth related routes
 */
Route::name('auth')
    ->prefix('/auth')
    ->group(function () {

        /**
         * doing the login
         */
        Route::post('/login', [LoginController::class, 'do'])
            ->name('login');

        /**
         * doing the logout
         */
        Route::post('/logout', [LogoutController::class, 'do'])
            ->name('logout')
            ->middleware(['auth:api']);

    });

/**
 * the search and currencies related routes
 */
Route::name('search')
    ->prefix('/search')
    ->middleware(['auth:api'])
    ->group(function () {

        /**
         * returning list of currencies
         */
        Route::get('/currencies', [CurrencySearchController::class, 'getCurrencies'])
            ->name('currencies');

        /**
         * returning details of selected currency
         */
        Route::get('/details/{symbol}', [CurrencyDetailsController::class, 'getDetails'])
            ->name('details');

        /**
         * returning volume of specific dates
         */
        Route::get('/volume', [CurrencyVolumeController::class, 'get'])
            ->name('volume');

    });