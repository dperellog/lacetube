<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
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
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        // Get the video.
        $video = Video::findOrFail($request->video_id);

        // Validate comment data.
        $validateData = $request->validate([
            'description' => 'max:255',
            'stars' => 'required|integer',
            'video_id' => 'exists:videos,id',
            'user_id' => 'exists:users,id',
        ]);

        // Create the comment.
        $comment = Comment::create($request->all());
        return response()->json(new CommentResource($comment), 201);
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get the comment.
        $Comment = Comment::findOrFail($id);

        // Check if user comment is the owner.
        if (Auth::user()->id != $Comment->user_id) {
            // If not, fail.
            return response()->json('', 401);
        }

        // Validate comment data.
        $validateData = $request->validate([
            'description' => 'max:255',
            'stars' => 'required|integer',
        ]);

        // Update the comment.
        $Comment->stars = $request->stars;
        $Comment->description = $request->description;
        $Comment->save();
        return response()->json($Comment, 201);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy($id)
    {
        // Get the comment.
        $Comment = Comment::findOrFail($id);

        // Check if requested user is the owner, or the activity teacher or an admin.
        if (Auth::user()->id != $Comment->user_id && !User::find(Auth::user()->id)->hasRole('admin') && Auth::user()->id != $Comment->video->teacher->id) {
            // If not, fail.
            return response()->json('', 401);
        }

        // Delete the comment.
        $Comment->delete();
        return response()->json(null, 204);
    }
}
