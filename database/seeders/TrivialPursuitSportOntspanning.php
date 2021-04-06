<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitSportOntspanning extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question_array = ["Hoe lang duurt een professionele voetbalwedstrijd?", "Bij welke sport horen de termen “strike” en “spare”?", "Welke kleur heeft de uitrusting van een schermer meestal?", "Om de hoeveel jaar worden de Olympische zomerspelen gehouden?", "Bij welke sport wordt er gedanst met spitzen?", "Bij welke sport horen de termen pancake, side-out en floater?", "Welke kleur begint altijd bij het schaken?", "Welke trui mag de wereldkampioen wielrennen dragen?", "Wat is het oudste tennistoernooi ter wereld?", "Wat is de start en aankomstplaats van de Elfstedentocht?", "Welke Italiaanse voetbalclub wordt vergeleken met een oude dame?", "Uit welk onderdeel bestaat een originele triatlon naast zwemmen en fietsen nog meer?", "Hoe worden bij het bowlen 3 strikes achter elkaar genoemd?", "Welke sport betekend in het Japans “zachte weg”?", "Bij welke sport kan men de titel Mr. Olympia behalen?"];
        $answer_array = ["90", "Bowlen", "Wit", "4", "Ballet", "Volleybal", "Wit", "De regenboogtrui", "Wimbledon", "Leeuwarden", "Juventus", "Hardlopen", "Turkey", "Judo", "Bodybuilding"];

        $count = count($question_array);

        for($x = 0; $x < $count; $x++){ #x < count moet niet <= zijn omdat de db bij 0 begint en niet bij 1
            DB::table('trivial_pursuit_questions')->insert([
                'category' => "sport",
                'question' => $question_array[$x],
                'answer' => $answer_array[$x],
                'game' => 'Trivial Pursuit',
            ]);
        }
    }
}
