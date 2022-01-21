<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HabitController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('login')->group(function () {
    Route::post('/',  [LoginController::class, 'logIn']);
    Route::post('facebook',  [LoginController::class, 'loginByFacebook']);
    Route::post('google',  [LoginController::class, 'loginByGoogle']);
});

Route::post('register',  [LoginController::class, 'register']);

Route::middleware('check.token')->group(function () {
    Route::apiResource('habits', HabitController::class);
});
