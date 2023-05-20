<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserVideosResource;
use App\Models\Video;


class RecomendedController extends Controller
{
    /**
     * Display a listing of recomended videos.
     */
    public function recomended($id)
    {
        // Init the return collection.
        $recomendedVideos = collect();

        // Get the current video.
        $video = Video::findOrFail($id);

        // Get all users of the course and teacher.
        $interestedUsers = collect($video->activity->students->add($video->activity->teacher))->shuffle()->flatten();

        // For all users, get between 3 and 5 random videos.
        foreach ($interestedUsers as $user) {
            $userVideos = collect($user->videos)->shuffle()->take(rand(3, 5));

            // Push it to the collection.
            $recomendedVideos->push($userVideos);
        }

        return response()->json(UserVideosResource::collection($recomendedVideos->flatten())->slice(0, 20));
    }
}
