<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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



Route::post('delete',[PostController::class,'delete'])->name('delete');
Route::post('update',[PostController::class,'update'])->name('update');
Route::post('post/create',[PostController::class,'create'])->name('postCreate');
Route::get('/',[PostController::class,'load'])->name('home');



Route::post('saveComment',[CommentController::class,'saveComment'])->name('saveComment');