<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function set(int $id,bool $type){
        $user_id = Auth::id();
        

        $likeRow = Like::where('user_id',$user_id)->where('post_id',$id)->first();
        if($likeRow==null){
            $likeRow= new Like();
            $likeRow->user_id = $user_id;
            $likeRow->post_id= $id;
            
            
        }
        else if($type == $likeRow->type){
            $likeRow->delete();
            return response()->json(['message'=>'the row has been deleted successfully'],204);
        }
        
        $likeRow->isLike = $type;

        $likeRow->save(); 

        return response()->json(['type'=>$type],201);
    }

    public function  get($post_id){
        $likes = Like::where('post_id',$post_id)->where('isLike',true)->count();
        $dislikes = Like::where('post_id',$post_id)->where('isLike',false)->count();


        return response()->json(['likes'=>$likes,'dislikes'=>$dislikes],201);
    }
}
