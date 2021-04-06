<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitWetenschapNatuur extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question_array = ["Welke kleur heeft een robijn?","Hoe heet de Amerikaanse ruimtevaartorganisatie?","Hoe wordt draadloos internet ook wel genoemd?","Hoe noem je de kracht die alles naar beneden trekt? (G-force)","Welk soort verbinding is vernoemd naar Harald Blauwtand?","In welke maateenheid wordt een beeldscherm aangeduid?", "Wat is de tegenhanger van gelijkspanning?", "Wat is de hardste steen op aarde?", "In welk jaar was de eerste maanlanding?", "Waar staat de afkorting Hz voor?", "Hoe wordt een tweede keer volle maan in één maand genoemd?", "Welke lichtstraal heeft een tv afstandsbediening?", "Hoeveel kilobyte is 1 megabyte?", "Wat is kleiner dan een molecuul?", "Met welk gas wordt een ballon opgeblazen die kan zweven?"];
        $answer_array = ["Rood","NASA","Wifi","Zwaartekracht","Bluetooth","Inch", "Wisselspanning", "Diamant", "1969", "Hertz", "Blauwe maan", "Infra Rood", "1024", "Atoom", "Helium"];

        $count = count($question_array);

        for($x = 0; $x < $count; $x++){ #x < count moet niet <= zijn omdat de db bij 0 begint en niet bij 1
            DB::table('trivial_pursuit_questions')->insert([
                'category' => "wetenschapnatuur",
                'question' => $question_array[$x],
                'answer' => $answer_array[$x],
                'game' => 'Trivial Pursuit',
            ]);
        }
    }
}
