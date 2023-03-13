<?php

use App\Http\Controllers\CursController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('curs')->group(function () {
        Route::get('tots', [CursController::class, 'index'] );
    });

    Route::prefix('curs')->group(function () {
        Route::get('tots', [CursController::class, 'index'] );
    });
});
