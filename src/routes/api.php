<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileControlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function () {
    Route::controller(ClientController::class)->group(function () {
        Route::group(['prefix' => 'client'], function () {
            Route::post('/save', 'save');
        });
    });

    Route::controller(FileControlController::class)->group(function () {
        Route::group(['prefix' => 'file'], function () {
            Route::post('/save', 'save');
            Route::post('/test', 'testParser');
        });
    });
});
