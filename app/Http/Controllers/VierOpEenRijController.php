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

    public function place($websocket, $data) {
    	// $websocket->emit('')
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
