<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    //Method for registring users massively.
    public function storeJSON(Request $request)
    {
        $invalidUsers = [];
        $validUsers = [];

        foreach ($request->users as $user) {
            try {

                // Validate data:
                $all_roles_in_database = Role::all()->pluck('name');
                $passwordValid = Password::min(8);
                $passwordValid->mixedCase();
                $passwordValid->numbers();

                $validator = Validator::make($user, [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:255',
                        Rule::unique(User::class),
                    ],
                    'role' => 'required|in:' . implode(',', $all_roles_in_database->toArray()),
                    'password' => ['required', $passwordValid]
                ]);

                // If fails, append to invalid users array:
                if ($validator->fails()) {
                    $invalidFields = [];

                    //Get invalid fields and append it to errors array.
                    foreach ($validator->errors()->toArray() as $field => $error) {
                        $invalidFields[$field] = $error[0];
                    }

                    $invalidUsers[] = [
                        'user' => $user,
                        'errors' => $invalidFields,
                    ];
                } else {
                    // If user validated:
                    $validated = $validator->validated();

                    // Create avatar:
                    $avatarName = uniqid() . '.png';
                    Avatar::create($user['name'])->save(Storage::disk('avatars')->path($avatarName));

                    // Store to database:
                    User::create([
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'password' => Hash::make($user['password']),
                        'avatar' => $avatarName,
                    ])->assignRole($user['role']);
                    array_push($validUsers, $user);
                }
            } catch (\Throwable $th) {
            }
        }

        // Returns:
        if (sizeof($invalidUsers) > 0) {
            return response()->json(['status' => 409, 'data' => $invalidUsers, 'validUsers' => $validUsers], 409);
        } else {
            return response()->json(['status' => 200, 'data' => $invalidUsers, 'validUsers' => $validUsers], 200);
        }
    }
}
