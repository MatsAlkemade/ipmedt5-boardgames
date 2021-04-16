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
            'stappen' => 6,
            'description'=> 'Brug! Ga door naar vakje 12',
        ]);

        DB::table('ganzenbord_table_steps_consequences')->insert([
            'stappen' => 19,
            'description'=> 'Een nachtje in de Herberg, sla 1 beurt over',
        ]);

        DB::table('ganzenbord_table_steps_consequences')->insert([
            'stappen' => 31,
            'description'=> 'In de put! Sla 2 beurten over!',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'stappen' => 42,
            'description'=> 'Je bent verdwaald in een doolhof, ga terug naar 39',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'stappen' => 52,
            'description'=> 'Gevangenis, sla 2 beurten over.',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'stappen' => 58,
            'description'=> 'Dood, ga terug naar start',
        ]);
        DB::table('ganzenbord_table_steps_consequences')->insert([
            'stappen' => 63,
            'description'=> 'Einde! Wie als eerste hier is wint.',
        ]);
    }
}
