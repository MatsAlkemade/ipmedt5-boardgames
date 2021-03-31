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
	// app(GameStateController::class)->setTest($data);
	// GameStateController::setTest($data);
    $websocket->emit('message', true);
});

Websocket::on('gettest', function($websocket, $data) {
	// $websocket->emit('message', app(GameStateController::class)->getTest());
	$websocket->emit('message', );
});

Websocket::on('turn', function($websocket, $data) {
	$websocket->emit('message', "oitjaetiat");
});

Websocket::on('vlottegeesten_grab', function($websocket, $data) {
	$websocket->emit('grab', [
		"object" => $data["object"],
		"sessionId" => $data["sessionId"]
	]);
});
// Websocket::on('vieropeenrij_piece', function($websocket, $data) {
// 	$websocket->emit('message', app(GameStateController::class)->getTest());
// 	$websocket->broadcast()->emit('message', $data);
// 	app(GameStateController::class)->setTest([
// 		"sessions" => [
// 			"1234" => [
// 				"data" => [
// 					"players" => [
// 						"abcdeijatoiaejt" => [
// 							"name" => "test",
// 						]
// 					]
// 				]
// 			]
// 		]
// 	]);

// });

// Websocket::on('createGame', function($websocket, $data) {
// 	app(GameStateController::class)->createSession(generateSessionId());
// });

// Websocket::on('getplayers', function($websocket, $data) {
// 	app(GameStateController::class)->getTest()["1234"]["data"]["players"];
// });