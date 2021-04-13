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

	public function create(Request $request) {
		$id = GameStateController::createSession('ganzenbord', auth()->user());
		return redirect('/ganzenbord/' . $id);
	}


	function getUsers($websocket, $data) {
        $websocket->emit('getUsers', GameStateController::session($data["id"])["users"]);

	
}
}
