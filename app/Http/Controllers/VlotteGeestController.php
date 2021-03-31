<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VlotteGeestController extends Controller
{
    public function index(){
        return view('games.vlotteGeest');
    }

    // public function index(){
    //     return view('games.vlotteGeest',[
    //         'sushi' => \App\Models\Sushi::all()
    //     ]);

    // }
}
