<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;
use Illuminate\Support\Facades\Auth;

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
          $loggedUserId = Auth::id(); 

          return view('games.trivialpursuit', [ 'gameCode' => $id, 'users' => $users, 'questions' => $questions, 'loggedId' => $loggedUserId,]);
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

    static public function getPlaats($websocket, $data){
        if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

        $gameData = GameStateController::getData($data["id"]);
        $user_id = $websocket->getUserid();

		if (!array_key_exists($user_id, $gameData["positie"])) {
			$gameData["positie"] = 0;
		}
        
        $plaats =  $gameData["positie"];

        $websocket->emit('tp_getPlaats', $plaats);
    }

    static public function lopen($websocket, $data) {
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
        
        $websocket -> emit('tp_lopen', $data);
        $user_id = $websocket->getUserid();

    	$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("positie", $gameData)) {
    		$gameData["positie"] = [];
    	}

        if (!array_key_exists($user_id, $gameData["positie"])) {
            $gameData["positie"][$user_id] = [
                "plek" => 0,
            ];
        }

        if ($data["plek"] <= 0){
            $gameData["positie"][$user_id]["plek"] = 0;
        }

        elseif($data["plek"] >= 20){
            $winner = [];
            $user = array_push($winner, User::where('id', $user_id)->first()->name);
            $websocket->emit('tp_getWinner', $winner);
        }

        else{
            $gameData["positie"][$user_id]["plek"] = $data["plek"];

        }
                
        GameStateController::setData($data["id"], $gameData);
        var_dump($gameData["positie"]);
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
