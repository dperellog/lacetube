<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stars' => fake()->numberBetween(1,5),
            'description' => fake()->paragraph(),
            'user_id' => User::all()->random()->id,
            'video_id' => Video::all()->random()->id
        ];
    }
}
