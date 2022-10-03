<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
Use App\Models\partida;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userChangeUsername(Request $request, $id) {


      $authUser = Auth::user();
      $user = user::find($id);


      if ($authUser->id == $id || $authUser->is_admin == 1 && $user) {


        $request->validate([

          'nickname' =>'required|min:3|max:50',
       
        ]);

        $user = user::find($id);

        $user->nickname = $request->nickname;

        $user->save();

        return response('Username changed correctly', 200);

    
      } else {


        return response ([

        "message" => "Unauthorized."
      
        ], 401);} }


       public function getUserPlays($id) {


        $authUser = Auth::user();
        $userPlays = partida::all()
        ->where('user_id', '=', $id);

        // return $userPlays;

  
        if ($authUser->id == $id || $authUser->is_admin == 1 && $userPlays) {

          if ($userPlays->isEmpty()) {

            return response('No plays to show', 200);
  
          }
        

          $playerPlays = partida::join('users' , 'partidas.user_id' , '=' , 'users.id')
          ->select('users.name', 'partidas.id', 'partidas.valor_dado1', 'partidas.valor_dado2', 'partidas.resultado')
         ->where('users.id', '=', $id)
          ->get();
      
          // SELECT ROUND((SUM(resultado = 14) / COUNT(resultado) *100)) as PartidasTotalesGanadas
          // FROM `users` join `partidas` ON partidas.user_id = users.id WHERE users.id = 15

          $userPercentage = DB::table('users')
          ->select(DB::raw('ROUND(SUM(resultado = 14) / COUNT(resultado) *100) as PorcentajePartidasGanadas'))
          ->join('partidas','partidas.user_id','=','users.id')
          ->where('users.id','=', $id)
          ->get();


            return [$playerPlays, $userPercentage];


        } else {

          return response ([
  
            "message" => "Unauthorized."
        
          ], 401);}
        
        }
       

        public function getUsersInfo() {  

         // SELECT users.name as Player, 
         // ROUND(100 * SUM(resultado = 14) / COUNT(resultado)) as WinsPercentage
         // FROM `users` join `partidas` ON partidas.user_id = users.id group by users.name


          $playerPlays =  DB::table('users')
          ->select('users.name as Player',  DB::raw('ROUND(100 * SUM(resultado = 14) / COUNT(resultado)) as WinsPercentage'))
          ->leftjoin('partidas','partidas.user_id','=','users.id')
          ->groupBy('users.name')
          ->get();


          return $playerPlays;
        
       
        }

        public function getUsersRanking() {

         // SELECT ROUND((SUM(resultado = 14) / COUNT(resultado) *100)) as PartidasTotalesGanadas
         // FROM `users` join `partidas` ON partidas.user_id = users.id


        $usersRanking = DB::table('users')
        ->select(DB::raw('ROUND(SUM(resultado = 14) / COUNT(resultado) *100) as PorcentajeMedioExitos'))
        ->join('partidas','partidas.user_id','=','users.id')
        ->get();


          if (is_null($usersRanking)) {

            return response ([

             "message" => "We have no data to show yet"
          
            ], 200);}


          return $usersRanking;

         }


        public function getWorstUserRank() {

         // SELECT users.name as Player, 
         // ROUND(100 * SUM(resultado = 14) / COUNT(resultado)) as WinsPercentage
         // FROM `users` join `partidas` ON partidas.user_id = users.id
         // group by users.name order by WinsPercentage ASC LIMIT 1
       
         $userWorstRank =  DB::table('users')
        ->select('users.name as Player', DB::raw('ROUND(100 * SUM(resultado = 14) / COUNT(resultado)) as WinsPercentage'))
        ->join('partidas','partidas.user_id','=','users.id')
        ->groupBy('users.name')
        ->orderBy('WinsPercentage', 'ASC')
        ->limit(1)
        ->get();

        
        if($userWorstRank->isEmpty()) {

          return response ([

            "message" => "We have no data to show yet"
        
          ], 200);}

       
       
        return $userWorstRank;
               
              
         }

        public function getBestUserRank() {

        // SELECT users.name as Player, 
        // ROUND(100 * SUM(resultado = 14) / COUNT(resultado)) as WinsPercentage
        // FROM `users` join `partidas` ON partidas.user_id = users.id
        // group by users.name order by WinsPercentage ASC LIMIT 1
       
       
        $userBestRank =  DB::table('users')
        ->select('users.name as Player', DB::raw('ROUND(100 * SUM(resultado = 14) / COUNT(resultado)) as WinsPercentage'))
        ->join('partidas','partidas.user_id','=','users.id')
        ->groupBy('users.name')
        ->orderBy('WinsPercentage', 'DESC')
        ->limit(1)
        ->get();

          if($userBestRank->isEmpty()) {

            return response ([
  
              "message" => "We have no data to show yet"
          
            ], 200);}

       
       
        return $userBestRank;
               
              
}}