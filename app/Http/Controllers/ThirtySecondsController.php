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

    static public function gameStart($websocket, $data) {
        if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

        var_dump($data);
        return;

        foreach ($data["teams"] as $team) {
            foreach ($team["users"] as $userId) {
                GameStateController::joinTeam($data["id"], $userId, $team["team"]);
            }
        }

        $gameData = GameStateController::getData($data["id"]);
        if (!array_key_exists("actions", $gameData)) {
            $gameData["actions"] = [];
        }

        if (array_key_exists("started", $gameData) && $gameData["started"] == true) {
            return;
        }

        $gameUsers = GameStateController::session($data["id"])["users"];
        $isCreator = $gameUsers[0] == $websocket->getUserId();

        if ($isCreator && sizeof($gameUsers) > 1) {
            array_push($gameData["actions"], ["action" => 'game_start',"player" => $websocket->getUserId()]);
            $websocket->to($data['game'] . '.' . $data['id'])->emit('game_start', [ 'start' => true ]);
            $gameData["started"] = true;
            GameStateController::setData($data["id"], $gameData);
            GameStateController::setTurnMode($data["id"], 1);
            $websocket->to('thirtyseconds.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
        } else if (sizeof($gameUsers) <= 1) {
            $websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
        } else if (sizeof($gameUsers) > 2) {
            $websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
        }
    }
}
