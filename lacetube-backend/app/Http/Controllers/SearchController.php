<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserVideosResource;
use App\Models\Activity;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $userAuthenticated = Auth::check();

        if (!$userAuthenticated && $request->content != 'video') {
            return response()->json('',401);
        }
        $request->content;
        switch ($request->content) {
            case "user":
                 return response()->json(UserResource::collection(User::where('name', 'LIKE', '%'.$request->search.'%')->get()));
                break;
            case "course":
                return response()->json(CourseResource::collection(Course::where('name', 'LIKE', '%'.$request->search.'%')->get()));
                break;
            case "video":
                return response()->json(UserVideosResource::collection(Video::where('title', 'LIKE', '%'.$request->search.'%')->get()));
                break;
            default:
            return response()->json('',404);

        }
    }
}
