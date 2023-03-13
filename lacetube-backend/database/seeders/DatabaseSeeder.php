<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::factory(10)->create();
        \App\Models\Curs::factory(5)->create();
        \App\Models\activitat::factory(20)->create();
        \App\Models\Video::factory(50)->create();
        \App\Models\Comentari::factory(100)->create();
        $usuaris=\App\Models\User::all();
        $cursos=\App\Models\Curs::all();
        for ($i=0; $i < 35 ; $i++) {
            DB::table('curs_usuari')->insert([
                'curs_id' => $cursos->random()->id,
                'alumne_id' => $usuaris->unique()->random()->id
            ]);
        }


    }
}
