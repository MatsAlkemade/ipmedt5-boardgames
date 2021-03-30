<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class VlotteGeestObjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vlotte_geest_object')->insert([
            'color' => 'white',
            'shape' => 'ghost',
        ]);

        DB::table('vlotte_geest_object')->insert([
            'color' => 'grey',
            'shape' => 'bathtub',
        ]);

        DB::table('vlotte_geest_object')->insert([
            'color' => 'red',
            'shape' => 'carpet',
        ]);

        DB::table('vlotte_geest_object')->insert([
            'color' => 'green',
            'shape' => 'frog',
        ]);

        DB::table('vlotte_geest_object')->insert([
            'color' => 'blue',
            'shape' => 'brush',
        ]);

    }
}
