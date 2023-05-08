<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
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
        $video = Video::findOrFail($request->video_id);
        $validateData = $request->validate([
            'description' => 'max:255',
            'starts' => 'required|integer',
            'video_id' => 'exists:videos,id',
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
        $Comment = Comment::findOrFail($id);
        if (Auth::user()->id != $Comment->user_id) {
            return response()->json('', 401);
        }
        $validateData = $request->validate([
            'description' => 'max:255',
            'starts' => 'required|integer',
        ]);

        $Comment->starts = $request->starts;
        $Comment->description = $request->description;
        $Comment->save();
        return response()->json($Comment, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Comment = Comment::findOrFail($id);
        if (Auth::user()->id != $Comment->user_id && !User::find(Auth::user()->id)->hasRole('admin') && Auth::user()->id != $Comment->video->teacher->id) {
            return response()->json('', 401);
        }
        $Comment->delete();
        return response()->json(null, 204);
    }
}
