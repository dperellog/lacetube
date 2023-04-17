<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('course')->group(function () {
        Route::get('{id}', [CourseController::class, 'getCourse']);
        //Nomes fet fins aqui
        Route::get('create', [UserController::class, 'getCourses']);
        Route::get('modify/:id', [UserController::class, 'getCourses']);
        Route::get('students/add/:id', [UserController::class, 'getCourses']);
        Route::get('students/remove/:id', [UserController::class, 'getCourses']);
    });
    Route::prefix('user')->group(function () {
        Route::get('activities', [UserController::class, 'getActivities']);
        Route::get('courses', [UserController::class, 'getCourses']);
    });
});
