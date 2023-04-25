<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        //Generar Avatar:
        $avatarName = uniqid().'.png';
        $name = fake()->firstName();
        $surname = fake()->lastName();
        Avatar::create($name.' '.$surname)->save('public/avatar/'.$avatarName);

        return [
            'name' => $name.' '.$surname,
            'avatar' => $avatarName,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attr) {
            return [
                'email' => 'admin@lacetube.cat',
            ];
        });
    }

}
