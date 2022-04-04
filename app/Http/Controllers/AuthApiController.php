<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthApiController extends Controller
{
    public function register(Request $request){
        $credentials = $request->validate([
            'name' => 'required|unique:users,name|max:225',
            'email' => 'required|unique:users,email|min:3',
            'password' => 'required|min:6|integer',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();

        if(!$credentials) {
            return response()->json([
                'message' => 'failed',
                'data' => 'user create failed'
            ],422);
        }

        $token = $user->createToken('auth-user')->plainTextToken;

        return response()->json([
            'message' => 'success',
            'data' => $user,
            'token' => $token
        ],200);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(\Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'success',
                'data' => $user,
                'token' => $token
             ]);
        }

        return response()->json(['message' => 'login failed'],422);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message'=> 'Successfully logged out'
        ]);
    }
}
