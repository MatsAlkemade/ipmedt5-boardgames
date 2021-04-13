<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;


class GanzenbordController extends Controller
{
	public function index(){
		return view('games.ganzenbordstappen',[
			'ganzenbordstappen' =>\App\Models\GanzenbordStappen::all(),
			'ganzenbord'=>\App\Models\Ganzenbord::all(),
		]);
		
	}

	
	

	public function play($id) {
		if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'ganzenbord') {
			GameStateController::addUser($id, auth()->user());
			$userIds = GameStateController::session($id)["users"];
			$users = User::select('name')->whereIn('id', $userIds)->get();
			Websocket::broadcast()->to('ganzenbord.' . $id)->emit('users', $users);
			return view('games.ganzenbordstappen', [ 'gameCode' => $id, 'users' => $users ]);
		}

		return "Game does not exist!";
	}

	static public function start_game($websocket, $data) {
		// TODO: Start de game door nextTurn aan te roepen

		if (GameStateController::getTurn($data["id"]) != $websocket->getUserId()) {
            self::getState($websocket, $data);
            return;
        }
    	$playerTurn = GameStateController::nextTurn($data["id"]);
		$websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
	}

	static public function dobbel($websocket, $data) {
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

    	$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("playerPositions", $gameData)) {
    		$gameData["playerPositions"] = [];
    	}
		if (GameStateController::getTurn($data["id"]) != $websocket->getUserId()) {
            return;
        }



        // TOOD: Check hier of persoon is geblokkeerd, zo ja volgende speler + onblokkeer de speler

    	$random = random_int(1, 12);

		$userId = $websocket->getUserId();
		if (!array_key_exists($userId, $gameData["playerPositions"])) {
			$gameData["playerPositions"][$userId] = 0;
		}

		$position = $gameData["playerPositions"][$userId];
		$gameData["playerPositions"][$userId] = $position + $random;
		// $gameData["playerPositions"][$userId] = 13;

    	$playerTurn = GameStateController::nextTurn($data["id"]);
    	var_dump([
    		$position,
    		$random
    	]);

    	$websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => $playerTurn]);
    	$websocket->to('ganzenbord.' . $data["id"])->emit('dobbel', ["getal" => $random, 'position' => $position + $random, 'playerId' => $websocket->getUserId()]);

        GameStateController::setData($data["id"], $gameData);
	}

	static public function getState($websocket, $data) {
		var_dump($data);
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
        
    	$gameData = GameStateController::getData($data["id"]);
        $websocket->emit('ganzenbord_state', $gameData);
		$websocket->emit('turn', ["turn" => GameStateController::getTurn($data["id"])]);	
	}

	public function create(Request $request) {
		$id = GameStateController::createSession('ganzenbord', auth()->user());
		return redirect('/ganzenbord/' . $id);
	}


	static public function getUsers($websocket, $data) {
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

        $websocket->emit('getUsers', GameStateController::session($data["id"])["users"]);
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
			$websocket->to('ganzenbord.' . $data["id"])->emit('getUsers', GameStateController::session($data["id"])["users"]);

    		GameStateController::setData($data["id"], $gameData);

            $websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
		} else if (sizeof($gameUsers) <= 1) {
			$websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
		} else if (sizeof($gameUsers) > 4) {
			$websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
		}
	}
}
