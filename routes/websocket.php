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

Websocket::on('connect', function ($websocket, Request $request) {
    Websocket::loginUsing($request->user());
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

    $websocket->emit('login', [ 'loggedIn' => true ]);
});

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
});

Websocket::on('example', function ($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

    $websocket->emit('message', $data);
});

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
	}
	var_dump($data['game'] . '.' . $data['id']);
	var_dump(Room::getClients($data['game'] . '.' . $data['id']));
});

Websocket::on('leave_session', function($websocket, $data) {
	if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN

	$websocket->leave($data['game'] . '.' . $data['id']);
});

/*
	Four in a Row (fiar)
*/

// Websocket::on('fiar_place', [VierOpEenRijController::class, 'place']);