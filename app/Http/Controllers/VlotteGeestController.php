<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VlotteGeestController extends Controller
{
    function index(){
        return view('vlotteGeest');
    }
}
