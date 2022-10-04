<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\userController;
use App\Http\Controllers\API\gameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('players', [AuthController::class, 'register']); // crea un jugador/a
Route::post('login', [LoginController::class, 'login'])->name('login'); // login jugador


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->group(function () {

Route::put('players/{id}', [userController::class, 'userChangeUsername']); // modifica el nom del jugador/a.
Route::post('players/{id}/games/', [gameController::class, 'userRolldice']); // un jugador/a específic realitza una tirada dels daus.
Route::delete('players/{id}/games', [gameController::class, 'removePlays']); // elimina les tirades del jugador/a. 
Route::get('players/ranking/loser', [userController::class, 'getWorstUserRank']); // retorna el jugador/a amb pitjor percentatge d’èxit
 Route::get('players/ranking/winner', [userController::class, 'getBestUserRank']); // retorna el jugador/a amb millor percentatge d’èxit.

});

Route::middleware('auth:api','admin')->group(function () {

Route::get('players', [userController::class, 'getUsersInfo']); // retorna el llistat de tots els jugadors/es del sistema amb el seu percentatge mitjà d’èxits 
Route::get('players/{id}/games', [userController::class, 'getUserPlays']); // retorna el llistat de jugades per un jugador/a.
Route::get('players/ranking', [userController::class, 'getUsersRanking']); // retorna el rànquing mitjà de tots els jugadors/es del sistema. És a dir, el percentatge mitjà d’èxits.

});

?>