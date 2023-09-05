<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function save(Request $request){
       //dd($request->all());
        
        $rules=[
            'name'=>'required|string|max:255',
            'password'=>'required|confirmed|string|min:8',
            'email'=>'required|email|unique:users|max:255',
            'date'=>'required|date|before:2019-01-01',

        ];
        $request->validate($rules);


        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'birthDate'=>$request->date
        ]);

        


        $this->authenticate($request);
    }


    public function authenticate(Request $request){
        $credentials= $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email'=> 'The provided credentials do not match our records.',
            ])->onlyInput('email');
    }

}
