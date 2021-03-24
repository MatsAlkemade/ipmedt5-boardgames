<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ThirtySecondsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thirty_seconds')->insert([
            'name' => 'Thirty Seconds',
        ]);
    }
}
