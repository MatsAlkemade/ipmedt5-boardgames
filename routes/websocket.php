<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;
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
	app(GameStateController::class)->setTest($data);
    $websocket->emit('message', true);
});

Websocket::on('gettest', function($websocket, $data) {
	$websocket->emit('message', app(GameStateController::class)->getTest());
});