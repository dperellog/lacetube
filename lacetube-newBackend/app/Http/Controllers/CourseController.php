<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCourseResource;
use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function getCourse($id): JsonResponse
    {
        return response()->json(Course::findOrFail($id));
    }

    public function getAll()
    {
        $user = User::find(Auth::user()->id);
        $rol=$user->getRoleNames()->toArray();
        if (in_array("admin", $rol)){
            return response()->json(UserCourseResource::collection(Course::all()));
        }elseif(in_array("teacher", $rol)){
            return response()->json(UserCourseResource::collection(Course::where('teacher_id', '=', $user->id)->get()));
        }

        return response()->json('',401);
    }

    public function getAllTeachers()
    {
        $user = Auth::user();


        // if ($user) {
        //     $userRole =
        // }
        return UserCourseResource::collection(User::role('teacher')->get());
    }

    public function getAllStudents()
    {
        $user = Auth::user();


        // if ($user) {
        //     $userRole =
        // }
        return UserCourseResource::collection(User::role('student')->get());
    }


    public function store(Request $request)
    {

        $validateData = $request->validate([
             'teacher_id' => 'exists:users,id',
             'name' => 'required|max:255',
             'thumbnailURL' => 'url',
             'description' => 'required|max:255',
             'year' => 'required|max:255',
             'parent_id' => 'exists:courses,id',
         ]);
         $course = Course::create([
             'teacher_id' => $request->teacher_id,
             'name' => $request->name,
             'description' => $request->description,
             'thumbnailURL' => $request->thumbnailURL,
             'year' => $request->year,
             'parent_id' => $request->parent_id,
         ]);
         return response()->json($course, 201);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        if ($request->teacher_id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }
        $validateData = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'thumbnailURL' => 'url',
            'description' => 'required|max:255',
            'year' => 'required|max:255',
            'parent_id' => 'exists:courses,id',
        ]);
        $course->teacher_id = $request->teacher_id;
        $course->name = $request->name;
        $course->description = $request->description;
        $course->thumbnailURL = $request->thumbnailURL;
        $course->year = $request->year;
        $course->parent_id = $request->parent_id;
        $course->save();
        return response()->json($course, 201);
    }

    public function addUserToCourse(Request $request, $id)
    {
        $usersFailed=[];
        $course = Course::findOrFail($id);
        $students= $course->students;
        foreach ($request->users as $user) {
            try {
                $user = User::findOrFail($user);
                if (!$students->contains($user)){
                    $user->courses()->attach($course);
                }else{
                    throw new Exception("", 1);
                }

            } catch (\Throwable $th) {
                array_push($usersFailed, $user);
            }
        }
        return $usersFailed;

    }
    public function removeUserToCourse(Request $request, $id)
    {
        $usersFailed=[];
        $course = Course::findOrFail($id);
        $students= $course->students;
        
        foreach ($request->users as $user) {
            try {
                $user = User::findOrFail($user);
                if ($students->contains($user)){
                    $user->courses()->detach($course);
                }else{
                    throw new Exception("", 1);
                }

            } catch (\Throwable $th) {
                array_push($usersFailed, $user);
            }
        }
        return $usersFailed;

    }


    public function destroy($id)
    {
         $course = Course::findOrFail($id);
         $course->delete();
         return response()->json(null, 204);
        
    }
}
