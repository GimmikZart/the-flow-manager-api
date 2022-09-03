<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /* CON FAKER  -------------------------------------------------- */
        \App\Models\Student::factory(10)->create();
        \App\Models\Teacher::factory(10)->create();

        /* PERSONALIZZATI ---------------------------------------------- */
        DB::table('courses')->insert([

            [
                'name' => 'Popping',
                'price' => 70,
            ],
            [
                'name' => 'Locking',
                'price' => 70,
            ],
            [
                'name' => 'Pilates',
                'price' => 70,
            ]

        ]);
    }
}
