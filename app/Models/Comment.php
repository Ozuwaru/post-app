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

    public function set(string $text,int $post_id, int $user_id)
    {
        $this->text = $text;
        $this->post_id= $post_id;
        $this->user_id= $user_id;
    }

    public static function createComment(Request $request, int $user_id){
        $c= new Comment;
        $c->set($request->comment,$request->post_id,$user_id);
        $c->save();

    }

    public static function getCurrentPostComment(int $Postid){
        $comments= Comment::select('user_id','text','updated_at')->where('post_id',$Postid)->get();
        return $comments;

    }
    use HasFactory;
}
