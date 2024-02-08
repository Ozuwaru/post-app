<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user= User::create([
            'name'=>"que pasaaaa",
            'email'=>'seeder@gmail.com',
            'password'=>Hash::make(123456789) ,
            'birthDate'=>'2003-01-01',
            'imgPath'=>"/User/Images/M4DV15EQewqXyCSEuIzUPg28X7eRnXEshGqSTdoJ.jpg"
        ]);
    }
}
