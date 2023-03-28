<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use PhpParser\Node\Stmt\TryCatch;

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

Route::middleware('auth:sanctum')->get('/home', function () {
    return 'funciona';
});

Route::post('/register/json', function (Request $request) {
    $usersIncorrectes=[];
    $usersIncorrectes2=[];
    foreach ($request->usuaris as $user) {
        try {
            Validator::make($user, [
                'nick' => ['required', 'string', 'max:255', Rule::unique(User::class)],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
            'password' => 'required',
            ])->validate();
            User::create($user);
            array_push($usersIncorrectes2, $user);
        } catch (\Throwable $th) {
            
            $user['error']=$th->getMessage();
            
            array_push($usersIncorrectes, $user);
        }
        
    }
    return response()->json(['status'=>200,'data'=>$usersIncorrectes]);
    // {
    //     "usuaris" : [
    //         {
    //             "nick": "prova1",
    //             "email": "prova1@prova.com",
    //             "password": "1qazZAQ!",
    //             "password_confirmation": "1qazZAQ!",
    //             "rol": "admin"
    //         },
    //         {
    //             "nick": "prova2",
    //             "email": "prova2@prova.com",
    //             "password": "1qazZAQ!",
    //             "password_confirmation": "1qazZAQ!",
    //             "rol": "admin"
    //         },
    //         {
    //             "nick": "prova3",
    //             "email": "prova3@prova.com",
    //             "password": "1qazZAQ!",
    //             "password_confirmation": "1qazZAQ!",
    //             "rol": "admin"
    //         }
    
    //     ]
    // }
    
});
