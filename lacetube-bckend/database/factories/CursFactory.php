<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\curs>
 */
class CursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profesor_id' => User::all()->random()->id,
            'nom' => fake()->name(),
            'slug' => fake()->unique()->name(),
            'descripcio' => fake()->name(),
            'any' => fake()->numberBetween(2010,2023),       
        ];
    }
}
