<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Database\Eloquent\Model;
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
        $user->roles()->attach(2);

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

    public function index(){
        $users = User::with('roles')->get();
        return response()->json([
            'message' => 'success',
            'data'    => $users
        ]);
    }

    public function show(){
        $user = Auth::user();
        $user['roles'] = $user->roles;
        return response()->json([
            'message' => 'success',
            'data'    => $user
        ]);
    }

    public function update(Request $request){

        $credentials = $request->validate([
            'name' => 'required|unique:users,name,'.Auth::user()->id.'|max:255',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id.'|min:3',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();
        $user->roles()->detach();
        $user->roles()->attach($request->role_id);
        $user['roles'] = $user->roles;

        if(!$credentials) {
            return response()->json([
                'message' => 'failed',
                'data' => 'user update failed'
            ],422);
        }

        $token = $user->createToken('auth-user')->plainTextToken;

        return response()->json([
            'message' => 'success',
            'data' => $user,
            'token' => $token
        ],200);

    }
}
