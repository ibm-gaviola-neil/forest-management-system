<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(\App\Http\Requests\LoginRequest $request){
        $request->validated();

        $auth = $request->only('username', 'password');

        if(Auth::attempt($auth)){
            return redirect('/admin');
        }

        return redirect()->back()->withErrors(['password'=> 'Wrong Credentials']);
    }

    public function user(){
        $user = Auth::user();

        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout(){
        Auth::logout();

        return response()->json([
            'status' => 1
        ]);
    }
}
