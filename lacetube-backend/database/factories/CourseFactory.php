<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'thumbnailURL' => fake()->imageUrl(),
            'year' => fake()->year(),
            //User where role teacher
            'teacher_id' =>User::role('teacher')->get()->random()->id,
            'parent_id' => Course::all()->isEmpty() ? 0 : Course::all()->random()->id
        ];
    }

    public function orphan(): Factory
    {
        return $this->state(function (array $attributes){
            return [
                'parent_id' => null
            ];
        });
    }
}
