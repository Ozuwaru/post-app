<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->group(function(){
    Route::post('user/save','save')->name('save');
    
    Route::patch('user/update','update')->name('update');
    Route::delete('user/delete','delete')->name('delete');
    Route::post('user/send','authenticate')->name('send');
    Route::get('logout','logout')->name('logout');
    
    Route::get('register',function (){
        return view('user/create');
    })->name('register');
    
    
    
    Route::get('login',function(){
        return view('user/login');
    })->name('login');


    Route::get('user/{id}','view')->whereNumber('id')->name('view');
}); 

Route::group(['middleware'=>'auth'],function(){

    Route::get('search',[UserController::class,'search'])->name('search');
    Route::post('follow',[FollowerController::class,'follow'])->name('follow');
    
    
    Route::controller(PostController::class)->group(function(){

        Route::delete('post/delete','delete')->name('postDelete');
        Route::patch('post/update','update')->name('postUpdate');
        Route::post('post/create','create')->name('postCreate');
        Route::get('/','load')->name('home');
    });
    
    Route::controller(CommentController::class)->group(function(){
        Route::post('comment/create','commentCreate')->name('commentCreate');
        Route::patch('comment/update','commentUpdate')->name('commentUpdate');
        Route::delete('comment/delete','commentDelete')->name('commentDelete');

    });
});