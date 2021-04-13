<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\VierOpEenRijController;

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
    Route::get('/games/create/{id}', [\App\Http\Controllers\GamesController::class, 'create']);
    Route::get('/games/{game}', [\App\Http\Controllers\GamesController::class, 'show']);

    Route::get('/thirtyseconds', [\App\Http\Controllers\ThirtySecondsController::class, 'show']);
    Route::post('/thirtyseconds', [\App\Http\Controllers\ThirtySecondsController::class, 'store']);
    Route::get('/thirtyseconds/create', [\App\Http\Controllers\ThirtySecondsController::class, 'create']);
    Route::get('/thirtyseconds/{id}', [\App\Http\Controllers\ThirtySecondsController::class, 'play']);

    Route::get('/trivialpursuit', [\App\Http\Controllers\TrivialPursuitController::class, 'index']);
    Route::get('/trivialpursuit/{id}', [\App\Http\Controllers\TrivialPursuitQuestionsController::class, 'index']);

    Route::get('/vieropeenrij', [VierOpEenRijController::class, 'index']);
    Route::get('/vieropeenrij/create', [VierOpEenRijController::class, 'create']);
    Route::get('/vieropeenrij/{id}', [VierOpEenRijController::class, 'play']);

    Route::get('/test', function(Request $req) {
    	return ["session" => session()->all()];
    });
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
