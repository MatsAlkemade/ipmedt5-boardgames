<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Symfony\Component\Console\Output\ConsoleOutput;

class GameStateController extends Controller {
	protected $test;

    function __construct($d) {
    	$this->test = $d;
    }

    function setTest($d) {
    	$this->test = $d;
    }

    function getTest() {
    	return $this->test;
    }
}
