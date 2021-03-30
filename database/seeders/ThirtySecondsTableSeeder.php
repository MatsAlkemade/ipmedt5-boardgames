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
            'steps' => 35,
            'description' => 'Spectaculair partyspel voor teams. Fantastisch voor grote gezelschappen op feestjes en partijen. Je speelt in teams. Een van jullie probeert binnen 30 seconden zoveel mogelijk van de 5 begrippen op een kaartje te omschrijven. Hoe meer begrippen jullie raden, des te meer velden jullie op het speelbord vooruit mogen. Een dobbelsteenworp kan daar nog verandering in brengen. Welk team bereikt als eerste de finish?',
        ]);
    }
}
