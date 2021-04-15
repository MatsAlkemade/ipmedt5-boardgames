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

    static public function turnCards($websocket, $data){
        $gameUsers = GameStateController::session($data["id"])["users"];
        $isCreator = $gameUsers[0] == $websocket->getUserId();

        if($isCreator){
          $websocket->to('vlottegeest.' . $data["id"])->emit('turnCard', []);
        }
    }

    static public function objecten($websocket, $data){
        // var_dump($data);
        $websocket -> emit('object', $data);
        $user_id = $websocket->getUserid();
        // var_dump($user_id);
        $timestamp = round(microtime(true) * 1000);
        // var_dump($timestamp);

        $gameData = GameStateController::getData($data["id"]);
        
        //create object
        if (!array_key_exists("grabbedObject", $gameData)) {
          $gameData["grabbedObject"] = [];
        }

        if (!array_key_exists($user_id, $gameData["grabbedObject"])) {
          $gameData["grabbedObject"][$user_id] = [
              "time" => 0,
              "object" => "",
          ];
        }

        if (!array_key_exists("rondeNummer", $gameData)) {
          $gameData["rondeNummer"] = 5;
        }

        if($gameData["rondeNummer"] == $data["rondeNummer"] && $data["object"] == true){
            $gameData["rondeNummer"] -= 1;
            var_dump("dezelfde ronde nummefr");
            $websocket->to('vlottegeest.' . $data["id"])->emit('rondeNummer', ["rondeNummer" => $gameData["rondeNummer"], "Winner" => $websocket->getUserId()]);
            $websocket->to('vlottegeest.' . $data["id"])->emit('randomObject', ["randomObject" => self::randomImage(), "timestamp" => $timestamp]);

        }

        $gameData["grabbedObject"][$user_id]["time"] = $timestamp;
        $gameData["grabbedObject"][$user_id]["object"] = $data["object"];
        // $gameData["rondeNummer"][$user_id]["ronderNummer"] = ;
        GameStateController::setData($data["id"], $gameData);
        var_dump($data);
    }

    static public function randomImage(){
        $images = ['/img/games/vlottegeest/Spook.png', '/img/games/vlottegeest/bad.png', '/img/games/vlottegeest/doekie.png', '/img/games/vlottegeest/frogie.png', '/img/games/vlottegeest/Borstel.png' ];
        $randomImage = $images[array_rand($images)]; // See comments
        return $randomImage;
    }

    //vlotte geest
    static public function getState($websocket, $data) {
      var_dump($data);
      if (!$data) return;
      if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
      if (!sessionExists($data['id'])) return var_dump("Session does not exist!");
      
      $gameData = GameStateController::getData($data["id"]);
      $websocket->emit('vg_state', $gameData);
      $websocket->emit('vg_turn', ["turn" => GameStateController::getTurn($data["id"])]); 
    }
    
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
        self::getUsers($websocket, $data);
        $websocket->to('vlottegeest.' . $data["id"])->emit('getUsers', GameStateController::session($data["id"])["users"]);
  
          GameStateController::setData($data["id"], $gameData);
  
              $websocket->to('vlottegeest.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
              $websocket->to('vlottegeest.' . $data["id"])->emit('randomObject', ["randomObject" => self::randomImage()]);
              $websocket->to('vlottegeest.' . $data["id"])->emit('rondeNummer', ["rondeNummer" => 5]);
              
      } else if (sizeof($gameUsers) <= 1) {
        $websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
      } else if (sizeof($gameUsers) > 4) {
        $websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
      }
    }
}
