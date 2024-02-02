<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function follow(Request $request){
        if($request->ajax()){

            $follower = Follower::retrieveData(Auth::id(),$request->id);
            if($follower==null){
                // //dd("no hay nada");
                $follower = new Follower(['user_id'=>Auth::id(),'following'=>$request->id]);
                $follower->save();
                return response()->json([

                    'message'=> "La relacion ha sido guardada",

    
                ], 201);
            }else{
                $follower->delete();
                return response()->json([
                ], 204);
            }

            
        }else{
            abort(500,"Accessing by a diferent method that the predefined");
        }


    }

    
}
