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
            'name' => 'ganzenbord',
            'description'=> 'Bij Ganzenbord moet je als eerste op vakje 63 uitkomen, kom je op een gans? Dan mag je het zelfde aantal van wat je hebt gedobbeld doorlopen. Verder staan hieronder nog de hokjes met een speciale betekenis.',
        ]);
    }
}
