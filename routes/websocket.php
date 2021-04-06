<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;
use App\Http\Controllers\VierOpEenRijController;
use App\Http\Controllers\GameStateController;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('connect', function ($websocket, Request $request) {
    // called while socket on connect
});

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
});

Websocket::on('example', function ($websocket, $data) {
    $websocket->emit('message', $data);
});

/*
	Game setup
*/
Websocket::on('create_game', function($websocket, $data) {
	$websocket->emit('test', []);
	$id = GameStateController::createSession($data["gameType"], []);
	$websocket->join($id);
	$websocket->emit('game_id', ["id" => $id, "gameType" => $data["gameType"]]);
	$websocket->emit('user_join', ["user" => "__username__"]); // TODO: add auth()->user()->name;
});

Websocket::on('session', function($websocket) {
	$websocket->emit('session', GameStateController::fc());
});

/*
	Four in a Row (fiar)
*/

Websocket::on('fiar_place', [VierOpEenRijController::class, 'place']);