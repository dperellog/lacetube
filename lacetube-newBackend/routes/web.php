<?php

use App\Models\Activity;
use App\Models\Course;
use App\Models\User;
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
    return ['Laravel' => app()->version()];
});

Route::get('/test', function () {

    // Test 1:
    // $curso = Course::find(23);

    // dd(
    //     $curso,
    //     $curso->parent,
    //     $curso->teacher,
    //     $curso->students
    // );

    //Test 2:
    // $actividad = Activity::find(23);

    // dd(
    //     $actividad,
    //     $actividad->videos->first()->teacher,
    //     $actividad->teacher,
    //     $actividad->students
    // );


    //Test 3:

    $user = User::find(15);
    dd($user->activities());
});

require __DIR__.'/auth.php';
