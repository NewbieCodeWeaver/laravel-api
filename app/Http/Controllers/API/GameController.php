<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\partida;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class gameController extends Controller
{

    public function userRolldice(Request $request, $id) {

        // users can play IF they are using their id OR user is admin AND user exist

        $authUser = Auth::user();
        $player = user::find($id);

        if ($authUser->id == $id || $authUser->is_admin == 1 && $player) {

            $valor_dado1 = rand(1, 6);
            $valor_dado2 = rand(1, 6);

           // $valor_dado1 = 7;
           // $valor_dado2 = 7;

            $resultado = ($valor_dado1 + $valor_dado2);


            if ($resultado == 14) {

                $respuesta = " !Has ganado la partida!" ;

            } else {

                $respuesta = " !Sigue intentándolo!" ; 
            }

            $partida = new partida();
            $partida->valor_dado1 = $valor_dado1;
            $partida->valor_dado2 = $valor_dado2;
            $partida->resultado = $resultado;
            $partida->user_id = $id;

            $partida->save(); 

            return "El resultado de la partida es el siguiente: " . PHP_EOL . "Dado 1: " . $valor_dado1 . PHP_EOL . "Dado 2: " . $valor_dado2 . PHP_EOL . $respuesta;

        } else {

            return response ([

             "message" => "Unauthorized."
        
            ], 401);}

    }

    public function removePlays(Request $request, $id) {

        $authUser = Auth::user();
        $userPlays = partida::all()
        ->where('user_id', '=', $id);

       // return $userPlays;

        if ($authUser->id == $id || $authUser->is_admin == 1 && $userPlays->isNotEmpty()) {

            $userPlays->each->delete();

                return response('Plays deleted successfully', 200);

        } else {

            return response ([

                "message" => "Unauthorized."
   
            ], 401);}

     
    }}