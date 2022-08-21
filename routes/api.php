<?php

use App\Http\Controllers\AuthControllers\AuthController;
use App\Http\Controllers\MessageControllers\MessageController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('me', 'me');
    });

    Route::controller(MessageController::class)->group(function () {
        Route::post('messages','store');
    });
});
