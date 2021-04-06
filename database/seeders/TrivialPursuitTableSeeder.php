<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trivial_pursuit')->insert([
            'name' => 'Trivial Pursuit',
            'description' => "Een trivia spel waar je kennis op de proef wordt gesteld",
        ]);
    }
}
