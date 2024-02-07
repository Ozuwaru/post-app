@extends('layout')
@section('title', 'registration')
@section('content')
<div class="container">

<form action="{{route('save')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="title">
      <h4>

        Set your user data
      </h4>
    </div>

    <div class="form-group row">
      <div class="col-sm-6">
        <input type="text" class="form-control" name="name" placeholder="Name"required>
      </div>

      <div class="col-sm-6">
        <input type="text" class="form-control" name="lastName" placeholder="lastName"required>
      </div>
    </div>

    <div class="form-group row">
      <label for="email" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" placeholder="email"required>
      </div>
    </div>

    <div class="form-group row">
      <label for="img" class="col-sm-2 col-form-label">Profile img</label>
      <div class="col-sm-10">
        <input type="file" class="form-control" name="img" placeholder="img"required>
      </div>
    </div>

    <div class="form-group row">
      <label for="password" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="password" minlength="8" placeholder="Password"required>
      </div>
    </div>

    <div class="form-group row">
      <label for="password_confirmation" class="col-sm-2 col-form-label" >Verify Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="password_confirmation" minlength="8" placeholder="Verify Password" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="date" class="col-sm-2 col-form-label" >Date</label>
        
        <div class="col-sm-8">
          <input type="date" class="form-control" name="date" placeholder="Date"required>
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