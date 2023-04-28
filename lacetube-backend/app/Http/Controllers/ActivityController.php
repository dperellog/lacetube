<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $course = Course::findOrFail($request->course_id);
        if (Auth::user()->id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|date',
            'course_id' => 'exists:courses,id', 
        ]);
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
        $activity = Activity::find($id);
        if (Auth::user()->id != $activity->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|date', 
        ]);

        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->end_date = $request->end_date;
        $activity->save();
        return response()->json($activity, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
