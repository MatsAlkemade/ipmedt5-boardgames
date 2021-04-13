<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;
use App\Http\Controllers\VierOpEenRijController;
use App\Http\Controllers\GameStateController;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

function authCheck($websocket) {
	if ($websocket->getUserId() !== NULL) return true;
	return false;
}

function notLoggedInMsg($websocket) {
	$websocket->emit('login', [ 'loggedIn' => false ]);
}

function sessionExists($id) {
	return GameStateController::sessionExists($id);
}

Websocket::on('connect', function ($websocket, Request $request) {
	if (!$request) return;
	if ($request->user() !== null) Websocket::loginUsing($request->user());
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

    $websocket->emit('login', [ 'loggedIn' => true, 'userId' => $websocket->getUserId() ]);
    $websocket->toUserId($websocket->getUserId())->emit('game', [ 'game' => false ]);
});

Websocket::on('user_id', function ($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
	$websocket->emit('user_id', [ "user_id" => $websocket->getUserId() ]);
});

Websocket::on('game', function ($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
	$websocket->toUserId($websocket->getUserId())->emit('game', $data);
});

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
    $userId = $websocket->getUserId();
    if (!$userId) return;
    $websocket->toUserId($userId)->emit('hardware', [ 'hardware' => false ]);
});

Websocket::on('example', function ($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

    $websocket->emit('message', $data);
});

// Websocket::on('game_start', );

Websocket::on('game_start', [VierOpEenRijController::class, 'gameStart']);

/*
	Game setup
*/
Websocket::on('create_game', function($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

	$websocket->emit('test', []);
	$id = GameStateController::createSession($data["gameType"], []);
	$websocket->join($id);
	$websocket->emit('game_id', ["id" => $id, "gameType" => $data["gameType"]]);
	$websocket->emit('user_join', ["user" => "__username__"]); // TODO: add auth()->user()->name;
});

Websocket::on('session', function($websocket) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

	$websocket->emit('session', GameStateController::fc());
});


Websocket::on('join_session', function($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

	if (GameStateController::sessionExists($data['id'])) {
		$websocket->join($data['game'] . '.' . $data['id']);
		$websocket->to($data['game'] . '.' . $data['id'])->emit('users', ["more"]);
		$websocket->toUserId($websocket->getUserId())->emit('game', ['game' => $data['game'], 'id' => $data['id'] ]);
	}
});

Websocket::on('hardware', function($websocket, $data) {
	$userId = $websocket->getUserId();
	if (!$userId) return;
	$websocket->toUserId($userId)->emit('hardware', [ 'hardware' => true ]);
});

Websocket::on('leave_session', function($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

	$websocket->leave($data['game'] . '.' . $data['id']);
	$websocket->toUserId($websocket->getUserId())->emit('game', [ 'game' => false ]);
});

/*
	Four in a Row (fiar)
*/

Websocket::on('fiar_place', [VierOpEenRijController::class, 'place']);
Websocket::on('fiar_state', [VierOpEenRijController::class, 'getState']);




/* CHAT */
Websocket::on('chat_msg', function($websocket, $data) {
	if (!array_key_exists("game", $data) || !array_key_exists("id", $data)) {
		return; // No game or id given
	}

	if (!array_key_exists("message", $data)) return; // No message given

	$msgData = [
		"username" => User::where('id', $websocket->getUserId())->first()->name,
		"message" => $data["message"],
	];

	$gameData = GameStateController::getData($data["id"]);

	if (!array_key_exists("chat", $gameData)) {
		$gameData["chat"] = [];
	}

	array_push($gameData["chat"], [
		"user" => $websocket->getUserId(),
		"username" => User::where('id', $websocket->getUserId())->first()->name,
		"message" => $data["message"],
		"order" => count($gameData["chat"])+1
	]);

	GameStateController::setData($data["id"], $gameData);

	$websocket->broadcast()->to($data["game"] . '.' . $data["id"])->emit('chat_msg', $msgData);
});

Websocket::on('chat_state', function($websocket, $data) {
	if (!array_key_exists("game", $data) || !array_key_exists("id", $data)) {
		return; // No game or id given
	}

	$gameData = GameStateController::getData($data["id"]);

	if (!array_key_exists("chat", $gameData)) {
		$gameData["chat"] = [];
	}

	foreach ($gameData["chat"] as $message) {
		if ($websocket->getUserId() == $message["user"]) {
			$websocket->emit('chat_msg', [ "username" => "You", "message" => $message["message"], "order" => $message["order"] ]);
		} else {
			$websocket->emit('chat_msg', [ "username" => $message["username"], "message" => $message["message"], "order" => $message["order"] ]);
		}
	}

});