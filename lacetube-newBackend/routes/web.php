<?php

use App\Models\Activity;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use PhpParser\Node\Stmt\TryCatch;
use Laravolt\Avatar\Facade as Avatar;

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
Route::post('/register/json', function (Request $request) {
    $usersIncorrectes=[];
    $usersIncorrectes2=[];
    foreach ($request->users as $user) {
        try {
            $all_roles_in_database = Role::all()->pluck('name');
            Validator::make($user, [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'role' => 'required|in:' . implode(',', $all_roles_in_database->toArray()),
            'password' => 'required',
            ])->validate();
            $avatarName = uniqid().'.png';
            Avatar::create($user['name'])->save('public/avatar/'.$avatarName);
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'avatar' => $avatarName,
            ])->assignRole($user['role']);
            array_push($usersIncorrectes2, $user);
        } catch (\Throwable $th) {

            $user['error']=$th->getMessage();

            array_push($usersIncorrectes, $user);
        }

    }
    return response()->json(['status'=>200,'data'=>$usersIncorrectes]); // retorna array de users
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

require __DIR__.'/auth.php';
