<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->group(function(){
    Route::post('save','save')->name('save');
    
    Route::post('update','update')->name('update');
    Route::post('send','authenticate')->name('send');
    Route::get('logout','logout')->name('logout');
    
    Route::get('register',function (){
        return view('user/create');
    })->name('register');
    
    
    
    Route::get('login',function(){
        return view('user/login');
    })->name('login');

}); 

Route::group(['middleware'=>'auth'],function(){

    Route::get('search',[UserController::class,'search'])->name('search');
    Route::post('follow',[FollowerController::class,'follow'])->name('follow');
    
    
    
    Route::delete('delete',[PostController::class,'delete'])->name('delete');
    Route::patch('update',[PostController::class,'update'])->name('update');
    Route::post('post/create',[PostController::class,'create'])->name('postCreate');
    Route::get('/',[PostController::class,'load'])->name('home');
    
    
    Route::post('saveComment',[CommentController::class,'saveComment'])->name('saveComment');
});