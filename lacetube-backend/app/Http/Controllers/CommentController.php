<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        if (Auth::user()->id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }
        $validateData = $request->validate([
            'description' => 'required|max:255',
            'starts' => 'required|integer',
            'end_date' => 'required|date',
            'course_id' => 'exists:courses,id',
            'user_id' => 'exists:users,id', 
        ]);
        $Comment = Comment::create($request->all());
        return response()->json($Comment, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Comment = Comment::find($id);
        if (Auth::user()->id != $Comment->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|date', 
        ]);

        $Comment->name = $request->name;
        $Comment->description = $request->description;
        $Comment->end_date = $request->end_date;
        $Comment->save();
        return response()->json($Comment, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $Comment = Comment::findOrFail($id);
         $Comment->delete();
         return response()->json(null, 204);

    }

}
