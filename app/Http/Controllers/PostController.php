<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class PostController extends Controller
{
    public function create(Request $request){
        /**
         * ahora tengo que hacer que los datos del post, sean textos,
         * direcciones de audio y imagenes sean guardados en la base de datos
         * 
         * primero tengo que hacer que los archivos sean movidos a su carpeta y guardar la ruta
         * luego tengo que guardarlos junto con el texto en la base de datos.
         * -
         * luego tengo que sacar el id de la session y guardarlo.
         */
        //dd($request->file('img'));
        $rules= [
            'text'=> 'string',/*
            'audio'=>['file',File::types('mp3')],*/
            'img'=>'file|image'
        ];

        $request->validate($rules);

        Post::createPost($request);
        return redirect('');
    }

    public function update(Request $request){
        $request->validate(['text'=>'string']);
        Post::updateText($request);
        return redirect('');
        //dd($request);
    }
    
    public function delete(Request $request){
        Post::deleteWithId($request->id);
        return redirect('');

    }
    
    public function load(){
        if(Auth::check()){
            $posts= Post::getPosts(Auth::id());
            foreach($posts as $post){

                $comments = Comment::getCurrentPostComment(($post->id));
                //dd($comments);
                foreach($comments as $c){
                    //dd($c);
                    $post->addComments($c);
                }
                //dd($post);
            }
            //dd($posts);
            return view('home',['posts'=>$posts]);
        }
        return redirect('login');
        
    }

    
}
