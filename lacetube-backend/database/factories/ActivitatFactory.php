<?php

namespace Database\Factories;

use App\Models\Curs;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\activitat>
 */
class ActivitatFactory extends Factory
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
            'curs_id' => Curs::all()->random()->id,
            'dataFinal' => fake()->date(),
            'titol' => fake()->name(),
            'slug' => fake()->unique()->name(),
            'contingut' => fake()->name(),
        ];
    }
}
