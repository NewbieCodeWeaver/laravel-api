<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partida extends Model
{
    use HasFactory;


     // Relacion uno a muchos (inversa)
     

    public function usuario()
    {

        return $this->belongsTo('App\Models\User');
    }



}
