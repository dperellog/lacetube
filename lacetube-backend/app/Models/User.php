<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relate with courses where user is student.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user','course');
    }

    /**
     * Relate with all the videos user has uploaded.
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'user');
    }

    /**
     * Get all courses where user is student, teacher or if is admin get all.
     */
    public function getAllCoursesAttribute() {
        if (in_array("admin", $this->getRoleNames()->toArray())){
            return Course::all();
        }elseif(in_array("teacher", $this->getRoleNames()->toArray())){
            return Course::where('teacher_id', '=', $this->id)->get();
        }else{
            return $this->courses;
        }
    }

    /**
     * Get all activities of courses where user is student.
     */
    public function getActivitiesAttribute()
    {
       $activities = $this->allCourses->flatMap(function ($course) {
        return $course->activities->map(function ($activity) {
            $activity->course_name = $activity->course->name;
            return $activity;
        });
        });

        return $activities;
    }

    /**
     * Get all videos of the user.
     */
    public function getVideosAttribute()
    {
       $videos = $this->activities->flatMap(function ($activity) {
        return $activity->videos->filter(function ($video) {
            return $video->user_id == $this->id;
        });
    });
        return $videos;
    }
}
