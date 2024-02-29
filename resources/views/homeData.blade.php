
    @foreach ( $posts->all() as $post)


        <div class=" post" id="{{$post->id}}">
          <div class="row container justify-content-center" >

            <div class="col-2">
              <img src="{{asset('storage/'.$post->userImg)}}"class="rounded img-fluid mb-3  {{$post->user_id}}-userImg" alt="userImg" style="width: 300px; height: 70px; object-fit: cover; object-position: 50% 0;">
            </div>


            <div class="col-8">
              <a href="{{route('view',['id'=>$post->user_id])}}" class="font-weight-bold {{$post->user_id}}-userName">{{$post->userName}}</a>
              <span>  -  {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
              <p style="word-wrap:break-word;" id="{{$post->id}}-text">{{$post->text}}</p>
            </div>


            <div class="col-2" >

              @if (\Auth::id()==$post->user_id)
                @include('dropdown',[
                  'containerClass'=>'box',
                  'deleteRoute'=>'postDelete',
                  'updateRoute'=>'postUpdate',
                  'img'=>true,
                  'data'=>$post,
                  'row'=>$post,
                  'c'=>$post->id
                ])
              @endif

              
            </div>


            


          </div>
          @if ($post->imgPath)
              
            <div class="row mx-auto justify-content-center">

                <img  src="{{asset('storage/'.$post->imgPath)}}" alt="userImg" class="rounded  d-block px-3 py-3 img-fluid {{$post->id}}-postImg" style="background-color: rgb(209, 194, 171)"  width="80%" >

              
            </div>  
          @endif
          


          <form action="{{route('commentCreate')}}" method="POST" enctype="multipart/form-data">

            <div class="form-group row pt-4 mx-auto">
              <div class="col-sm-12  py-auto mx-auto">

                  <input  type="hidden" value="{{$post->id}}" name="post_id">
                  <div class="form-group py-2">
                    <input type="text" class="form-control "  minlength="8"  name="comment" placeholder="Write your comment">
                      @csrf
                    </div>
                  </div>

          </form>
          
            @foreach ($post->comments as $comment)
            
            <div class="container row py-3 mx-auto justify-content-center" id="{{$post->id}}-{{$comment->id}}">
              <div class="col-sm-2">
                <img src="{{asset('storage/'.$comment->userImg)}}"   class="rounded img-fluid mb-3" alt="userImg" style="width: 100%; height: 70px; object-fit: cover; object-position: 50% 0;">

              </div>
              <div class="col-sm-10">
                <div class="col-sm-10">
                  <div class="form-group row ">
                    <div class="col-sm-11">

                      <a href="{{route('view',['id'=>$comment->user_id])}}" class="font-weight-bold px-2 {{$comment->user_id}}-userName">{{$comment->userN}} </a>
                      <span> - {{$comment->updated_at->diffForHumans()}}</span>
                    </div>
                      @if (\Auth::id()==$comment->user_id)
                          
                        @include('dropdown',[
                          'containerClass'=>'col-sm-1',
                          'deleteRoute'=>'commentDelete',
                          'updateRoute'=>'commentUpdate',
                          'data'=>$comment,
                          'row'=>$comment,
                          'c'=>$post->id.'-'.$comment->id
                        ])
                      @endif

    
                  </div>
                  <div class="col-sm-9">
                    <p  id="{{$post->id}}-{{$comment->id}}-text"  class="text-justify" style="word-wrap:break-word;" >{{$comment->text}}</p>

                  </div>
                </div>
              </div>
            </div>
        
            @endforeach 

        </div>
    <hr class="my-4 mx-4">

    @endforeach
