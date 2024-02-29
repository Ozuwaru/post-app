<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        /**
         * Aqui vamos a concatenar querys para optimizar el codigo.
         * Hay que cambiar el algoritmo para que muestre tanto aquellos seguidos como a los que no por su nombre
         */


        $users=DB::table('users')->where('name','LIKE',"%{$name}%")->paginate(10);

        foreach($users as $user){
            if(
                DB::table('followers')
                ->where('followers.user_id',"{$id}")
                ->where('followers.following',"{$user->id}")->first()
            ){
                    $user->followed= true;
            }else{
                    $user->followed= false;

            }
        }
        //ESTE CODIGO SIRVE PARA OTRA FUNCION PARA BUSCAR CUENTAS A SEGUIR::


        // $users = $users->select('id','name','email','created_at','updated_at','birthDate','imgPath','followersCount')
        // ->whereNotExists(function (Builder $query) use ($id){
        //     $query->select(DB::raw(1))
        //     ->from('followers')
        //     ->where('followers.user_id',"{$id}")
        //     ->whereColumn('followers.following','users.id');
        // })->paginate(10);

            //dd($users);
        return $users;
    }

    public static function updateUser(Request $request){
        //dd($request->all());
        $credentials='';
        /**
         * 1 is for the username
         * 2 is for the email
         * 3 is for the password
         * 4 is for the img
         */
        $property='';
        $user= User::find($request->id);

        switch($request->option){

            case 1:{
                $credentials = ['name'=>'required|string|max:255'];
                $property='name';
                break;
            }
            case 2:{
                
                $credentials = ['email'=>'required|email|unique:users|max:255'];
                $property='email';

                break;
            }
            
            case 3:{
                
                $credentials = ['password'=>'required|confirmed|string|min:8'];
                $property='password';
                $finalD = Hash::make($request->{$property});
                break;
            }

            case 4:{

                $credentials = ['img'=>'required|mimes:jpeg,png'];
                $property='imgPath';

                
                break;
            }
        }

        if($request->option!=3){
            $finalD= $request->{$property};

        }
        $credentials = $request->validate($credentials);
        if($request->hasFile('img')){
            if( $user->imgPath!=null)
                Storage::disk('public')->delete($user->imgPath);
            $finalD= $request->file('img')->store('public/User/Images');
            
            $finalD = str_replace('public','',$finalD);
        }



        $user->{$property}= $finalD;
        
        $user->save();
        if($request->option==3){
            return 0;
        }

        if($request->option==4){
            $property='img';
            $finalD= asset('storage/'.$finalD);
        }
        $property = str_replace('Path','',$property);

        return response()->json([
                'property'=>$property,
                'value'=>$finalD,
                'id'=>$request->id.'-',
                'user'=>true]);
    }



}
