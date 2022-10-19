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

        $authUser = Auth::user();
        $player = user::find($id);
        $modeloUser = new User();
        $isAdmin = $modeloUser->checkAdmin($authUser);


        if ($authUser->id == $id || $isAdmin && $player) {

            $valor_dado1 = rand(1, 6);
            //$valor_dado1 = 7;
            $valor_dado2 = rand(1, 6);
            //$valor_dado2 = 7;
            $resultado = ($valor_dado1 + $valor_dado2);

            $partida = new partida();
            $partida->valor_dado1 = $valor_dado1;
            $partida->valor_dado2 = $valor_dado2;
            $partida->resultado = $resultado;
            $partida->user_id = $id;

            $partida->save(); 


            if ($resultado == 14) {
                
                return response()->json([
                    'Dado 1' => $valor_dado1,
                    'Dado 2' => $valor_dado2,
                    'resultado' => 'Gana'
                ]);

            } else {

                return response()->json([
                    'Dado 1' => $valor_dado1,
                    'Dado 2' => $valor_dado2,
                    'Resultado' => 'Pierde'
                ]);
            }

        } else {

            return response ([

             "message" => "Unauthorized."
        
            ], 401);}

    }

    public function removePlays(Request $request, $id) {

        $authUser = Auth::user();
        $modeloPartida = new partida();
        $userPlays = $modeloPartida->getUserPlays($id);

        $modeloUser = new User();
        $isAdmin = $modeloUser->checkAdmin($authUser);

          if ($authUser->id == $id || $isAdmin && $userPlays->isNotEmpty()) {

            $userPlays->each->delete();

                return response('Plays deleted successfully', 200);

        } else {

            return response ([

                "message" => "Unauthorized."
   
            ], 401);}

     
    }}