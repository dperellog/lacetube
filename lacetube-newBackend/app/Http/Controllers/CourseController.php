<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourse($id): JsonResponse
    {
        return response()->json(Course::findOrFail($id));
    }
    public function store(Request $request)
    {

        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'teacher' => 'exists:users,id',
            'name' => 'required|unique:course|max:255',
            'thumbnailURL' => 'url',
            'description' => 'required|max:255',
            'year' => 'required|max:255',
            'parent' => 'exists:curs,id',
        ]);

        $course = Course::find($id);

        $course->teacher = $request->teacher;
        $course->name = $request->name;
        $course->description = $request->description;
        $course->thumbnailURL = $request->thumbnailURL;
        $course->year = $request->year;
        $course->parent = $request->parent;
        $course->save();
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
                    $user->courses()->delete($course);
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
