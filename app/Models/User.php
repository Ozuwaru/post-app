<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Http\Request;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

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
        'birthDate',
        'imgPath'
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

    public static function createUser(Request $request){

        $path= null;
        if($request->hasFile('img')){
            $path= $request->file('img')->store('public/User/Images');
            
            $path = str_replace('public','',$path);
            
        }
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'birthDate'=>$request->date,
            'imgPath'=>$path
        ]);
    }


    public function followers():HasMany{
        return $this->hasMany(Follower::class);
    }

    public static function  getUserToFollow(int $id, $name){


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
