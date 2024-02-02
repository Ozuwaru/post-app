@extends('layout')
@section('title', 'Home')
@section('content')

      {{-- 
        Cosas que quedan por realizar:
        2- Opcion para cambiarle nombre al usuario.
        3- Opcion para ver el perfil de cada usuario
        4-Funcionalidad de ver los post de tus amigos
        5 funcionalidad para buscar usuarios por el nombre de perfil
        6- escribir estructura de datos para plantear los amigos de cada usuario
        
        --}}
      <h3 class="title">What are you thinking today?</h3>
      <form action="{{route('postCreate')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group row">
          <label for="text" class="col-sm-2 col-form-label">Message: </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="text" minlength="8" placeholder="Share something with your friends!"required>
          </div>
        </div>
  
  
        <div class="form-group row">
          <label for="img" class="col-sm-2 col-form-label">Image: </label>
          <div class="col-sm-10">
            <input type="file" class="form-control"  name="img" id="img_path">

          </div>
        </div>
        <div class="form-group row">
          <label for="video" class="col-sm-2 col-form-label">Video: </label>
          <div class="col-sm-10">
            <input type="file" class="form-control" name="video" id="video_path">

          </div>
        </div>
        
  
  
          @if ($errors->any())
            <div class="alert alert-failure">
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
          
          @endif   
            <div class="form-group row">
              <div class="col-sm-12">
                <button type="submit" class="btn b btn-lg btn-block"  style="background-color: #f07748">Send</button>
              </div>
            </div>
      </form>
    </div>
@php
    

 $c=1;
@endphp
    @foreach ($posts as $post)
    <hr class="my-4">
        <div class=" post rounded pt-3 pb-3 mx-auto g-0  "style="background-color: #F0DFBC">
          <div class="row container ">

            <div class="col-2">
              <img src="{{asset('storage/'.$post->imgPath)}}" class="rounded img-fluid mb-3" alt="userImg" style="width: 300px; height: 70px; object-fit: cover; object-position: 50% 0;">
            </div>


            <div class="col-8">
              <a href="#" class="font-weight-bold">{{$post->userName}}</a>
              <p style="word-wrap:break-word;">{{$post->text}}</p>
            </div>


            <div class="col-2" >

<!-- Button trigger modal -->
@if ($user_id==$post->user_id)
    
<div class="box">

  <form action="{{route('delete')}}"  method="POST">
    @csrf
    @method('delete')
  
    <div class="form-inline">
      <input  type="hidden" value="{{$post->id}}" name="id">
      
    </div>
     
    <div class="form-inline">
      <button type="submit" class="btn btn-danger">Delete</button>
    </div>
  
  </form>
  
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$c}}">
    Edit
  </button>
</div>

<!-- Modal -->
<div class="modal fade" id="{{$c}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modify yout comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="update" method="POST">
          @csrf
          @method('patch')
          <div class="form-group row">
            <label for="text" class="col-sm-2 col-form-label"></label>
              <input type="text" class="form-control" name="text" minlength="8" value="{{$post->text}}">
              <input  type="hidden" value="{{$post->id}}" name="id">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div>
@endif

              
            </div>


          </div>
          
          <div class="row mx-auto">

              <img src="{{asset('storage/'.$post->imgPath)}}" alt="userImg" class="rounded  d-block px-3 py-3 img-fluid" style="background-color: rgb(209, 194, 171)"  width="100%" >

            
          </div>


          <form action="{{route('saveComment')}}" method="POST" enctype="multipart/form-data">

            <div class="form-group row pt-4 mx-auto">
              
              <div class="col-sm-2 ">

                {{-- //<img src="{{asset('storage/'.$post->imgPath)}}" class="rounded pt-1" alt="userImg" style="object-fit: cover;"> --}}
              <img src="{{asset('storage/'.$post->imgPath)}}" class="rounded img-fluid" alt="userImg" style="width: 3pz; height: 5pz; object-fit: cover; object-position: 50% 0;">


              </div>
              <div class="col-sm-10  py-auto mx-auto">

                <form action="{{route('saveComment')}}" method="POST">
                  <input  type="hidden" value="{{$post->id}}" name="post_id">
                  <div class="form-group py-2">
                    <input type="text" class="form-control " name="comment" id="comment" placeholder="Write your comment">
                      @csrf
                    </div>
                  </div>

                </form>
        </div>

 
            @foreach ($post->CommentArr as $comment)
            
            <div class="container row py-3 border-top border-danger  mx-auto" style="border-width-5">

              <div class="col-sm-1">
                {{-- AQUI VA LA IMAGEN DE CADA USUARIO --}}
                <img src="{{asset('storage/'.$post->imgPath)}}" class="rounded" alt="userImg" width="150%">

              </div>
              <div class="col-sm-11">
                <div class="col-sm-12">
                  <div class="form-group row ">
                    <div class="col-sm-8">

                      <a href="" class="font-weight-bold px-2">{{$comment->userN}} </a>
                      <span> - {{$comment->date}}</span>
                    </div>
                    <div class="col-sm-4">

                      {{-- <form action="{{route('delete')}}" class="pl-5"  method="POST">
                        <div class="form-inline">
                          <input  type="hidden" value="{{$post->id}}" name="id">
                        </div>
                        
                        <div class="form-inline">
                          <button type="submit" class="btn btn-danger">Borrar</button>
                        </div>
      
                        @csrf
                      </form> --}}
                    </div>
                  </div>
    
                </div>
                <div class="col-sm-12">
                  <span class="text-justify" style="word-wrap:break-word;">{{$comment->text}}</span>

                </div>
              </div>
            </div>
            @endforeach

      @php
          
          $c++;
      @endphp

    @endforeach
      



      
@endsection

