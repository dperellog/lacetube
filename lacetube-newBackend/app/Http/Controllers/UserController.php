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
<<<<<<< HEAD
        return UserVideos::collection($user->videos);
=======

        return $user->videos;
        //return UserVideos::collection($user->videos);
>>>>>>> 754a1e5d201161566f6e689a87257f60271d16af
    }
}
