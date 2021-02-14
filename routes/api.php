<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TargetController;
use App\Http\Controllers\Api\UserTokenController;
use App\Http\Controllers\Api\TopicController;

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


Route::get('test', function () {
    return 123;
});


Route::post('login',  [LoginController::class, 'logIn']);
Route::post('register',  [LoginController::class, 'register']);

Route::post('user_tokens',  [UserTokenController::class, 'store']);

Route::middleware('check.token')->group(function () {
    Route::prefix('targets')->group(function () {
        Route::get('/', [TargetController::class, 'index']);
        Route::post('/', [TargetController::class, 'store']);
        Route::patch('{target}', [TargetController::class, 'update']);
    });

    Route::prefix('topics')->group(function () {
        Route::get('/', [TopicController::class, 'index']);
        Route::post('/', [TopicController::class, 'store']);
    });
});
