<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GameSessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_session')->insert([
            'game_name' => 'Ganzenbord',
        ]);
    }
}
