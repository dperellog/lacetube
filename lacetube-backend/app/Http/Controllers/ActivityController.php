<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function getActivity($id): JsonResponse
    {
        return response()->json(new ActivityResource(Activity::findOrFail($id)));
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request)
    {
        // Validate data:
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:5000',
            'end_date' => 'required|date',
            'course_id' => 'exists:courses,id',
        ]);

        // Check if requested user is teacher or admin
        $course = Course::findOrFail($request->course_id);
        if (Auth::user()->id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')) {
            //If is not teacher or admin, fail.
            return response()->json('', 401);
        }

        //If is teacher or admin, create.
        $activity = Activity::create($request->all());
        return response()->json($activity, 201);
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get the activity:
        $activity = Activity::findOrFail($id);

        // Check if user role has permissions.
        if (Auth::user()->id != $activity->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')) {
            // If doesn't have permission, fail.
            return response()->json('', 401);
        }

        // Validate data:
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'end_date' => 'required|date',
        ]);

        // Update the activity.
        $activity->name = $request->name;
        $activity->description = $request->description;
        $activity->end_date = $request->end_date;
        $activity->save();
        return response()->json($activity, 201);
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy($id)
    {
        // Get the activity:
        $activity = Activity::findOrFail($id);

        // Check if user role has permissions.
        if (Auth::user()->id != $activity->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')) {
            // If doesn't have permission, fail.
            return response()->json('', 401);
        }

        // Delete the activity.
        $activity->delete();
        return response()->json(null, 204);
    }
}
