<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(\App\Http\Requests\LoginRequest $request){
        $request->validated();
        $checkUser = User::where('username', $request['username'])->first();

        $auth = $request->only('username', 'password');

        if($checkUser->status !== 'active'){
            return redirect()->back()->withErrors(['password'=> 'Account not found!']); 
        }

        if(Auth::attempt($auth)){
            if(auth()->user()->role === 'donor'){
                return redirect('/donor-page');
            }
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

    public function profile(){
        $user_id = auth()->user()->id;
        $data['user_data'] = User::where('id', $user_id)->first();
        return view('Pages.Admin.profile.index', $data);
    }

    public function logout(){
        Auth::logout();

        return response()->json([
            'status' => 1
        ]);
    }
}
