<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserInGameSessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_in_game_session')->insert([
            'user_id' => 1,
            'game_session_id' => 1,
            'position' => 0,
        ]);
    }
}
