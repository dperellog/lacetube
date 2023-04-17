<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourse($id) : JsonResponse
    {
        return response()->json(Course::findOrFail($id));
    }
}
