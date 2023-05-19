<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\CourseActivitiesResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserCourseResource;
use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CourseController extends Controller
{
    /**
     * Get single course by id
     */
    public function getCourse($id): JsonResponse
    {
        return response()->json(new CourseResource(Course::findOrFail($id)));
    }

    /**
     * Get all courses from DB.
     */
    public function getAll()
    {
        // Check whether requested user is.
        $user = User::find(Auth::user()->id);
        $rol = $user->getRoleNames()->toArray();
        if (in_array("admin", $rol)) {
            // If user is admin, get all courses.
            return response()->json(UserCourseResource::collection(Course::all()));
        } elseif (in_array("teacher", $rol)) {
            // If user is teacher, get all courses where user is teacher.
            return response()->json(UserCourseResource::collection(Course::where('teacher_id', '=', $user->id)->get()));
        }

        return response()->json('', 401);
    }

    /**
     * Get all activities from specific course.
     */
    public function getActivitiesFromCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        return response()->json(ActivityResource::collection($course->activities));
    }


    /**
     * Store a new course.
     */
    public function store(CourseRequest $request)
    {
        // Data comes validated from "CourseRequest" object.

        if ($request->hasFile('thumbnail')) {
            //If user has sent a thumbnail, upload it to backend.
            $thumbnailURL = $request->file('thumbnail')->store('', 'thumbnails');
        } else {
            //If user hasn't sent a thumbnail, apply the default one.
            $thumbName = Str::random(20) . '.png';
            $thumbnailURL = $thumbName;

            Storage::copy('defaults/thumbnail.png', 'thumbnails/' . $thumbName);
        }

        // Create the course.
        $course = Course::create([
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'description' => $request->description,
            'thumbnailURL' => $thumbnailURL,
            'year' => $request->year,
            'parent_id' => $request->parent_id,
        ]);

        // Add students to course:
        foreach (json_decode($request->students) as $student) {
            $user = User::findOrFail($student);
            $user->courses()->attach($course);
        }

        return response()->json($course, 201);
    }

    /**
     * Update an existing course.
     */
    public function update(CourseRequest $request, $id)
    {
        // Data comes validated from "CourseRequest" object.

        // Get requested course.
        $course = Course::findOrFail($id);

        // Check if user is allowed.
        if ($request->teacher_id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')) {
            // If not, fail.
            return response()->json('', 401);
        }

        // If user sent a new thumbnail, replace it.
        if ($request->hasFile('thumbnail')) {
            //Delete current thumbnail
            Storage::disk('thumbnails')->delete($course->thumbnailURL);

            //Store new thumbnail.
            $thumbnailURL = $request->file('thumbnail')->store('', 'thumbnails');
            $course->thumbnailURL = $thumbnailURL;
        }

        // Update the course.
        $course->teacher_id = $request->teacher_id;
        $course->name = $request->name;
        $course->description = $request->description;
        $course->year = $request->year;
        $course->parent_id = $request->parent_id;
        $course->save();

        // Update the students.
        $students = $course->students;
        $requestStudents = json_decode($request->students);

        //Attatch newly users to course:
        foreach ($requestStudents as $student) {
            $user = User::findOrFail($student);

            if (!$students->contains($user)) {
                $user->courses()->attach($course);
            }
        }

        //Detach users to course:
        foreach ($students as $student) {
            if (!in_array($student->id, $requestStudents)) {
                $student->courses()->detach($course);
            }
        }

        return response()->json($course, 201);
    }

    /**
     * Attatch users to course via API
     */
    public function addUserToCourse(Request $request, $id)
    {
        $usersFailed = [];
        $course = Course::findOrFail($id);
        $students = $course->students;
        foreach ($request->users as $user) {
            try {
                $user = User::findOrFail($user);
                if (!$students->contains($user)) {
                    $user->courses()->attach($course);
                } else {
                    throw new Exception("", 1);
                }
            } catch (\Throwable $th) {
                array_push($usersFailed, $user);
            }
        }
        return $usersFailed;
    }

    /**
     * Dettach users to course via API
     */
    public function removeUserToCourse(Request $request, $id)
    {
        $usersFailed = [];
        $course = Course::findOrFail($id);
        $students = $course->students;

        foreach ($request->users as $user) {
            try {
                $user = User::findOrFail($user);
                if ($students->contains($user)) {
                    $user->courses()->detach($course);
                } else {
                    throw new Exception("", 1);
                }
            } catch (\Throwable $th) {
                array_push($usersFailed, $user);
            }
        }
        return $usersFailed;
    }

    /**
     *
     */
    public function destroy($id)
    {
        //Get the course:
        $course = Course::findOrFail($id);

        // Check if user role has permissions.
        if (Auth::user()->id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')) {
            // If doesn't have permission, fail.
            return response()->json('', 401);
        }

        // Delete the course.
        $course->delete();
        return response()->json(null, 204);
    }
}
