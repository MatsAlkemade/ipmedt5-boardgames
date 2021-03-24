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
        $games_array = ["Vier Op Een Rij", "Vlotte Geest", "Ganzenbord", "Trivial Pursuit", "Thirty Seconds"];

        foreach($games_array as $game){
            DB::table('games')->insert([
                'name' => $game,
            ]);
        }
    }
}
