<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(){
        return view('user/create');
    }
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


        
        return redirect('/');
    }
}
