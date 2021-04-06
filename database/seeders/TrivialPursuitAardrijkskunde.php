<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitAardrijkskunde extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question_array = ["Wat is de hoofdstad van Zuid-Holland?", "Wat is de grootste woestijn", "Welke vlag heeft de meeste kleuren?", "Wat is het grootste land ter wereld? (oppervlakte)", "Welk land heeft de oudste vlag ter wereld?", "Welke deelstaat vlag komt niet voor in de vlag van het Verenigd Koninkrijk", "Wat kunnen onderzeese aardbeving veroorzaken?", "Hoeveel landen hebben een draak op hun vlag?", "Welke vorm heeft Italië", "Hoeveel planeten zijn er in het Zonnestelsel", "Wat is in het centrum van een sterrenstelsel?", "Wat is de langste rivier ter wereld?", "Hoeveel staten heeft de VS?", "Wat is de grootste boom ter wereld?", "Wat is de grootste berg van Europa?"];
        $answer_array = ["Den Haag", "Antarctica", "Zuid-Afrika", "Rusland", "Denemarken", "Wales", "Tsunami", "3", "Laars", "8", "Zwart gat", "Nijl", "50", "General Sherman", "Mont Blanc"];

        $count = count($question_array);

        for($x = 0; $x < $count; $x++){ #x < count moet niet <= zijn omdat de db bij 0 begint en niet bij 1
            DB::table('trivial_pursuit_questions')->insert([
                'category' => "Aardrijkskunde",
                'question' => $question_array[$x],
                'answer' => $answer_array[$x],
                'game' => 'Trivial Pursuit',
            ]);
        }
    }
}
