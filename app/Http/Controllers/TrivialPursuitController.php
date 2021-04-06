<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrivialPursuitController extends Controller
{
    public function index(){
        return view('TrivialPursuit.index',[
            'trivialpursuit' => \App\Models\TrivialPursuit::first()
        ]);
    }
}
