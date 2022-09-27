<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\partida;

class gameController extends Controller
{

    public function userRolldice(Request $request, $id) {

     $valor_dado1 = rand(1, 6);
     $valor_dado2 = rand(1, 6);

     $resultado = ($valor_dado1 + $valor_dado2);


        if ($resultado == 14) {

            $respuesta = " !Has ganado la partida!" ;

            } else {

                $respuesta = " !Sigue intentándolo!" ; }  
 

     $partida = new partida();

         $partida->valor_dado1 = $valor_dado1;
         $partida->valor_dado2 = $valor_dado2;
         $partida->resultado = $resultado;
         $partida->user_id = $id;

     $partida->save(); 

     return "El resultado de la partida es el siguiente: " . PHP_EOL . "Dado 1: " . $valor_dado1 . PHP_EOL . "Dado 2: " . $valor_dado2 . PHP_EOL . $respuesta;

    }

    public function removePlays(Request $request, $id) {


        $partida = partida::where('user_id', '=', $id)
        ->get();  
    
            return $partida;
    
    }

     
    }




