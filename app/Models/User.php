<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     // Relacion uno a muchos

     public function partidas()
     {
 
         return $this->hasMany('App\Models\Partida');
     }


     public function getUserPercentage($id) {


        // SELECT ROUND((SUM(resultado = 14) / COUNT(resultado) *100)) as PartidasTotalesGanadas
          // FROM `users` join `partidas` ON partidas.user_id = users.id WHERE users.id = 15

          $userPercentage = DB::table('users')
          ->select(DB::raw('ROUND(SUM(resultado = 14) / COUNT(resultado) *100) as PorcentajePartidasGanadas'))
          ->join('partidas','partidas.user_id','=','users.id')
          ->where('users.id','=', $id)
          ->get();

          return $userPercentage;



     }


     public function getPlayerPlays() {

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

         return $usersRanking;


     }


     public function getWorstRank() {

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

        return $userWorstRank;


     }


     public function getUserBestRank() {


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


        return $userBestRank;


     }

}