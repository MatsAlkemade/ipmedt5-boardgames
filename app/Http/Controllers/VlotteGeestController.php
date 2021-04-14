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

    static public function getUsers($websocket, $data) {
      if (!$data) return;
          if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
          if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
  
          $websocket->emit('vg_getUsers', GameStateController::session($data["id"])["users"]);
  
  
      $players = GameStateController::session($data['id'])["users"];
      $playerNames = [];
      foreach ($players as $player){
        array_push($playerNames, User::where('id', $player)->first()->name);
      }
      $websocket->emit('vg_playerNames', $playerNames);
    }


    static public function gameStart($websocket, $data) {
      if (!$data) return;
      if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
  
      if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
  
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
        //self::getUsers($websocket, $data);
        $websocket->to('vlottegeest.' . $data["id"])->emit('getUsers', GameStateController::session($data["id"])["users"]);
  
          GameStateController::setData($data["id"], $gameData);
  
              $websocket->to('vlottegeest.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
      } else if (sizeof($gameUsers) <= 1) {
        $websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
      } else if (sizeof($gameUsers) > 4) {
        $websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
      }
    }
}
