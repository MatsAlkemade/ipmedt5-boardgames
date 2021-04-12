<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GanzenbordController extends Controller
{
    public function index(){
        return view('games.ganzenbordstappen',[
            'ganzenbordstappen' =>\App\Models\GanzenbordStappen::all(),
            'ganzenbord'=>\App\Models\Ganzenbord::all(),
            
            
        ]);
    }

    public function create(Request $request) {
    	// dd($request->session());

    	// if ($request->session()->error) {
    	// 	return $request->session()->error;
    	// }

    	$id = GameStateController::createSession('ganzenbord', auth()->user());

    	return redirect('/ganzenbord/' . $id);

    	// return view('games.');
    }
}
