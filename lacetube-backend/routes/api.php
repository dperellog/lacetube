<?php

use App\Http\Controllers\ComentariController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursController;
use App\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('curs')->controller(CursController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/crear', 'store');
    Route::get('/detail/{id}', 'show');
    Route::put('/detail/{id}', 'update');
    Route::delete('/detail/{id}', 'destroy');
});
Route::prefix('activitat')->controller(ActivitatController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/crear', 'store');
    Route::get('/detail/{id}', 'show');
    Route::put('/detail/{id}', 'update');
    Route::delete('/detail/{id}', 'destroy');
});
Route::prefix('video')->controller(VideoController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/crear', 'store');
    Route::get('/detail/{id}', 'show');
    Route::put('/detail/{id}', 'update');
    Route::delete('/detail/{id}', 'destroy');
});
Route::prefix('comentari')->controller(ComentariController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/crear', 'store');
    Route::get('/detail/{id}', 'show');
    Route::put('/detail/{id}', 'update');
    Route::delete('/detail/{id}', 'destroy');
});