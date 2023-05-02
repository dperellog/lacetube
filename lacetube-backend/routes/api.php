<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Models\User;
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
        Route::group(['middleware' => ['role:admin|teacher']], function () {
            Route::get('teachers', [CourseController::class, 'getAllTeachers']);
            Route::get('students', [CourseController::class, 'getAllStudents']);
            Route::post('create', [CourseController::class, 'store']);
            Route::put('modify/{id}', [CourseController::class, 'update']);
            Route::put('students/add/{id}', [CourseController::class, 'addUserToCourse']);
            Route::post('students/remove/{id}', [CourseController::class, 'removeUserToCourse']);
        });

        Route::group(['middleware' => ['role:admin']], function () {
            Route::delete('delete/{id}', [CourseController::class, 'destroy']);
        });

        Route::get('{id}', [CourseController::class, 'getCourse'])->where('id', '[0-9]+');
    });
    Route::prefix('activity')->group(function () {
        Route::get('{id}', [ActivityController::class, 'getActivity']);
        Route::group(['middleware' => ['role:admin|teacher']], function () {
            Route::post('create', [ActivityController::class, 'store']);
            Route::put('modify/{id}', [ActivityController::class, 'update']);
        });
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
        Route::get('teachers', [UserController::class, 'getAllTeachers']);
        Route::get('students', [UserController::class, 'getAllStudents']);
        Route::get('all', [UserController::class, 'getAllUsers']);

         Route::group(['middleware' => ['role:admin']], function () {
            Route::delete('delete/{id}', [UserController::class, 'destroy']);
        });
    });

    Route::post('/register/json', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeJSON']);
});
