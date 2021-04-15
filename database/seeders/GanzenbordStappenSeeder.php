<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GanzenbordStappenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '6: Brug! Ga door naar vakje 12',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '19: Een nachtje in de Herberg, sla 1 beurt over',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '31: In de put! Sla 1 beurt over!',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '42: Je bent verdwaald in een doolhof, ga terug naar 39',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '52: Gevangenis, sla 1 beurten over.',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '58: Dood, ga terug naar start',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'description'=> '63: Einde! Wie als eerste hier is wint.',
        ]);
    }
}
