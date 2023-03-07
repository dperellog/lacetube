<?php

namespace Database\Factories;

use App\Models\activitat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\video>
 */
class VideoFactory extends Factory
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
            'activitat_id' => activitat::all()->random()->id,
            'titol' => fake()->name(),
            'descripcio' => fake()->name(),
            'media' => fake()->name(),
        ];
    }
}
