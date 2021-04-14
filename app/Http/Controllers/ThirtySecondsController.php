<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;

class ThirtySecondsController extends Controller
{
    public function show(){
        return view('games.thirtyseconds',[
            'ts' => \App\Models\ThirtySeconds::first(),
            'tsq' => \App\Models\ThirtySecondsQuestion::get(),
        ]);
    }

    public function store(Request $request){
        $inputs = ['q1', 'q2', 'q3', 'q4', 'q5'];
        $answers = [];
        foreach($inputs as $input){
            if($request->input($input)){
                $answers[$input] = true;
            }else{
                $answers[$input] = false;
            }
        }

        return redirect('/thirtyseconds');
    }

    public function create(Request $request) {
        $id = GameStateController::createSession('thirtyseconds', auth()->user());

        return redirect('/thirtyseconds/' . $id);
    }

    public function play($id) {
        if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'thirtyseconds') {
            GameStateController::addUser($id, auth()->user());
            $gameData = GameStateController::getData($id);
            $userIds = GameStateController::session($id)["users"];
            $users = User::select('name')->whereIn('id', $userIds)->get();
            Websocket::broadcast()->to('thirtytseconds.' . $id)->emit('users', $users);

            if (!array_key_exists("started", $gameData)) {
                return view('games.gamelobby', [
                    'gameCode' => $id,
                    'users' => $users,
                    'gameType' => 'Thirty Seconds',
                    'ts' => \App\Models\ThirtySeconds::first(),
                ]);
            }

            return view('games.thirtyseconds', [
                'gameCode' => $id,
                'users' => $users,
                'ts' => \App\Models\ThirtySeconds::first(),
                'tsq' => \App\Models\ThirtySecondsQuestion::get(),
            ]);
        }

        return "Game does not exist!";
      }
}
