<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 8|Sd1kwavNspKNEtQms1Na0vPQGMQPXwohvVBJk8rX0767e13b

class AuthController extends Controller
{

    use HttpResponses;

    public function login(Request $request){
        if(Auth::attempt($request->only('email', 'password'))){
            return $this->response('Usuário autorizado!', 200, [
                'token' => $request->user()->createToken('user', ['user-index', 'user-show', 'user-update', 'user-destroy'])->plainTextToken
            ]);
        }

        // $user = Auth::user();
        // $token = $request->user()->createToken('token')->plainTextToken;

        return $this->response('Usuário não autorizado!', 403);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return $this->response('Token revogado!', 200);
    }
}
