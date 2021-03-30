<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ThirtySecondsQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thirty_seconds_questions')->insert([
            'question_1' => 'Prinses Beatrix',
            'question_2' => 'Nutella',
            'question_3' => 'De Magere Brug',
            'question_4' => 'Schanulleke',
            'question_5' => 'Kylie Minogue',
        ]);
    }
}
