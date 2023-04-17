<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserVideos;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getActivities() : JsonResponse
    {
        $user = Auth::user();
        return response()->json($user->activities);
    }
    public function getCourses()
    {
        $user = Auth::user();

        return UserCourseResource::collection($user->courses);
    }
    public function getVideos()
    {
        $user = Auth::user();

        return UserVideos::collection($user->videos);
    }
}
