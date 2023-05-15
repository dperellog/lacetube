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
    public function getCourse($id): JsonResponse
    {

        return response()->json(new CourseResource(Course::findOrFail($id)));
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

    public function getActivitiesFromCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        return response()->json(ActivityResource::collection($course->activities));
    }


    public function store(CourseRequest $request)
    {

         if ($request->hasFile('thumbnail')) {
            //If user has sent a thumbnail, upload it to backend.
            $thumbnailURL = $request->file('thumbnail')->store('', 'thumbnails');
         } else {
            //If user hasn't sent a thumbnail, apply the default one.
            $defaultThumb = Storage::disk('defaults')->path('thumbnail.png');

            $thumbName = Str::random(20).'.png';
            $thumbnailURL = $thumbName;

            //return response()->json($defaultThumb, 419);
            Storage::copy('defaults/thumbnail.png', 'thumbnails/'.$thumbName);

         }


         $course = Course::create([
             'teacher_id' => $request->teacher_id,
             'name' => $request->name,
             'description' => $request->description,
             'thumbnailURL' => $thumbnailURL,
             'year' => $request->year,
             'parent_id' => $request->parent_id,
         ]);

         //Add users to course:
         foreach (json_decode($request->students) as $student) {
            $user = User::findOrFail($student);

            $user->courses()->attach($course);
         }

         return response()->json($course, 201);
    }

    public function update(CourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);
        if ($request->teacher_id != $course->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('thumbnails')->delete($course->thumbnailURL);
            $thumbnailURL = $request->file('thumbnail')->store('', 'thumbnails');
            $course->thumbnailURL = $thumbnailURL;
         }

        $course->teacher_id = $request->teacher_id;
        $course->name = $request->name;
        $course->description = $request->description;
        $course->year = $request->year;
        $course->parent_id = $request->parent_id;
        $course->save();


        $students= $course->students;
        $requestStudents = json_decode($request->students);

        //Add users to course:
        foreach ($requestStudents as $student) {
            $user = User::findOrFail($student);

            if (!$students->contains($user)){
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
