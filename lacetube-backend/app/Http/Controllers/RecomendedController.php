<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserVideosResource;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;


class RecomendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function recomended($id)
    {

        $recomendedVideos = collect();

        $video = Video::findOrFail($id);

        $interestedUsers = collect($video->activity->students->add($video->activity->teacher))->shuffle()->flatten();


        foreach ($interestedUsers as $user) {
            $userVideos = collect($user->videos)->shuffle()->take(rand(3, 5));
            $recomendedVideos->push($userVideos);
        }

        return response()->json(UserVideosResource::collection($recomendedVideos->flatten())->slice(0,20));
    }
}
