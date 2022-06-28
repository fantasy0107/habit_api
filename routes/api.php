<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\HabitController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TaskController;

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
    Route::post('token',  [LoginController::class, 'loginByToken']);

});

Route::post('register',  [LoginController::class, 'register']);

Route::middleware('check.token')->group(function () {
    Route::put('habits/{habit}/records', [HabitController::class, 'updateHabitRecords']);
    Route::apiResource('habits', HabitController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('tasks', TaskController::class);
});


