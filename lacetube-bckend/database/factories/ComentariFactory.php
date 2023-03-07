<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\comentari>
 */
class ComentariFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creatPer' => User::all()->random()->id,
            'video_id' => video::all()->random()->id,
            'valoracio' => fake()->numberBetween(0,5),
            'descripcio' => fake()->name(),  
        ];
    }
}
