<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class VlotteGeestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vlotte_geest')->insert([
            'name' => 'Vlotte Geest',
        ]);
    }
}
