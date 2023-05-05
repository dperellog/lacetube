<?php

namespace App\Http\Controllers;

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
        $request->content;
        switch ($request->content) {
            case "user":
                 return response()->json(User::where('name', 'LIKE', '%'.$request->search.'%')->get());
                break;
            case "course":
                return response()->json(Course::where('name', 'LIKE', '%'.$request->search.'%')->get());
                break;
            case "activity":
                return response()->json(Activity::where('name', 'LIKE', '%'.$request->search.'%')->get());
                break;
            case "video":
                return response()->json(Video::where('title', 'LIKE', '%'.$request->search.'%')->get());
                break;
            default:
            return response()->json('',404);
                
        }
    }
}