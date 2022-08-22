<?php

use App\Http\Controllers\AuthControllers\AuthController;
use App\Http\Controllers\MessageControllers\MessageController;
use App\Http\Controllers\UserChatControllers\UserChatController;
use App\Http\Controllers\UserControllers\UserController;
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

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index');
    });

    Route::controller(MessageController::class)->group(function () {
        Route::post('messages', 'store');
    });

    Route::controller(UserChatController::class)->group(function () {
        Route::post('user-chat', 'store');
    });
});
