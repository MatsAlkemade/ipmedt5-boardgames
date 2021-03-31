<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Cache;

class GameStateController extends Controller {
	protected $sessions;

    static function createSession($gameType, $user) {
    	fetchCache();
    	// TODO: Generate a random id of 6 numbers
    	$sessionId = 123456;
    	$sessions[$sessionId] = [
    		"game" => $gameType,
			"users" => [
				$user->id,
			],
			"data" => []
    	];

    	Cache::put('sessions', $sessions);
    }

    static function addUser($sessionId, $user) {
    	fetchCache();
    	array_push($sessions[$sessionId]["users"], $user->id);

    	Cache::put('sessions', $sessions);
    }

    static function removeSession($sessionId) {
    	fetchCache();

    	unset($sessions[$sessionId]);
    	Cache::put('sessions', $sessions);
    }

    static function session($sessionId) {
    	fetchCache();
    	return $sessions[$sessionId];
    }

    static function setData($sessionId, $data) {
    	$this->fetchCache();
    	$sessions[$sessionId]["data"] = $data;
    	Cache::put('sessions', $sessions);
    }

    static function getData($sessionId, $data) {
    	fetchCache();
    	return $sessions[$sessionId]["data"];
    }

    private static function fetchCache() {
    	$sessions = Cache::get('sessions');
    }
}