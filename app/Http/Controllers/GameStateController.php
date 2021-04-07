<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Cache;

class GameStateController extends Controller {
	protected static $sessions;

    static function createSession($gameType, $user) {
    	self::$sessions = Cache::get('sessions');
    	// TODO: Generate a random id of 6 numbers
    	$sessionId = mt_rand(100000, 999999);
    	$c = 0;
    	while (self::sessionExists($sessionId) == true) {
    		if ($c > 10) return false;
    		$c++;
    		$sessionId = mt_rand(100000, 999999);
    	}
    	self::$sessions[$sessionId] = [
    		"game" => $gameType,
			"users" => [
				$user->id,
				// 1,
			],
			"teams" => [],
			"data" => [],
			"turn" => null,
			"turnMode" => 0, // 0 == users, 1 == teams
    	];

    	Cache::put('sessions', self::$sessions);

    	return $sessionId;
    }

    static function setTurnMode($sessionId, $mode) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');

    	self::$sessions[$sessionId]["turnMode"] = $mode;

    	Cache::put('sessions', self::$sessions);
    	return $mode;
    }

    static function getTurnMode($sessionId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');
    	return self::$sessions[$sessionId]["mode"];
    }

    static function sessionExists($sessionId) {
    	self::$sessions = Cache::get('sessions');

    	if (self::$sessions === null || !array_key_exists($sessionId, self::$sessions)) {
    		return false;
    	}

    	return true;
    }

    static function joinTeam($sessionId, $userId, $teamId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');

    	if (!in_array($userId, self::$sessions[$sessionId]["users"])) return null;

    	if (!array_key_exists($teamId, self::$sessions[$sessionId]["teams"])) {
    		self::$sessions[$sessionId]["teams"][$teamId] = [];
    	}

    	if (!in_array($userId, self::$sessions[$sessionId]["teams"][$teamId])) {
    		array_push(self::$sessions[$sessionId]["teams"][$teamId], $userId);
    	}

    	Cache::put('sessions', self::$sessions);
    	return self::$sessions[$sessionId]["teams"];
    }

    static function removeUser($sessionId, $userId, $removeFromUserArray=true) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');

    	foreach (self::$sessions[$sessionId] as $team => $user) {
    		if ($user == $userId) unset(self::$sessions[$sessionId][$team]);
    	}

    	$a = array_search($user->id, self::$sessions[$sessionId]["users"]);
    	if ($a !== false) {
    		unset(self::$sessions[$sessionId]["users"][$a]);
    	}

    	Cache::put('sessions', self::$sessions);
    	return $userId;
    }

    static function addUser($sessionId, $user) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');

    	$a = in_array($user->id, self::$sessions[$sessionId]["users"]);
    	if ($a === false) {
    		array_push(self::$sessions[$sessionId]["users"], $user->id);
    	}

    	Cache::put('sessions', self::$sessions);
    	return $user->id;
    }

    static function removeSession($sessionId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');

    	unset(self::$sessions[$sessionId]);
    	Cache::put('sessions', self::$sessions);
    	return true;
    }

    static function session($sessionId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');
    	return self::$sessions[$sessionId];
    }

    static function setData($sessionId, $data) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');
    	self::$sessions[$sessionId]["data"] = $data;
    	Cache::put('sessions', self::$sessions);
    	return $data;
    }

    static function getData($sessionId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');
    	return self::$sessions[$sessionId]["data"];
    }

    static function nextTurn($sessionId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');


    	if (self::$sessions[$sessionId]["turnMode"] == 0) return self::nextTurnUser($sessionId);
    	if (self::$sessions[$sessionId]["turnMode"] == 1) return self::nextTurnTeam($sessionId);
    	
    	return null;
    }

    private static function nextTurnUser($sessionId) {
    	self::$sessions = Cache::get('sessions');

    	if (self::$sessions[$sessionId]["turn"] === null) {
    		self::$sessions[$sessionId]["turn"] = 0; // TODO: random player??
    		Cache::put('sessions', self::$sessions);
    		return self::$sessions[$sessionId]["turn"];
    	}

    	self::$sessions[$sessionId]["turn"] += 1;

    	if (self::$sessions[$sessionId]["turn"] >= count(self::$sessions[$sessionId]["users"])) {
    		self::$sessions[$sessionId]["turn"] = 0;
    	}

		Cache::put('sessions', self::$sessions);

    	return self::$sessions[$sessionId]["turn"];
    }

    private static function nextTurnTeam($sessionId) {
    	self::$sessions = Cache::get('sessions');

    	if (self::$sessions[$sessionId]["turn"] === null) {
    		self::$sessions[$sessionId]["turn"] = self::getNextTeam($sessionId, self::$sessions[$sessionId]["turn"]);
    		Cache::put('sessions', self::$sessions);
    		return self::$sessions[$sessionId]["turn"];
    	}

    	self::$sessions[$sessionId]["turn"] = self::getNextTeam($sessionId, self::$sessions[$sessionId]["turn"]);

    	// if (self::$sessions[$sessionId]["turn"] >= count(self::$sessions[$sessionId]["teams"])) {
    	// 	self::$sessions[$sessionId]["turn"] = 0;
    	// }

		Cache::put('sessions', self::$sessions);

    	return self::$sessions[$sessionId]["turn"];
    }

    private static function getNextTeam($sessionId, $teamId) {
    	self::$sessions = Cache::get('sessions');
    	$found = false;

    	foreach (self::$sessions[$sessionId]["teams"] as $team => $users) {
    		if ($found == true || $teamId === null) return $team;

    		if ($team == $teamId) $found = true;
    	}

    	if ($teamId >= max(array_keys(self::$sessions[$sessionId]["teams"]))) return min(array_keys(self::$sessions[$sessionId]["teams"]));

    	return $teamId+1;
    }

    static function getTurn($sessionId) {
    	if (!self::sessionExists($sessionId)) return null;
    	self::$sessions = Cache::get('sessions');
    	return self::$sessions[$sessionId]["turn"];
    }

    public static function fc() {
    	return Cache::get('sessions');
    }
}