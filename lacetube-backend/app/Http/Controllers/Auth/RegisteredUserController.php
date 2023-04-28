<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $all_roles_in_database = Role::all()->pluck('name');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:' . implode(',', $all_roles_in_database->toArray()),
        ]);

        $avatarName = uniqid().'.png';
        Avatar::create($request->name.' hola')->save('avatar/'.$avatarName);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarName,
        ]);
        $user->assignRole($request->role);


        event(new Registered($user));

        // Auth::login($user);

        return response()->noContent();
    }

    public function storeJSON(Request $request){
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
            Avatar::create($user['name'])->save(public_path('/avatar/'.$avatarName));
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
    if (sizeof($usersIncorrectes)>0){
        return response()->json(['status'=>409,'data'=>$usersIncorrectes], 409);
    }else{
        return response()->json(['status'=>200,'data'=>$usersIncorrectes], 200);
    }
    }
}
