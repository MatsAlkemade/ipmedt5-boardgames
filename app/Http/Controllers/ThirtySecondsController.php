<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThirtySecondsController extends Controller
{
    public function store(Request $request){
        $inputs = ['q1', 'q2', 'q3', 'q4', 'q5'];
        $answers = [];
        foreach($inputs as $input){
            if($request->input($input)){
                $answers[$input] = true;
            }else{
                $answers[$input] = false;
            }
        }

        return redirect('/games/thirtyseconds');
    }
}
