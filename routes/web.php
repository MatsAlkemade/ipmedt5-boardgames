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

Route::get('/', [\App\Http\Controllers\GamesController::class, 'index']);
Route::get('/vlottegeest', [\App\Http\Controllers\VlotteGeestController::class, 'index']);
Route::middleware(['auth'])->group(function(){
    Route::get('/', [\App\Http\Controllers\GamesController::class, 'index']);
    Route::get('/logout', [\App\Http\Controllers\GamesController::class, 'logout']);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
