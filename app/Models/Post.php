<?php

namespace App\Models;

use App\Providers\CommentInfo;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class Post extends Model
{
    protected $fillable=
        [
            'text',
            'imgPath',
            'videoPath',
            'user_id'
        ];

        public $CommentArr = array();
        public $userName;
        public $userImg;
        public static function addComments(Comment $c){
            /**
             * al pasar el comentario tenemos que preparar el nombre del usuario,
             * comentario y el id del comentario para guardarlo en el objeto
             */

            //$cID=User::find($c->user_id);
            $cID=User::select('name')->where('id',$c->user_id)->get()->first();
            
            //dd($cID->name);
            $comentI = new CommentInfo($c->user_id,$c->text,$cID->name,$c->updated_at);
            //dd($comentI);
            return $comentI;
        }

        public static function createPost(Request $request){
            $post= new Post;
            $post->text = $request->text;
            $post->user_id= Auth::id();
            if($request->hasFile('img')){
               $post->imgPath= Post::storeUploads($request);
                //dd("hay archivo");
            }/*else if($request->hasFile('video')){
                $post->videoPath= Post::storeUploads($request);
                
            }*/
           // dd("no hay archivo");
            $post->save();

            return $post;
        }

        public static function updateText(Request $request){
            $post = Post::where('id',$request->id)->get()->first();
            //dd($post);
            $post->text = $request->text;
            $post->save();
        }
        
        public static function storeUploads(Request $request){
            if($request->hasFile('img')){
                $path= $request->file('img')->store('public/Images');
            }/*else if($request->hasFile('video')){
            //     $path= $request->file('video')->store('Videos');
                
            // }*/
            $path = str_replace('public','',$path);
            return $path;
        }



        public static function getPosts($userid){
            //$posts= Post::where('user_id',$userid)->get();

            $posts = DB::table('posts')
                ->select('id','text','imgPath','user_id','created_at')

                ->whereExists(function (Builder $query) use ($userid){

                    $query->select(DB::raw(1))
                    ->from('followers')
                    ->where('followers.user_id',"{$userid}")
                    ->whereColumn('followers.following','posts.user_id');

                })
                ->orWhere('user_id','=',$userid)->paginate(10);
                
                //$posts = Post::hydrate($posts->all());
                foreach($posts as $post){
                    $userData = User::select('name','imgPath')->where('id',$post->user_id)->first();
                    //dd($userData);
                    $post->userName = $userData->name;
                    $post->userImg= $userData->imgPath;
                    $post->comments = Comment::getCurrentPostComment(($post->id));
                    
                    ///dd($post->userName);
                }
                
            return $posts;
        }
        public static function getOwnPosts($userid){
            //$posts= Post::where('user_id',$userid)->get();

            $posts = DB::table('posts')
                ->orWhere('user_id','=',$userid)->paginate(10);
                
                //$posts = Post::hydrate($posts->all());
                foreach($posts as $post){
                    $userData = User::select('name','imgPath')->where('id',$post->user_id)->first();
                    //dd($userData);
                    $post->userName = $userData->name;
                    $post->userImg= $userData->imgPath;
                    $post->comments = Comment::getCurrentPostComment(($post->id));
                    
                    ///dd($post->userName);
                }                
            return $posts;
        }

        public static function deleteWithId(int $id){
            
            $post = Post::find($id);

            if($post->imgPath!=null && Storage::exists('public'.$post->imgPath)){
                Storage::delete('public'.$post->imgPath);
            }else if (Storage::exists('public'.$post->videoPath)){
                
                Storage::delete('public'.$post->videoPath);
            }
            $post->delete();
        }
    use HasFactory;
}
