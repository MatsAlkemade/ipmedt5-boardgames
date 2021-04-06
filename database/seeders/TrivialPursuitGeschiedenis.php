<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitGeschiedenis extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question_array = ["Ter ere van welke Grieks god werden de vroegere Olympische spelen in Griekenland gehouden?", "Hoe wordt de periode van het jaar 500 tot 1500 vaak genoemd?", "Welke titel gaven de Egyptenaren vroeger aan hun koning of koningin?", "Van wie is de quote “I have a dream”?", "Wie schilderde De nachtwacht?", "Wanneer eindigde de eerste wereldoorlog?", "Welke dictator werd op 30 december 2006 in Bagdad geëxecuteerd?", "Uit welk land kwam de schrijver en filosoof Plato?", "Welk werelddeel werd ooit Nieuw-Holland genoemd?", "Waar dacht Christoffel Columbus dat hij was toen hij in 1492 Amerika ontdekte?", "Voor welke oude sport was het Circus Maximus in Rome hoofdzakelijk bedoeld?", "Onder welke naam is spiritueel leider Siddharta Gautama beter bekend?", "Welke Nazi was de minister van propaganda?", "Wie was de eerste leider van de sovjet unie", "Naar welk land waren veel nazi's gevlucht? na de tweede wereldoorlog"];
        $answer_array = ["Zeus", "Middeleeuwen", "Farao", "Martin Luther King Jr", "Rembrandt van Rijn", "1918", "Saddam Hoessein", "Griekenland", "Australië", "India", "Wagenrennen", "Boeddha", "Joseph Goebbels", "Lenin", "Argentinie"];

        $count = count($question_array);

        for($x = 0; $x < $count; $x++){ #x < count moet niet <= zijn omdat de db bij 0 begint en niet bij 1
            DB::table('trivial_pursuit_questions')->insert([
                'category' => "geschiedenis",
                'question' => $question_array[$x],
                'answer' => $answer_array[$x],
                'game' => 'Trivial Pursuit',
            ]);
        }
    }
}
