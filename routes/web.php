<?php

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

Route::get('/', function () {
    if(Auth::check()){

        return view('home');
    }
    return redirect('login');
})->name('home');

Route::controller(UserController::class)->group(function(){
    
});
Route::get('register',function (){
    return view('user/create');
})->name('register');


Route::post('save',[UserController::class,'save'])->name('save');

Route::get('login',function(){
    return view('user/login');
})->name('login');

Route::post('send',[UserController::class,'authenticate'])->name('send');
