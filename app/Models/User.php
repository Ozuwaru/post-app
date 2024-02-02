<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthDate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function followers():HasMany{
        return $this->hasMany(Follower::class);
    }

    public static function  getUserToFollow(int $id, $name){
        // $followed = Follower::where('user_id',$id)->get()->pluck('following');
        // if($name!=null){
            
        //     $users = User::whereNotIn('id',$followed)->where('name','LIKE',"%{$name}%")->paginate(10);
        // }else{

        //     $users = User::whereNotIn('id',$followed)->paginate(10);
        // }

        // return $users;



        if($name!=null){

            $users = DB::table('users')
                ->where('name','LIKE',"%{$name}%")
                ->whereNotExists(function (Builder $query) use ($id){
                    $query->select(DB::raw(1))
                    ->from('followers')
                    ->where('followers.user_id',"{$id}")
                    ->whereColumn('followers.following','users.id');
                })->paginate(10);
        }else{

            $users = DB::table('users')
                ->whereNotExists(function (Builder $query) use ($id) {
                    $query->select(DB::raw(1))
                    ->from('followers')
                    ->where('followers.user_id',"{$id}")
                    ->whereColumn('followers.following','users.id');
                })->paginate(10);
        }
        
        return $users;
    }



}
