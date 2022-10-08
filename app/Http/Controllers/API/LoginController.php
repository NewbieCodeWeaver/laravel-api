<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->validate([

            'nickname'=> 'required',
            'password' => 'required'
        ]);

        if(!Auth()->attempt($credentials)){

            return response ([

                "message" => "Usuario y/o contraseña incorrecta."
            
            ], 401);
        }
            $user = $request->user();
            $accessToken = $user->createToken('authTestToken')->accessToken;

            return response([
                
                'user'=> Auth::user(),
                'access_token'=> $accessToken,
            
            ],200);
    
        
    }
    
}