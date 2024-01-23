<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            'name'=>"que pasaaaa",
            'email'=>'seeder@gmail.com',
            'password'=>Hash::make(123456789) ,
            'birthDate'=>'2003-01-01',
        ]);
    }
}
