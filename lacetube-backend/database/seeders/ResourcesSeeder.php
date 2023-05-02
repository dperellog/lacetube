<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create admin user:
        User::factory()->admin()->create()->assignRole('admin');

        //Create users:
        $users = User::factory()->count(30)->create();

        $users->each(function ($user) {
            $roles=['teacher','student'];
            $user->assignRole($roles[rand(0, 1)]);
        });

        //Create Courses:
        Course::factory()->orphan()->create();
        Course::factory()->count(7)->create();
        Course::factory()->count(25)->create();
        $courses = Course::all();

        //Relate Students with courses:

        //coger solo usuarios que sean estudiantes
        $users->each(function ($user) use ($courses) {
            if ($user->hasRole('student')){
            $user->courses()->attach(
                $courses->random(rand(1,$courses->count()))->pluck('id')->toArray()
            );}
        });

        //Create Activities:
        Activity::factory()->count(50)->create();

        //Create Videos and comments:
        // Video::factory()->count(100)->create();

        // Comment::factory()->count(200)->create();

    }
}
