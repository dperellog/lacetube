<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\UserCourseResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserVideos;
use App\Http\Resources\UserVideosResource;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getActivities(): JsonResponse
    {
        $user = Auth::user();
        return response()->json(ActivityResource::collection($user->activities));
    }
    public function getAvatar($id = 0): JsonResponse
    {
        if ($id = 0) {
            $user = Auth::user();
        } else {
            $user = User::findOrFail($id);
        }
        return response()->json(url('/avatar/' . $user->avatar));
    }
    public function updateAvatar(Request $request)
    {
        //Si l'usuari envia un avatar, actualitzar:
        if ($request->file('avatar')) {
            $request->validate([
                'avatar' => ['required', 'image', 'mimes:jpg,png'],
            ]);

            //Generar nom per l'avatar
            $avatarName = uniqid() . '.' . $request->avatar->getClientOriginalExtension();
            //Guardar la imatge
            $path = $request->file('avatar')->storeAs(
                '',
                $avatarName,
                'avatars'
            );

            //Si la imatge s'ha guardat, eliminar l'antiga.
            if ($path) {
                Storage::disk('avatars')->delete('' . $request->user()->avatar);
                $request->user()->update(['avatar' => $avatarName]);

                return response()->json(['msg' => 'Avatar actualitzat correctament!', 'avatar' => $avatarName], 201);
            } else {
                return response()->json('No s\'ha pogut guardar l\'avatar!', 419);
            }

            //Si l'usuari no envia cap avatar, generar-ne un de nou.
        } else {

            //Generar nou avatar:
            $avatarName = uniqid().'.png';
            Avatar::create($request->user()->name)->save(Storage::disk('avatars')->path($avatarName));

            //Eliminar avatar antic i actualitzar al nou.
            Storage::disk('avatars')->delete(''.$request->user()->avatar);
            $request->user()->update(['avatar' => $avatarName]);

            return response()->json(['msg' => 'Avatar eliminat correctament!', 'avatar' => $avatarName], 201);
        }

    }

    public function getCourses()
    {
        $user = User::find(Auth::user()->id);
        $rol = $user->getRoleNames()->toArray();
        $courses = $user->courses;

        if (in_array("teacher", $rol)) {
            $courses = Course::where('teacher_id', Auth::user()->id)->get();
        }

        return UserCourseResource::collection($courses);
    }
    public function getVideos()
    {
        $user = Auth::user();

        return UserVideosResource::collection(Video::where('user_id', '=', $user->id)->get());
    }
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
        //return response()->json(User::role('teacher')->get());
    }

    public function getAllUsers()
    {
        return response()->json(UserResource::collection(User::all()));
    }

    public function getAllTeachers()
    {
        $user = Auth::user();


        // if ($user) {
        //     $userRole =
        // }
        return UserResource::collection(User::role('teacher')->get());
    }

    public function getAllStudents()
    {
        $user = Auth::user();


        // if ($user) {
        //     $userRole =
        // }
        return UserResource::collection(User::role('student')->get());
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
