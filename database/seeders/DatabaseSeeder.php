<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            VierOpEenRijTableSeeder::class,
            VlotteGeestTableSeeder::class,
            GanzenbordStappenSeeder::class,
            GanzenbordTableSeeder::class,
            TrivialPursuitTableSeeder::class,
            ThirtySecondsTableSeeder::class,
            GamesTableSeeder::class,
            GameSessionTableSeeder::class,
            UserInGameSessionTableSeeder::class,
        ]);
    }
}
