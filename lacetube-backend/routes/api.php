<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RecomendedController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatsController;
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

Route::get('video/{id}', [VideoController::class, 'getVideo']);
Route::get('streaming/{id}', [VideoController::class, 'stream']);
Route::post('/search/json', [SearchController::class, 'search']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('course')->group(function () {
        Route::get('all', [CourseController::class, 'getAll']);
        Route::group(['middleware' => ['role:admin|teacher']], function () {
            Route::get('teachers', [CourseController::class, 'getAllTeachers']);
            Route::get('students', [CourseController::class, 'getAllStudents']);
            Route::post('create', [CourseController::class, 'store']);
            Route::post('modify/{id}', [CourseController::class, 'update']);
            Route::put('students/add/{id}', [CourseController::class, 'addUserToCourse']);
            Route::post('students/remove/{id}', [CourseController::class, 'removeUserToCourse']);
        });

        Route::group(['middleware' => ['role:admin']], function () {
            Route::delete('delete/{id}', [CourseController::class, 'destroy']);
        });

        Route::get('activities/{id}', [CourseController::class, 'getActivitiesFromCourse'])->where('id', '[0-9]+');
        Route::get('{id}', [CourseController::class, 'getCourse'])->where('id', '[0-9]+');
    });
    Route::prefix('activity')->group(function () {
        Route::group(['middleware' => ['role:admin|teacher']], function () {
            Route::post('create', [ActivityController::class, 'store']);
            Route::put('modify/{id}', [ActivityController::class, 'update']);
            Route::delete('delete/{id}', [ActivityController::class, 'destroy']);
        });

        Route::get('{id}', [ActivityController::class, 'getActivity']);
    });
    Route::prefix('comment')->group(function () {
        Route::post('create', [CommentController::class, 'store']);
        Route::put('modify/{id}', [CommentController::class, 'update']);
        Route::delete('delete/{id}', [CommentController::class, 'destroy']);
    });

    Route::prefix('video')->group(function () {
        Route::post('upload-video', [VideoController::class, 'store']);
        Route::post('modify/{id}', [VideoController::class, 'update']);
        Route::delete('delete/{id}', [VideoController::class, 'destroy']);
        Route::get('task/{id}', [VideoController::class, 'getByTask']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/avatar', [UserController::class, 'getAvatar']);
        Route::get('/avatar/{id}', [UserController::class, 'getAvatar']);
        Route::post('update-avatar', [UserController::class, 'updateAvatar']);
        Route::get('activities', [UserController::class, 'getActivities']);
        Route::get('courses', [UserController::class, 'getCourses']);
        Route::get('videos', [UserController::class, 'getVideos']);
        Route::get('teachers', [UserController::class, 'getAllTeachers']);
        Route::get('students', [UserController::class, 'getAllStudents']);
        Route::get('all', [UserController::class, 'getAllUsers']);
        Route::get('/{id}', [UserController::class, 'getUser']);

        Route::group(['middleware' => ['role:admin']], function () {
            Route::delete('delete/{id}', [UserController::class, 'destroy']);
        });
    });

    Route::post('/register/json', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeJSON']);
    Route::get('/stats', [StatsController::class, 'stats']);
    Route::get('/recomended/{id}', [RecomendedController::class, 'recomended']);

    Route::post('update-password', [NewPasswordController::class, 'updatePassword']);
});
