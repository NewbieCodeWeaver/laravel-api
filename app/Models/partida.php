<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partida extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'valor_dado1',
        'valor_dado2',
        'resultado',
        'user_id'
        
    ];


     // Relacion uno a muchos (inversa)


    public function usuario()
    {

        return $this->belongsTo('App\Models\User');
    }



    public function getPlayerPlays($id) {


        $playerPlays = partida::join('users' , 'partidas.user_id' , '=' , 'users.id')
        ->select('users.name', 'partidas.id', 'partidas.valor_dado1', 'partidas.valor_dado2', 'partidas.resultado')
       ->where('users.id', '=', $id)
        ->get();


        return $playerPlays;


    }

    public function getUserPlays($id) {
 
        $userPlays = partida::all()
        ->where('user_id', '=', $id);

        return $userPlays;

    }



}
