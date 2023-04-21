<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserVideos;
use App\Http\Resources\UserVideosResource;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getActivities() : JsonResponse
    {
        $user = Auth::user();
        return response()->json($user->activities);
    }
    public function getAvatar($id=0) : JsonResponse
    {
        if ($id=0){
            $user = Auth::user();    
        }else{
            $user = User::findOrFail($id);
        }
        return response()->json(url('/avatar/'.$user->avatar));
    }
    public function getCourses()
    {
        $user = Auth::user();

        return UserCourseResource::collection($user->courses);
    }
    public function getVideos()
    {
        $user = Auth::user();

        return UserVideosResource::collection(Video::where('user_id', '=', $user->id)->get());
    }
    public function getUser(){
        // $user = Auth::user();
        // return new UserResource($user);
        return response()->json(User::role('teacher')->get());
    }
}
