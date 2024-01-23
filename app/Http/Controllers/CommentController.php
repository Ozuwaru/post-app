<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * para guardar los comentarios necesito crear un modelo para manejarlos, luego
     * necesito crear una instancia donde guardare el comentario y el id del post, luego
     * solo tengo que guardarlo en la tabla de comentarios
     * 
     * para cargar los comentarios necesito buscar un chunk de comentarios segun el id del post
     * luego mostrarlos al mismo tiempo que se muestra el post
     */
    public function saveComment(Request $request){
        //dd($request);
        Comment::createComment($request,Auth::id());
        return redirect()->intended('/');
        
    }
}
