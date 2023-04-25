<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getActivity($id): JsonResponse
    {
        return response()->json(Activity::findOrFail($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $activity = Activity::create($request->all());
        return response()->json($activity, 201);
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
            'teacher' => 'exists:users,id',
            'name' => 'required|unique:activity|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|max:255',
            'course_id' => 'exists:curs,id', // no se si es curs course o courses
        ]);

        $activity = Activity::find($id);

        $activity->teacher = $request->teacher;
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->thumbnailURL = $request->thumbnailURL;
        $activity->year = $request->year;
        $activity->parent = $request->parent;
        $activity->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
