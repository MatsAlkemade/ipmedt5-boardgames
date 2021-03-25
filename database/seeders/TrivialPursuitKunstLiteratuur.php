<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TrivialPursuitKunstLiteratuur extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question_array = ["In welk museum vindt je de Mona Lisa?", "Wie schreef Moby Dick?", "Welk toneelstuk van Shakespear lag aan de basis van de musical ‘Westside Story’?", "Welk bekend balletstuk gaat over een jong meisje haar gebroken kerstmiscadeautje?", "Welke oorlogsheld van de 2e Wereldoorlog heeft de nobel prijs voor literatuur gewonnen?", "Wie schilderde ‘The last supper’?", "Welk van de volgende dingen was Leonardo da Vinci NIET. schilder, schrijver, generaal, filosoof", "Wat is de naam voor een japans stripboek?", "Wie heeft 'De kunst van het oorlogvoeren' (The Art of War) geschreven?", "Wat is het meest verkochten boek aller tijden?", "De gebroeders Grimm staan bekend om het schrijven van wat?", "Uit hoeveel boeken bestaat Harry Potter?", "Wie heeft het melkmeisje geschilderd?", "Wie heeft de aardappeleters geschilderd?", "Wie heeft Het puttertje (The Goldfinch) geschilderd?"];
        $answer_array = ["Louvre", "Herman Melville", "Romeo en Juliet", "De notenkraker", "Winston Churchill", "Leonardo da Vinci", "Generaal", "Manga", "Sun Tzu", "De Bijbel", "Sprookjes", "7", "Johannes Vermeer", "Vincent van Gogh", "Carel Fabritius"];

        $count = count($question_array);

        for($x = 0; $x < $count; $x++){ #x < count moet niet <= zijn omdat de db bij 0 begint en niet bij 1
            DB::table('trivial_pursuit_questions')->insert([
                'category' => "Kunst en Literatuur",
                'question' => $question_array[$x],
                'answer' => $answer_array[$x],
                'game' => 'Trivial Pursuit',
            ]);
        }
    }
}
