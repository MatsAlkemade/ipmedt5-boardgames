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

    static public function place($websocket, $data) {
        if (!$data) return;
        if (!authCheck($websocket)) return notLoggedInMsg($websocket); // NOT LOGGED IN
        if (!sessionExists($data['id'])) return var_dump("Session does not exist!");

        var_dump("fiar_place");
        var_dump($data);

    	$gameData = GameStateController::getData($data["id"]);
    	if (!array_key_exists("actions", $gameData)) {
    		$gameData["actions"] = [];
    	}
        if (!array_key_exists("fiar_board", $gameData)) {
            $gameData["fiar_board"] = [
                array_fill(0, 8, null),
                array_fill(0, 8, null),
                array_fill(0, 8, null),
                array_fill(0, 8, null),
                array_fill(0, 8, null),
                array_fill(0, 8, null),
                array_fill(0, 8, null),
                array_fill(0, 8, null),
            ];
        }
        var_dump("winner?");
        if (array_key_exists("winner", $gameData)) return $websocket->emit("fiar_winner", $gameData["winner"]);

        var_dump("turn?");
        if (GameStateController::getTurn($data["id"]) != $websocket->getUserId()) {
            self::getState($websocket, $data);
            return;
        }

        var_dump("ok?");
    	array_push($gameData["actions"], ["action" => 'fiar_place',"player" => $websocket->getUserId(), "column" => $data["column"]]);
        $row = self::getAvailableRow($data["column"], $gameData["fiar_board"]);
        var_dump($row);
        if ($row !== NULL) $gameData["fiar_board"][$row][$data["column"]] = $websocket->getUserId();


    	$websocket->broadcast()->to('vieropeenrij.' . $data["id"])->emit('fiar_place', [ "user" => $websocket->getUserId(), "column" => $data["column"] ]);

        $websocket->to('vieropeenrij.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);

        $winningPieces = self::checkWin($gameData["fiar_board"], $data["column"], $row);
        if ($winningPieces !== false) {
            $gameData["winner"] = ["winningPieces" => $winningPieces, "winner" => $websocket->getUserId(), "username" => User::where('id', $websocket->getUserId())->first()->name];
            var_dump("GOT A WINNER!");
            var_dump($gameData["winner"]);

            $websocket->to('vieropeenrij.' . $data["id"])->emit('fiar_winner', $gameData["winner"]);
        }

    	GameStateController::setData($data["id"], $gameData);
    }

    static private function getAvailableRow($column, $board) {
        // var_dump($board[])
        // if ($board[sizeof($board[$column])-1] === NULL) return sizeof($board[$column])-1;
        for ($i = sizeof($board)-1; $i >= 0; $i--) {
            if ($board[$i][$column] === NULL) return $i;
        }
        return NULL;
    }

    static private function checkWin($board, $column, $row) {
        $winningPieces = [];

        $vertical = self::checkVertical($board, $column, $row);
        if ($vertical !== false) $winningPieces["vertical"] = $vertical;
        $horizontal = self::checkHorizontal($board, $column, $row);
        if ($horizontal !== false) $winningPieces["horizontal"] = $horizontal;
        $diagonals = self::checkDiagonals($board, $column, $row);
        if ($diagonals !== false) $winningPieces["diagonals"] = $diagonals;
        
        var_dump("RESULT");
        var_dump($winningPieces);

        if (count($winningPieces) > 0) return $winningPieces;

        return false;
    }

    static private function checkVertical($board, $column, $row) {
        $user = $board[$row][$column];
        $begin = $row;
        $count = 1;

        for ($i = $row+1; $i < count($board); $i++) {
            if ($board[$i][$column] == $user) {
                $begin = $i;
                $count++;
            }
            else break;
        }

        if ($count >= 4) return ["begin" => [$column, $begin], "end" => [$column, $row]];
        return false;
    }

    static private function checkHorizontal($board, $column, $row) {
        $user = $board[$row][$column];
        $begin = $column;
        $end = $column;
        $count = 1;

        // Check to left
        for ($i = $column-1; $i >= 0; $i--) {
            if ($board[$row][$i] == $user) {
                $begin = $i;
                $count++;
            }
            else break;
        }

        // Check to right
        for ($i = $column+1; $i < count($board[$row]); $i++) {
            if ($board[$row][$i] == $user) {
                $end = $i;
                $count++;
            }
            else break;
        }

        if ($count >= 4) return ["begin" => [$begin, $row], "end" => [$end, $row]];
        return false;
    }

    static public function recursiveCheck($board, $column, $row, $xDir, $yDir, $c=0) {
        $count = $c;
        // var_dump("recursiveCheck");
        // var_dump($c);
        if (self::getRelative($board, $column, $row, $xDir, $yDir) == $board[$row][$column]) {
            $count = self::recursiveCheck($board, $column, $row, $xDir+($xDir>0?1:-1), $yDir+($yDir>0?1:-1), $c+1);
            if ($c !== 1) return $count;
        }

        return $count;
    }

    static public function checkDiagonals($board, $column, $row) {
        $count = 1;

        // Count topleft
        $count += self::recursiveCheck($board, $column, $row, -1, -1); // TODO: Fix, return correct column and row
        $begin = [$column-$count-1, $row-$count-1];

        // Count bottomright
        $count += self::recursiveCheck($board, $column, $row, 1, 1);
        $end = [$column+($count - $begin[0]), $row+($count - $begin[1])]; // TODO: Fix, return correct column and row

        if ($count >= 4) return ["begin" => $begin, "end" => $end];

        $count = 1;

        // Count topright
        $count += self::recursiveCheck($board, $column, $row, 1, -1);
        $begin = [$column+$count-1, $row-$count+1]; // TODO: Fix, return correct column and row

        // Count bottomleft
        $count += self::recursiveCheck($board, $column, $row, -1, 1);
        $end = [$column-$begin[0], $row-$begin[1]]; // TODO: Fix, return correct column and row

        if ($count >= 4) return ["begin" => $begin, "end" => $end];
        return false;

    }

    static private function getRelative($board, $column, $row, $relativeX, $relativeY) {
        if ($row + $relativeY < 0 || $row + $relativeY >= count($board)) return false;
        if ($column + $relativeX < 0 || $column + $relativeX >= count($board[$row])) return false;

        return $board[$row + $relativeY][$column + $relativeX];
    }

    static public function getState($websocket, $data) {

    	$users = GameStateController::session($data["id"])["users"];


    	if (in_array($websocket->getUserId(), $users)) {
    		$gameData = GameStateController::getData($data["id"]);
    		if (array_key_exists("actions", $gameData)) {
    			$websocket->emit('fiar_state', $gameData["actions"]);
	    	}
            if (array_key_exists("winner", $gameData)) return $websocket->emit("fiar_winner", $gameData["winner"]);
    	}

        $websocket->emit('turn', ["turn" => GameStateController::getTurn($data["id"])]);

    	// var_dump("GAME_DATA");
    	// var_dump($gameData);
    	// foreach($gameData["actions"] as $action) {
    	// 	$websocket->emit($action["action"], $action);
    	// }

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
    		GameStateController::setData($data["id"], $gameData);

            $websocket->to('vieropeenrij.' . $data["id"])->emit('turn', ["turn" => GameStateController::nextTurn($data["id"])]);
		} else if (sizeof($gameUsers) <= 1) {
			$websocket->emit('game_start', [ "error" => "Not enough players in the game." ]);
		} else if (sizeof($gameUsers) > 2) {
			$websocket->emit('game_start', [ "error" => "Too many players in the game." ]);
		}
	}

    public function play($id) {
    	if (GameStateController::sessionExists($id) && GameStateController::session($id)["game"] == 'fourinarow') {
            $gameData = GameStateController::getData($id);
            if (array_key_exists("started", $gameData)) {
                // return view(); // RETURN LOBBY VIEW
            }

    		GameStateController::addUser($id, auth()->user());

    		$userIds = GameStateController::session($id)["users"];
    		$users = User::select('name')->whereIn('id', $userIds)->get();

    		Websocket::broadcast()->to('vieropeenrij.' . $id)->emit('users', $users);
            // Websocket::broadcast()->to('vieropeenrij.' . $id)->emit('turn', ["turn" => GameStateController::nextTurn($id)]);

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
