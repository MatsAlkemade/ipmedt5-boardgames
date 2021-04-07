<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;

use App\Models\User;

class VierOpEenRijController extends Controller
{
	public function index() {
		// return view('games.fourinarow');
		return 'index';
	}

    static public function place($websocket, $data) {
    	$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("actions", $gameData)) {
    		$gameData["actions"] = [];
    	}

    	array_push($gameData["actions"], ["action" => 'fiar_place',"player" => $websocket->getUserId(), "column" => $data["column"]]);

    	GameStateController::setData($data["id"], $gameData);

    	$websocket->broadcast()->to('vieropeenrij.' . $data["id"])->emit('fiar_place', [ "user" => $websocket->getUserId(), "column" => $data["column"] ]);
    }

    static public function getState($websocket, $data) {

    	$users = GameStateController::session($data["id"])["users"];

    	if (in_array($websocket->getUserId(), $users)) {
    		$gameData = GameStateController::getData($data["id"]);
    		if (array_key_exists("actions", $gameData)) {
    			$websocket->emit('fiar_state', $gameData["actions"]);
	    	}
    	}

    	// var_dump("GAME_DATA");
    	// var_dump($gameData);
    	// foreach($gameData["actions"] as $action) {
    	// 	$websocket->emit($action["action"], $action);
    	// }

    }

    static public function gameStart($websocket, $data) {
		if (!$data) return;
		if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

		if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

		$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("actions", $gameData)) {
    		$gameData["actions"] = [];
    	}



		$gameUsers = GameStateController::session($data["id"])["users"];
		$isCreator = $gameUsers[0] == $websocket->getUserId();

		if ($isCreator && sizeof($gameUsers) > 1) {
    		array_push($gameData["actions"], ["action" => 'game_start',"player" => $websocket->getUserId()]);
			$websocket->to($data['game'] . '.' . $data['id'])->emit('game_start', [ 'start' => true ]);
    		GameStateController::setData($data["id"], $gameData);
		} else if (sizeof($gameUsers) <= 1) {
			$websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
		} else if (sizeof($gameUsers) > 2) {
			$websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
		}
	}

    public function play($id) {
    	if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'fourinarow') {
    		GameStateController::addUser($id, auth()->user());

    		$userIds = GameStateController::session($id)["users"];
    		$users = User::select('name')->whereIn('id', $userIds)->get();

    		Websocket::broadcast()->to('vieropeenrij.' . $id)->emit('users', $users);

    		return view('games.fourinarow', [ 'gameCode' => $id, 'users' => $users ]);
    	}

    	// return redirect('/vieropeenrij/create')->withError("The game you tried to access does not exist");
    	// return redirect()->back()->withError("The game you tried to access does not exist");
    	return "Game does not exist!";
    }

    public function create(Request $request) {
    	// dd($request->session());

    	// if ($request->session()->error) {
    	// 	return $request->session()->error;
    	// }

    	$id = GameStateController::createSession('fourinarow', auth()->user());

    	return redirect('/vieropeenrij/' . $id);

    	// return view('games.');
    }
}
