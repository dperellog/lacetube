<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
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
        Route::get('all', [CourseController::class, 'getAll']);
        Route::middleware(['nonStudent'])->group(function () {
        Route::post('create', [CourseController::class, 'store']);
        Route::put('modify/:id', [CourseController::class, 'update']);
        Route::put('students/add/{id}', [CourseController::class, 'addUserToCourse']);
        Route::delete('students/remove/:id', [CourseController::class, 'getCourses']);
        Route::get('{id}', [CourseController::class, 'getCourse']);});
    });
    Route::prefix('activity')->group(function () {
        Route::get('{id}', [ActivityController::class, 'getActivity']);
        Route::post('create', [ActivityController::class, 'store']);
        Route::put('modify/:id', [ActivityController::class, 'update']);
    });
    Route::prefix('video')->group(function () {
        Route::get('{id}', [VideoController::class, 'getVideo']);
        Route::post('create', [VideoController::class, 'store']);
        Route::put('modify/:id', [VideoController::class, 'update']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'getUser']);
        Route::get('/avatar', [UserController::class, 'getAvatar']);
        Route::get('/avatar/{id}', [UserController::class, 'getAvatar']);
        Route::get('activities', [UserController::class, 'getActivities']);
        Route::get('courses', [UserController::class, 'getCourses']);
        Route::get('videos', [UserController::class, 'getVideos']);
    });
});
