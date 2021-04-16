<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;


class GanzenbordController extends Controller
{
	static public $skipBeurtPosities = [19, 31, 52];
	static public $nogEenKeerDobbelenPosities = [5, 9, 14, 18, 23, 26, 27, 32, 36, 41, 45, 50, 54, 59];

	public function index(){
		return view('games.ganzenbordLobby',[
			'ganzenbordstappen' =>\App\Models\GanzenbordStappen::all(),
			'ganzenbord'=>\App\Models\Ganzenbord::first()
		]);
		
	}

	
	
	//Als het spel wordt gestart, worden de userIds en Usernames doorgepaast aan de server en de andere users
	public function play($id) {
		if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'ganzenbord') {
			GameStateController::addUser($id, auth()->user());
			$userIds = GameStateController::session($id)["users"];
			$users = User::select('name')->whereIn('id', $userIds)->get();
			Websocket::broadcast()->to('ganzenbord.' . $id)->emit('users', $users);
			return view('games.ganzenbordstappen', [ 'gameCode' => $id, 'users' => $users, 'ganzenbordstappen'=>\App\Models\GanzenbordStappen::all(),'ganzenbord'=>\App\Models\Ganzenbord::first(), ]);
		}

		return "Game does not exist!";
	}

	//Functie bepaalt wie er aan de beurt is als het spel wordt gestart
	static public function start_game($websocket, $data) {

		
		if (GameStateController::getTurn($data["id"]) != $websocket->getUserId()) {
            self::getState($websocket, $data);
            return;
        }
    	$playerTurn = GameStateController::nextTurn($data["id"]);
		$websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
	}

	//Dobbel is de dobbelsteen en bepaalt de positie van de spelers en wat er gedobbeld wordt (en consequenties van sommige vakjes)
	static public function dobbel($websocket, $data) {
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

    	$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("playerPositions", $gameData)) {
    		$gameData["playerPositions"] = [];
    	}

    	if (array_key_exists("winner", $gameData) && intval($gameData["winner"]) >= 0) {
    		return $websocket->emit("winner", [ "winnerId" => $gameData["winner"] ]);
    	}

		if (GameStateController::getTurn($data["id"]) != $websocket->getUserId()) {
            return;
        }
		


    	$random = random_int(2, 12);

		$userId = $websocket->getUserId();
		if (!array_key_exists($userId, $gameData["playerPositions"])) {
			$gameData["playerPositions"][$userId] = 0;
		}

		if (!array_key_exists("skipBeurtPlayers", $gameData)) {
			$gameData["skipBeurtPlayers"] = [];
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
			$gameData["winner"] = $userId;
		}


		if (in_array($gameData["playerPositions"][$userId], self::$nogEenKeerDobbelenPosities)) { 
			$position = $gameData["playerPositions"][$userId] +$random;
			$gameData["playerPositions"][$userId] = $position;
		}


		if (in_array($gameData["playerPositions"][$userId], self::$skipBeurtPosities)) {
			array_push($gameData["skipBeurtPlayers"], $userId);
		}


    	$playerTurn = GameStateController::nextTurn($data["id"]);
    	var_dump([
    		$position,
    		$random
    	]);

    	while (in_array($playerTurn, $gameData["skipBeurtPlayers"])) {
    		$spelerIndex = array_search($playerTurn, $gameData["skipBeurtPlayers"]);
    		unset($gameData["skipBeurtPlayers"][$spelerIndex]);
			var_dump("In de array", $playerTurn);
    		$playerTurn = GameStateController::nextTurn($data["id"]);
			var_dump("In de array volgende", $playerTurn);
		}


    	$websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => $playerTurn]);
    	$websocket->to('ganzenbord.' . $data["id"])->emit('dobbel', ["getal" => $random, 'position' => $gameData["playerPositions"][$userId], 'playerId' => $websocket->getUserId()]);

        GameStateController::setData($data["id"], $gameData);


		
	}
	// Als je refreshed moet even worden opgeslagen waar je was, dit vraag je op met getState
	static public function getState($websocket, $data) {
		var_dump($data);
		if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
        
    	$gameData = GameStateController::getData($data["id"]);
        $websocket->emit('ganzenbord_state', $gameData);
		$websocket->emit('turn', ["turn" => GameStateController::getTurn($data["id"])]);	
	}
	//Maak nieuwe game met een game id (/ganzenbord/create -> krijg game id)
	public function create(Request $request) {
		$id = GameStateController::createSession('ganzenbord', auth()->user());
		return redirect('/ganzenbord/' . $id);
	}

	//Welke users zijn er in het spel?? Getusers pakt het voor je (en de namen)
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
	// ALs je hebt gewonnen wordt je name toegevoegd aan de blade
	public function returnWinner(){
		$user = Auth::user();
		Javascript::put([ 'user.name' => $user->name]);
	}

	// Start de game, kan alleen bij 2 of meer spelers
	static public function gameStart($websocket, $data) {
		if (!$data) return;
		if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

		if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
		var_dump("GANZENBORD_CONTROLLER");
		switch ($data["game"]) {
			case 'vieropeenrij':
				var_dump("VIEROPEENRIJ");
				return VierOpEenRijController::gameStart($websocket, $data);
				break;
		}
		var_dump("after switch");
        // if ($data["game"] != "ganzenbord") return var_dump('not same!', $data["game"]);
        // var_dump("YES");

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

    		GameStateController::setData($data["id"], $gameData);
			

            $websocket->to('ganzenbord.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
		} else if (sizeof($gameUsers) <= 1) {
			$websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
		} else if (sizeof($gameUsers) > 4) {
			$websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
		}
	}
}
