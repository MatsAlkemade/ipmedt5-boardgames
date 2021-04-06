<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GanzenbordController extends Controller
{
    public function index(){
        return view('ganzenbordstappen',[
            'ganzenbordstappen' =>\App\Models\GanzenbordStappen::all(),
            'ganzenbord'=>\App\Models\Ganzenbord::all(),
            
            
        ]);
    }
}
