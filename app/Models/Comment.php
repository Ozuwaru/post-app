<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Comment extends Model
{
    protected $fillable=[
        'text','post_id','user_id'
    ];
    public $userImg;

    public function set(string $text,int $post_id, int $user_id)
    {
        $this->text = $text;
        $this->post_id= $post_id;
        $this->user_id= $user_id;
    }

    public static function createComment(Request $request, int $user_id){
        $c= new Comment;
        $rules=[
            'comment'=>'required|string|max:255',
            'post_id'=>'required|integer',

        ];
        $request->validate($rules);
        $c->set($request->comment,$request->post_id,$user_id);
        $c->save();

    }

    public static function getCurrentPostComment(int $Postid){
        $comments= Comment::select('id','user_id','text','updated_at')->where('post_id',$Postid)->get();
        foreach($comments as $comment){
            $userInfo = User::where('id', $comment->user_id)->select('name','imgPath')->first();
            $comment->userN= $userInfo->name;
            $comment->userImg = $userInfo->imgPath;
        }
        return $comments->all();

    }

    public static function deleteComment(int $id){
        $comment = Comment::where('id',$id)->first();
        $comment->delete();
    }
    public static function updateComment(int $id,string $text){
        $comment = Comment::where('id',$id)->first();
        $comment->text = $text;
        $comment->save();
        return $text;
    }
    use HasFactory;
}
