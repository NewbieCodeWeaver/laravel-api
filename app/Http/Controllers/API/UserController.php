<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
Use App\Models\partida;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function userChangeUsername(Request $request, $id) {


        if (empty($id)) {

           return "No existe un usuario con esa id";

        }

        $user = user::find($id);

        $user->nickname = $request->nickname;

        $user->save();


        return "El nombre de usuario ha sido cambiado correctamente";

        }


       public function getUserPlays($id) {


        $playerPlays = partida::join('users' , 'partidas.user_id' , '=' , 'users.id')
        ->select('users.name', 'partidas.id', 'partidas.valor_dado1', 'partidas.valor_dado2', 'partidas.resultado', 'partidas.porcentaje_exito')
        ->get();
       
          return $playerPlays;  
        
        }


        public function getUsersInfo() {

         // SELECT users.name as Player, 
         // ROUND(100 * SUM(resultado = 7) / COUNT(resultado)) as WinsPercentage
         // FROM `users` join `partidas` ON partidas.user_id = users.id group by users.name

          $playerPlays =  DB::table('users')
          ->select('users.name as Player', DB::raw('ROUND(100 * SUM(resultado = 7) / COUNT(resultado)) as WinsPercentage'))
          ->join('partidas','partidas.user_id','=','users.id')
          ->groupBy('users.name')
          ->get();


        return $playerPlays;
        
       
        }

        public function getUsersRanking() {

         // SELECT ROUND((SUM(resultado = 7) / COUNT(resultado) *100)) as PartidasTotalesGanadas
         // FROM `users` join `partidas` ON partidas.user_id = users.id


        $usersRanking = DB::table('users')
        ->select(DB::raw('ROUND(SUM(resultado = 7) / COUNT(resultado) *100) as PartidasTotalesGanadas'))
        ->join('partidas','partidas.user_id','=','users.id')
        ->get();


        return $usersRanking;

         }


        public function getWorstUserRank() {

         // SELECT users.name as Player, 
         // ROUND(100 * SUM(resultado = 7) / COUNT(resultado)) as WinsPercentage
         // FROM `users` join `partidas` ON partidas.user_id = users.id
         // group by users.name order by WinsPercentage ASC LIMIT 1
       
         $userWorstRank =  DB::table('users')
        ->select('users.name as Player', DB::raw('ROUND(100 * SUM(resultado = 7) / COUNT(resultado)) as WinsPercentage'))
        ->join('partidas','partidas.user_id','=','users.id')
        ->groupBy('users.name')
        ->orderBy('WinsPercentage', 'ASC')
        ->limit(1)
        ->get();
       
       
        return $userWorstRank;
               
              
         }

        public function getBestUserRank() {

        // SELECT users.name as Player, 
        // ROUND(100 * SUM(resultado = 7) / COUNT(resultado)) as WinsPercentage
        // FROM `users` join `partidas` ON partidas.user_id = users.id
        // group by users.name order by WinsPercentage ASC LIMIT 1
       
        $userBestRank =  DB::table('users')
        ->select('users.name as Player', DB::raw('ROUND(100 * SUM(resultado = 7) / COUNT(resultado)) as WinsPercentage'))
        ->join('partidas','partidas.user_id','=','users.id')
        ->groupBy('users.name')
        ->orderBy('WinsPercentage', 'DESC')
        ->limit(1)
        ->get();
       
       
        return $userBestRank;
               
              
        } }