<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $games_array = ["vierOpEenRij", "vlotteGeest", "ganzenbord", "trivialPursuit", "thirtySeconds"];

        foreach($games_array as $game){
            DB::table('games')->insert([
                'name' => $game,
            ]);
        }
    }
}
