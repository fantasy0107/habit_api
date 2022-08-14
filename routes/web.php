<?php

use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\PostController;
use \App\Http\Controllers\Web\TaskController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login.index');
});

Route::prefix('login')->name('login.')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::post('/', [LoginController::class, 'login'])->name('create');
});

Route::prefix('register')->name('register.')->group(function () {
    Route::get('/', [LoginController::class, 'register'])->name('index');
    Route::post('/', [LoginController::class, 'postRegister'])->name('create');
});


Route::middleware('check.auth')->group(function () {
    Route::get('projects/{project}/tasks', [TaskController::class, 'getProjectTasks']);
    Route::resource('blogs', BlogController::class);
    Route::resource('posts', PostController::class);
    Route::resource('tasks', TaskController::class);
});
