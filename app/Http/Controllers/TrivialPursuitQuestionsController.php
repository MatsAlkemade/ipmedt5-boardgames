<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrivialPursuitQuestionsController extends Controller
{
    public function index($id){
        $question = \App\Models\TrivialPursuitQuestions::find($id);

        return view('TrivialPursuit.question', ['question' => $question]);
    }
}
