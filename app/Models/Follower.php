<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Follower extends Model
{

    protected $fillable = [
        'user_id',
        'following'
    ];

    public static function retrieveData(int $user_id,int $followed_id){

        
        return Follower::where('user_id',$user_id)->where('following',$followed_id)->first();
        
    }

    public $timestamps = false;

    use HasFactory;
}
