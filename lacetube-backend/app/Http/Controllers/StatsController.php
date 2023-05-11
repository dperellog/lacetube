<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;


class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function stats()
    {
        return response()->json([
            'users' => count(User::all()),
            'courses' => count(Course::all()),
            'activities' => count(Activity::all()),
            'videos' => count(Video::all()),
            'comments' => count(Comment::all()),
            'students' => count(User::role('student')->get()),
            'teachers' => count(User::role('teacher')->get())
        ]
    
        );
    }
}