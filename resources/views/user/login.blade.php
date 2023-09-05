@extends('layout')
@section('title', 'registration')
@section('content')
  <h3 class="title mx-auto">Log in</h3>
  <form action="{{route('send')}}" method="POST">
      @csrf
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" name="email" placeholder="email"required>
        </div>
      </div>
      <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="password" minlength="8" placeholder="Password"required>
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
          <button type="submit" class="btn btn-success btn-lg btn-block" style="background-color: " class="btn btn-primary">Sign in</button>
        </div>
      </div>
      
      
      
    </form>
</div>

@endsection