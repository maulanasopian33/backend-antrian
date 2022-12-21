<?php

use App\Http\Controllers\API\antrianController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
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

Route::prefix('v1')->group(function() {
    Route::post('register', "App\Http\Controllers\API\UsersController@register");
    Route::post('login', "App\Http\Controllers\API\UsersController@postlogin");
    Route::get('login', "App\Http\controllers\API\UsersController@index")->name('login');
    Route::apiResource("loket","App\Http\Controllers\API\LoketController")->middleware('auth:api');
    Route::apiResource('antrian',antrianController::class)->middleware('auth:api');
});
// Route::post('login',UsersController::class);
