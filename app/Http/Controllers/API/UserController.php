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

      $modeloUser = new User();
      $isAdmin = $modeloUser->checkAdmin($authUser);


      if ($authUser->id == $id || $isAdmin && $user) {


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

        $modeloUser = new User();
        $isAdmin = $modeloUser->checkAdmin($authUser);

        $userPlays = partida::all()
        ->where('user_id', '=', $id);

  
        if ($authUser->id == $id || $isAdmin && $userPlays) {

          if ($userPlays->isEmpty()) {

            return response()->json(['Number of plays' => 0], 201); 
  
          }

        $modeloPartida = new partida();

        $playerPlays = $modeloPartida->getPlayerPlays($id);

        $modelUser = new user();

        $userPercentage = $modelUser->getUserPercentage($id);

            return [$playerPlays, $userPercentage];


        } else {

          return response ([
  
            "message" => "Unauthorized."
        
          ], 401);}
        
        }
       

        public function getUsersInfo() { 
          
          $modeloUsers = new user();
          $playerPlays =  $modeloUsers->getPlayerPlays();

          return $playerPlays;
        
       
        }

        public function getUsersRanking() {

         $modeloUsers = new user();
         $usersRanking = $modeloUsers->getUsersRanking();


          if (is_null($usersRanking)) {

            return response ([

             "message" => "We have no data to show yet"
          
            ], 200);}


          return $usersRanking;

         }


        public function getWorstUserRank() {

          $modeloUsers = new user();
          $userWorstRank = $modeloUsers->getWorstRank();

          return $userWorstRank;

        
        if($userWorstRank->isEmpty()) {

          return response ([

            "message" => "We have no data to show yet"
        
          ], 200);}

       
       
        return $userWorstRank;
               
              
         }

        public function getBestUserRank() {

          $modeloUsers = new user();
          $userBestRank = $modeloUsers->getUserBestRank();

          if($userBestRank->isEmpty()) {

            return response ([
  
            "message" => "We have no data to show yet"
          
            ], 200);}

       
       
        return $userBestRank;
               
              
}}