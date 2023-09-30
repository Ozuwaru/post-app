<?php

namespace App\Http\Controllers;

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
         * 
         * luego tengo que sacar el id de la session y guardarlo.
         */
        $rules= [
            'text'=> 'string',
            'audio'=>['file',File::types('mp3')],
            'img'=>'file|image'
        ];

        $request->validate($rules);
        
        $filePath= ;
        dd($filePath);
        $post= new Post;
        $post->text = $request->text;
        $post->user_id= Auth::id();
        $post->videoPath= $this->storeUploads($request->file('video'));
        $post->imgPath= $this->storeUploads($request->file('img'));
        $post->save();
    }

    public function storeUploads(Request $request){
        if($request->file('img')){
            $filePath= $request->file('img')->store('images');
        }else{
            $filePath= $request->file('video')->store('videos');

        }
        return $filePath;
    }
}
