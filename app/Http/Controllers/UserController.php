<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function save(Request $request){
       
        
        $rules=[
            'name'=>'required|string|max:255',
            'password'=>'required|confirmed|string|min:8',
            'email'=>'required|email|unique:users|max:255',
            'date'=>'required|date|before:2019-01-01',

        ];
        $request->validate($rules);
        User::createUser($request);

        

        


        return $this->authenticate($request);
    }


    public function update(Request $request){

        return User::updateUser($request);
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

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('login');
    }

    public static function search(Request $request){
        //dd($request->search);
        $users =User::getUserToFollow(Auth::id(),$request->search);
        /**
         * Aqui debo ecribir un query el cual me va a devolver los usuarios que el usuario no 
         * haya agregado como amigos.
         * Todavia falta limitar la busqueda por nombre.
         */
        if($request->ajax()){
            $view = view('user.data',compact('users'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('user.search',compact('users'));
        
        
    }

    public function view($id,Request $request){
        $user =User::find($id);
        $posts= Post::getOwnPosts($id);
        $sessionId= Auth::id();
        if(
            DB::table('followers')
            ->where('followers.user_id',"{$sessionId}")
            ->where('followers.following',"{$user->id}")->first()
        ){
                $user->followed= true;
        }else{
                $user->followed= false;

        }
        if($request->ajax()){
            $view = view('homeData',['user'=>$user,'posts'=>$posts])->render();
            return response()->json(['html'=>$view]);
        }
        
        return view('user/view',['user'=>$user,'posts'=>$posts]);
    }

}
