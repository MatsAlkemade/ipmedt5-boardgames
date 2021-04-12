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

    public function play($id) {
        if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'trivialpursuit') {
          GameStateController::addUser($id, auth()->user());
          $userIds = GameStateController::session($id)["users"];
          $users = User::select('name')->whereIn('id', $userIds)->get();
          Websocket::broadcast()->to('trivialpursuit.' . $id)->emit('users', $users);
          // Websocket::broadcast()->to('vieropeenrij.' . $id)->emit('turn', ["turn" => GameStateController::nextTurn($id)]);
          return view('games.trivialpursuit', [ 'gameCode' => $id, 'users' => $users ]);
        }
        // return redirect('/vieropeenrij/create')->withError("The game you tried to access does not exist");
        // return redirect()->back()->withError("The game you tried to access does not exist");
        return "Game does not exist!";
      }

      public function create(Request $request) {
        // dd($request->session());
        // if ($request->session()->error) {
        //  return $request->session()->error;
        // }
        $id = GameStateController::createSession('trivialpursuit', auth()->user());
        return redirect('/trivialpursuit/' . $id);
        // return view('games.');
    }
}
