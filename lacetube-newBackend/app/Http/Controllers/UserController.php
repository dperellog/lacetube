<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getActivities() : JsonResponse
    {
        $user = Auth::user();
        return response()->json($user->activities);
    }
    public function getCourses() : JsonResponse
    {
        $user = Auth::user();
        return response()->json($user->courses);
    }
}
