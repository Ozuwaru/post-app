@extends('layout')
@section('title', 'Home')
@section('content')
<div class="content  mt-4 w-65 p3 jumbotron mx-auto" style="background-color: #fffcf2">
    <h3 class="title">¿Que esta pensando hoy?</h3>
    <form action="{{route('postCreate')}}" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="form-group row">
        <label for="text" class="col-sm-2 col-form-label">Mensaje</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="text" minlength="8" placeholder="Escriba cualquier cosa y compartala con sus amigos"required>
        </div>
      </div>


      <div class="form-group">
        <label for="img">Imagen: </label>
        <input type="file" class="form-control" name="img" id="img_path">
      </div>
      <div class="form-group">
        <label for="video">Video: </label>
        <input type="file" class="form-control" name="video" id="video_path">
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
          <button type="submit" class="btn b btn-lg btn-block"  style="background-color: #f07748">Enviar</button>
        </div>
      </div>
      
      
      
    </form>
</div>
@endsection

