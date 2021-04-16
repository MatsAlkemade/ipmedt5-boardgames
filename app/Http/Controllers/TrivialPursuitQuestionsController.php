<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;


class TrivialPursuitQuestionsController extends Controller
{
    public function index($id){
        $question = \App\Models\TrivialPursuitQuestions::find($id);

        return view('TrivialPursuit.question', ['question' => $question]);
    }
}
