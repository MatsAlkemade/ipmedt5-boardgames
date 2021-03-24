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
            GanzenbordTableSeeder::class,
            TrivialPursuitTableSeeder::class,
            ThirtySecondsTableSeeder::class,
            GameSessionTableSeeder::class,
            UserInGameSessionTableSeeder::class,
        ]);
    }
}
