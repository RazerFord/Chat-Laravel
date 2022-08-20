<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login.post');
    Route::get('login', 'index')->name('login.index');
});