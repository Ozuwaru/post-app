<?php

namespace App\Models;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable=
        [
            'text',
            'imgPath',
            'videoPath',
            'user_id'
        ];




        public static function createPost(Request $request){
            $post= new Post;
            $post->text = $request->text;
            $post->user_id= Auth::id();

            if($request->hasFile('img')){
                $post->imgPath= Post::storeUploads($request);
            }else if($request->hasFile('video')){
                $post->videoPath= Post::storeUploads($request);
                
            }
            $post->save();

            return $post;
        }
        
        public static function storeUploads(Request $request){
            if($request->hasFile('img')){
                $path= $request->file('img')->store('public/Images');
            }else if($request->hasFile('video')){
                $path= $request->file('video')->store('Videos');
                
            }
            $path = str_replace('public','',$path);
            return $path;
        }



        public static function getPosts($userid){
            $posts= Post::where('user_id',$userid)->get();
            return $posts;
        }
    use HasFactory;
}
