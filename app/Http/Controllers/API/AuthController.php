<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request) {

        if (empty($request->nickname)) {

            $request->request->add(['nickname' => 'Anonimo']);

        }

        $validatedData = $request->validate ([

            'name' => 'nullable|min:3|max:50',
            'nickname' =>'nullable|min:3|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',

        ]);

        $validatedData ['password'] = Hash::make($request->password);

        $user = User::create ($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([

            'user' => $user,
            'access_token' =>  $accessToken,

        ]);



    }

}