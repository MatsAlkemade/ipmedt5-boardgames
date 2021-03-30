<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GanzenbordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ganzenbord')->insert([
            'name' => 'Stap 0',
            'steps'=> 0,
        ]);
    }
}
