<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserVideosResource;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Display a listing of the search resoults.
     */
    public function search(Request $request)
    {
        // Check if user is authenticated.
        $userAuthenticated = Auth::check();

        // If is not authenticated and is not searching a video, fail.
        if (!$userAuthenticated && $request->content != 'video') {
            return response()->json('', 401);
        }

        // Get what user is searching.
        $request->content;

        // Search to DB and return:
        switch ($request->content) {
            case "user":
                return response()->json(UserResource::collection(User::where('name', 'LIKE', '%' . $request->search . '%')->get()));
                break;
            case "course":
                return response()->json(CourseResource::collection(Course::where('name', 'LIKE', '%' . $request->search . '%')->get()));
                break;
            case "video":
                return response()->json(UserVideosResource::collection(Video::where('title', 'LIKE', '%' . $request->search . '%')->get()));
                break;
            default:

                return response()->json('', 404);
        }
    }
}
