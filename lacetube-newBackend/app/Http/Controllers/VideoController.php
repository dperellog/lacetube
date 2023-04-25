<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function getVideo($id): JsonResponse
    {
        return response()->json(Video::findOrFail($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $video = Video::create($request->all());
        return response()->json($video, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:video|max:255',
            'description' => 'max:255',
            'mediaURL' => 'required|max:255|url',
            'activity_id' => 'exists:activity,id', // no se si es curs course o courses
            'user_id' => 'exists:user,id', // no se si es curs course o courses
        ]);

        $video = Video::find($id);

        $video->name = $request->name;
        $video->description = $request->description;
        $video->mediaURL = $request->mediaURL;
        $video->activity_id = $request->activity_id;
        $video->user_id = $request->user_id;
        $video->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
