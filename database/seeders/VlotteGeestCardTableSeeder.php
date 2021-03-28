<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class VlotteGeestCardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vlotte_geest_object')->insert([
            'userId' => '',
            'correctObject' => 'ghost',
            'image' => '',
        ]);
        
    }
}
