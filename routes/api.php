<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TargetController;
use App\Http\Controllers\Api\TargetTagController;
use App\Http\Controllers\Api\UserTokenController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\HabitController;

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


Route::get('test/{id}', [TestController::class, 'update']);


Route::prefix('login')->group(function () {
    Route::post('/',  [LoginController::class, 'logIn']);
    Route::post('facebook',  [LoginController::class, 'loginByFacebook']);
    Route::post('google',  [LoginController::class, 'loginByGoogle']);
});

Route::post('register',  [LoginController::class, 'register']);
Route::post('user_tokens',  [UserTokenController::class, 'store']);

Route::middleware('check.token')->group(function () {

    Route::prefix('me')->group(function(){
        Route::get('habits', [HabitController::class, 'getMyHabits']);
    });
    Route::apiResource('habits', HabitController::class);
});
