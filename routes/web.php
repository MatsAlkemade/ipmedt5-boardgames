<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/games', [\App\Http\Controllers\GamesController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ganzenbord',  [\App\Http\Controllers\GanzenbordController::class, 'index']);
    