<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //Create users:
        $users = User::factory()->count(30)->create();

        //Create Courses:
        Course::factory()->orphan()->create();
        Course::factory()->count(7)->create();
        Course::factory()->count(25)->create();
        $courses = Course::all();

        //Relate Users with courses:
        $users->each(function ($user) use ($courses) {
            $user->courses()->attach(
                $courses->random(rand(1,$courses->count()))->pluck('id')->toArray()
            );
        });

        //Create Activities:
        Activity::factory()->count(50)->create();

        //Create Videos and comments:
        Video::factory()->count(100)->create();

        Comment::factory()->count(200)->create();

    }
}
