<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserVideosResource;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;

class UserController extends Controller
{
    /**
     * Get all activities for current user.
     */
    public function getActivities(): JsonResponse
    {
        $user = Auth::user();
        return response()->json(ActivityResource::collection($user->activities));
    }

    /**
     * Get avatar by user ID
     */
    public function getAvatar($id = 0): JsonResponse
    {
        if ($id = 0) {
            //If no ID, get current user.
            $user = Auth::user();
        } else {
            $user = User::findOrFail($id);
        }
        return response()->json(url('/avatar/' . $user->avatar));
    }

    /**
     * Update user avatar.
     */
    public function updateAvatar(Request $request)
    {
        // If user sent an avatar, update it.
        if ($request->file('avatar')) {

            // Validate data.
            $request->validate([
                'avatar' => ['required', 'image', 'mimes:jpg,png'],
            ]);

            // Upload the new avatar.
            $avatarName = uniqid() . '.' . $request->avatar->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs(
                '',
                $avatarName,
                'avatars'
            );

            // If new avatar has been uploaded, delete the old one.
            if ($path) {
                Storage::disk('avatars')->delete('' . $request->user()->avatar);
                $request->user()->update(['avatar' => $avatarName]);

                return response()->json(['msg' => 'Avatar actualitzat correctament!', 'avatar' => $avatarName], 201);
            } else {
                return response()->json('No s\'ha pogut guardar l\'avatar!', 419);
            }
        } else {
            // If no avatar sent, generate a new one.
            $avatarName = uniqid() . '.png';
            Avatar::create($request->user()->name)->save(Storage::disk('avatars')->path($avatarName));

            // Delete old avatar and store the new one.
            Storage::disk('avatars')->delete('' . $request->user()->avatar);
            $request->user()->update(['avatar' => $avatarName]);

            return response()->json(['msg' => 'Avatar eliminat correctament!', 'avatar' => $avatarName], 201);
        }
    }

    /**
     * Get all user courses.
     */
    public function getCourses()
    {
        // Get current user.
        $user = User::find(Auth::user()->id);
        $rol = $user->getRoleNames()->toArray();

        // Get courses.
        $courses = $user->courses;

        // If user is teacher, get all courses where user is teacher.
        if (in_array("teacher", $rol)) {
            $courses = Course::where('teacher_id', Auth::user()->id)->get();
        }

        return UserCourseResource::collection($courses);
    }

    /**
     * Get a list of user videos.
     */
    public function getVideos()
    {
        $user = Auth::user();

        return UserVideosResource::collection(Video::where('user_id', '=', $user->id)->get());
    }

    /**
     * Get current user object.
     */
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Get all users stored in DB
     */
    public function getAllUsers()
    {
        return response()->json(UserResource::collection(User::all()));
    }

    /**
     * Get all teachers.
     */
    public function getAllTeachers()
    {
        return UserResource::collection(User::role('teacher')->get());
    }

    /**
     * Get all students.
     */
    public function getAllStudents()
    {
        return UserResource::collection(User::role('student')->get());
    }

    /**
     * Destroy user by id.
     */
    public function destroy($id)
    {
        //Find user and delete.
        $user = User::findOrFail($id);
        $user->delete();

        //Delete user avatar.
        Storage::disk('avatars')->delete('' . $user->avatar);
        return response()->json(null, 204);
    }
}
