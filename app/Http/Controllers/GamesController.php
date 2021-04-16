<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GamesController extends Controller
{
    public function index(){
        return view('home',[
            'games' => \App\Models\Games::all()
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function create($id){
        return view('games.create.' . \App\Models\Games::find($id)->name . 'Create',[
            'game' => \App\Models\Games::find($id),
        ]);
    }

    public function show($game){
     
        switch($game){

            case 'vierOpEenRij':
                return redirect('/vieropeenrij');

                break;

            case 'thirtyseconds':
                return view('games.thirtyseconds',[
                    'ts' => \App\Models\ThirtySeconds::first(),
                    'tsq' => \App\Models\ThirtySecondsQuestion::get(),
                ]);

                break;

            case 'trivialpursuit':

                break;

            case 'vlottegeest':
                return view('games.vlotteGeest',[
                    'vg' => \App\Models\VlotteGeest::all(),
                ]);
                break;

            case 'ganzenbord':

                break;
        }
    }
}
