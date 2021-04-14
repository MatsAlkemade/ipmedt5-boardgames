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
		if ($gameData["playerPositions"][$userId] == 58) {
			$position = 0;
			$gameData["playerPositions"][$userId] = 0;
		}
		if ($gameData["playerPositions"][$userId] == 6) {
			$position = 12;
			$gameData["playerPositions"][$userId] = 12;
		}
		if ($gameData["playerPositions"][$userId] == 42) {
			$position = 39;
			$gameData["playerPositions"][$userId] = 39;
		}
		if ($gameData["playerPositions"][$userId] >= 63) {
			$position = 63;
			$gameData["playerPositions"][$userId] = 63;
		}
		// if ($gameData["playerPositions"][$userId] == 5) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 9) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 14) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 18) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 23) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 26) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 27) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 32) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 36) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 41) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 45) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 50) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 54) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }
		// if ($gameData["playerPositions"][$userId] == 59) {
		// 	$position = $gameData["playerPositions"][$userId] + $random;
		// 	$gameData["playerPositions"][$userId] = $position;
		// }



    	$playerTurn = GameStateController::nextTurn($data["id"]);
    	var_dump([
    		$position,
    		$random
    	]);

    	$websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => $playerTurn]);
    	$websocket->to('ganzenbord.' . $data["id"])->emit('dobbel', ["getal" => $random, 'position' => $gameData["playerPositions"][$userId], 'playerId' => $websocket->getUserId()]);

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


		$players = GameStateController::session($data['id'])["users"];
		$playerNames = [];
		foreach ($players as $player){
			array_push($playerNames, User::where('id', $player)->first()->name);
		}
		$websocket->emit('ganzenbord_playernames', $playerNames);
	}

	public function returnWinner(){
		$user = Auth::user();
		Javascript::put([ 'user.name' => $user->name]);
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
			$websocket->to($data['game'] . '.' . $data['id'])->emit('getUsers', GameStateController::session($data["id"])["users"]);


			$players = GameStateController::session($data['id'])["users"];
			$playerNames = [];
			foreach ($players as $player){
				array_push($playerNames, User::where('id', $player)->first()->name);
			}
			$websocket->to($data['game'] . '.' . $data['id'])->emit('ganzenbord_playernames', $playerNames);
			//$websocket->to('ganzenbord.' . $data["id"])->emit('getUsers', GameStateController::session($data["id"])["users"]);
			//$websocket->to('ganzenbord.' . $data[$playerNames])->emit('getUsers', GameStateController::session($data[$playerNames])["users"]);

    		GameStateController::setData($data["id"], $gameData);
			

            $websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
		} else if (sizeof($gameUsers) <= 1) {
			$websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
		} else if (sizeof($gameUsers) > 4) {
			$websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
		}
	}
}
