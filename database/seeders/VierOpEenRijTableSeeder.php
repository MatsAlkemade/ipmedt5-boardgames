<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class VierOpEenRijTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vier_op_een_rij')->insert([
            'name' => 'vierOpEenRij',
        ]);
    }
}
