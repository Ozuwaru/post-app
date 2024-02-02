<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>@yield('title')</title>
</head>
<body style="background-color: #ccc5b9">

    <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #403d39;">
        <a class="navbar-brand p-0 b-0 " href="#">
            <span class="material-symbols-outlined">
                gite
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse " id="navbarSupportedContent">

            <form action="{{route('search')}}" method="GET" class="form-inline my-2 my-lg-0">
              @csrf
              <input type="text" class="form-control mr-sm-2"  name="search" placeholder="Search" >
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>


          <ul class="navbar-nav ml-auto">
            
            <li class="nav-item active">
              <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            
            
            @if (Auth::check())
            
            <li class="nav-item">
              <a class="nav-link" href="{{route('logout')}}">Logout</a>
            </li>
            @else
              <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Log in</a>
              </li>
                
            @endif
          </ul>
          
        </div>
      </nav>


    <div class="container">
      <div class="content  mt-4 p3 jumbotron mx-auto" style="background-color: #fffcf2; width: 750px">
        <div class="box">
        @yield('content')
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>