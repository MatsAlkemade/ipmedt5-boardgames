<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;

class TrivialPursuitController extends Controller
{
    public function index(){
        return view('TrivialPursuit.index',[
            'trivialpursuit' => \App\Models\TrivialPursuit::first()
        ]);
    }

    public function play($id) {
        if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'trivialpursuit') {
          GameStateController::addUser($id, auth()->user());
          $userIds = GameStateController::session($id)["users"];
          $users = User::select('name')->whereIn('id', $userIds)->get();
          Websocket::broadcast()->to('trivialpursuit.' . $id)->emit('users', $users);
          $questions = \App\Models\TrivialPursuitQuestions::all()->toJson();
          return view('games.trivialpursuit', [ 'gameCode' => $id, 'users' => $users, 'questions' => $questions]);
        }
        return "Game does not exist!";
      }

      public function create(Request $request) {
        $id = GameStateController::createSession('trivialpursuit', auth()->user());
        return redirect('/trivialpursuit/' . $id);
    }

    static public function question($websocket, $data){
        if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

        $random = rand(0,89);

        $websocket->emit('tp_question', $random);
    }

    static public function vraag($websocket, $data) {
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
        
        $websocket -> emit('tp_vraag', $data);
        $user_id = $websocket->getUserid();

    	$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("vraag_goed_fout", $gameData)) {
    		$gameData["vraag_goed_fout"] = [];
    	}

        if (!array_key_exists($user_id, $gameData["vraag_goed_fout"])) {
            $gameData["vraag_goed_fout"][$user_id] = [
                "antwoord" => 0,
            ];
        }
        
        $gameData["vraag_goed_fout"][$user_id]["antwoord"] = $data["antwoord"];
        
        GameStateController::setData($data["id"], $gameData);
        var_dump($gameData["vraag_goed_fout"]);
    }

    static public function getUsers($websocket, $data){
        if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

        $websocket->emit('tp_getUsers', GameStateController::session($data["id"])["users"]);

        $players = GameStateController::session($data['id'])["users"];
		$playerNames = [];
		foreach ($players as $player){
			array_push($playerNames, User::where('id', $player)->first()->name);
		}

		$websocket->emit('tp_playerNames', $playerNames);
    }

    static public function getState($websocket, $data) {
		var_dump($data);
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
        
    	$gameData = GameStateController::getData($data["id"]);
        $websocket->emit('tp_state', $gameData);
		$websocket->emit('tp_turn', ["turn" => GameStateController::getTurn($data["id"])]);	
	}

    static public function gameStart($websocket, $data) {
		if (!$data) return;
		if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
		if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

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
            self::getUsers($websocket, $data);
			$websocket->to('trivialpursuit.' . $data["id"])->emit('getUsers', GameStateController::session($data["id"])["users"]);

    		GameStateController::setData($data["id"], $gameData);

            $websocket->to('trivialpursuit.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
		} else if (sizeof($gameUsers) <= 1) {
			$websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
		} else if (sizeof($gameUsers) > 4) {
			$websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
		}
	}
}
