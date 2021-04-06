<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitAmusement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question_array = ["Wat is de meest bekeken video op Youtube?", "Wat is de meest populaire sport ter wereld?", "Wat is het grootste Youtube kanaal?", "Wat is het meest verkochten video game?", "Wat is het meest winstgevende franchise?", "Welk social media platform heeft de meeste gebruikers?", "Hoe heet de moeder van Homer Simpson in de tv-serie the Simpsons?", "Sinds welk jaar is Goede Tijden Slechte Tijden op tv te zien?", "Waarvoor staat de afkorting MTV, het bekende televisienetwerk?", "Hoe heet de maker van Spongebob?", "Hoe zou de serie the Flintstones oorspronkelijk gaan heten?", "Wie is de duurste voetbal transfer aller tijden?", "Waar staat de afkorting MC in de hiphopscene voor?", "Waar staat de googelaar Houdini bekend om?", "Wat is de meest verkochten musical?"];
        $answer_array = ["Baby Shark", "Voetbal", "T-Series", "Minecraft", "Pokemon", "WhatsApp", "Mona Simpson", "1990", "Music Television", "Stephen Hillenburg", "The Flagstones", "Neymar", "Master of Ceremonies", "Ontsnappen", "The Phantom of the Opera"];

        $count = count($question_array);

        for($x = 0; $x < $count; $x++){ #x < count moet niet <= zijn omdat de db bij 0 begint en niet bij 1
            DB::table('trivial_pursuit_questions')->insert([
                'category' => "amusement",
                'question' => $question_array[$x],
                'answer' => $answer_array[$x],
                'game' => 'Trivial Pursuit',
            ]);
        }
    }
}
