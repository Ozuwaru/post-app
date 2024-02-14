
@foreach ($users as $user)
<hr class="mt-1">
<div class="card-body row my-2 py-1"  >
    <div class="col-2">
        <img src="{{asset('storage/'.$user->imgPath)}}" class="rounded img-fluid mb-3" alt="userImg" 
        style="height:70px object-fit: cover; object-position: 50% 0;">
        
        
    </div>
        

    <div class="col-sm-8 row">
        <div class="col-sm-8">

            <h5 class="title ">
                <a href="{{route('view',['id'=>$user->id])}}" >{{$user->name}}</a>
    
                
            </h5>
            
            <p class="font-weight-light">created 
                {{\Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</p>
        </div>
        <div class="col-sm-4">
            <p><span class="followersCount">{{$user->followersCount}}</span> Followers</p>

        </div>
       
    </div>

    <div class="col-2">
        <form  method="POST" name="followForm" action="{{ route('follow') }}" >
        {{-- <form action="{{route('follow')}}"  method="POST"> --}}
  
  
            <div class="form-inline">
              <input type="hidden" value="{{$user->id}}"  name="id">
              
            </div>
             
            <div class="form-inline">
              <button type="submit" class="btn  follow_form 
              @if ($user->followed)
                btn-success
                @else
                btn-warning
              @endif" >
                @if ($user->followed)
                    followed
                @else
                    follow
                @endif
            </button>
            </div>
          
            @csrf
          </form>
        
    </div>
</div>

@endforeach