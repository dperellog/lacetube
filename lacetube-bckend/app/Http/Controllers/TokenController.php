<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    public function __invoke(Request $request)
    {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    $token = $user->createToken($request->email)->plainTextToken;

    return response()->json(['token' => $token], 200);
    //return response()->json(['hola' => 'hola'], 200);
  }
}
