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

Route::middleware(['auth'])->group(function(){
    Route::get('/', [\App\Http\Controllers\GamesController::class, 'index']);
    Route::get('/logout', [\App\Http\Controllers\GamesController::class, 'logout']);
    Route::get('/vlottegeest', [\App\Http\Controllers\VlotteGeestController::class, 'index']);
    Route::post('/thirtyseconds', [\App\Http\Controllers\ThirtySecondsController::class, 'store']);
    Route::get('/games/create/{id}', [\App\Http\Controllers\GamesController::class, 'create']);
    Route::get('/games/{game}', [\App\Http\Controllers\GamesController::class, 'show']);

    Route::get('/trivialpursuit', [\App\Http\Controllers\TrivialPursuitController::class, 'index']);
    Route::get('/trivialpursuit/{id}', [\App\Http\Controllers\TrivialPursuitQuestionsController::class, 'index']);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
