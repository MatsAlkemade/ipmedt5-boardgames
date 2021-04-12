<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SwooleTW\Http\Websocket\Facades\Websocket;
use SwooleTW\Http\Websocket\Facades\Room;

class VlotteGeestController extends Controller
{
    public function index(){
        return view('games.vlottegeest');
    }

    //vlotte geest
    public function play($id) {
        if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'vlottegeest') {
          GameStateController::addUser($id, auth()->user());
          $userIds = GameStateController::session($id)["users"];
          $users = User::select('name')->whereIn('id', $userIds)->get();
          Websocket::broadcast()->to('vlottegeest.' . $id)->emit('users', $users);
          return view('games.vlottegeest', [ 'gameCode' => $id, 'users' => $users ]);
        }

        return "Game does not exist!";
      }

      public function create(Request $request) {
        $id = GameStateController::createSession('vlottegeest', auth()->user());
        return redirect('/vlottegeest/' . $id);
    }

}
