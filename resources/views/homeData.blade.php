@php

 $c=1;
@endphp
    @foreach ( $posts->all() as $post)
   
    <hr class="my-4">
        <div class=" post rounded pt-3 pb-3 mx-auto g-0  "style="background-color: #F0DFBC"">
          <div class="row container ">

            <div class="col-2">
              <img src="{{asset('storage/'.$post->userImg)}}" class="rounded img-fluid mb-3" alt="userImg" style="width: 300px; height: 70px; object-fit: cover; object-position: 50% 0;">
            </div>


            <div class="col-8">
              <a href="#" class="font-weight-bold">{{$post->userName}}</a>
              <p style="word-wrap:break-word;">{{$post->text}}</p>
            </div>


            <div class="col-2" >

              <!-- Button trigger modal -->
              @if ($user_id==$post->user_id)
                @include('dropdown',[
                  'containerClass'=>'box',
                  'deleteRoute'=>'postDelete',
                  'updateRoute'=>'postUpdate',
                  'row'=>$post,
                  'c'=>$c
                ])
              @endif

              
            </div>


          </div>
          @if ($post->imgPath)
              
            <div class="row mx-auto">

                <img src="{{asset('storage/'.$post->imgPath)}}" alt="userImg" class="rounded  d-block px-3 py-3 img-fluid" style="background-color: rgb(209, 194, 171)"  width="100%" >

              
            </div>  
          @endif


          <form action="{{route('commentCreate')}}" method="POST" enctype="multipart/form-data">

            <div class="form-group row pt-4 mx-auto">
              
              <div class="col-sm-2 ">

                {{-- //<img src="{{asset('storage/'.$post->imgPath)}}" class="rounded pt-1" alt="userImg" style="object-fit: cover;"> --}}
              {{-- <img src="{{asset('storage/'.$post->userImg)}}"  class="rounded img-fluid" alt="userImg" style="width: 3pz; height: 5pz; object-fit: cover; object-position: 50% 0;"> --}}


              </div>
              <div class="col-sm-12  py-auto mx-auto">

                  <input  type="hidden" value="{{$post->id}}" name="post_id">
                  <div class="form-group py-2">
                    <input type="text" class="form-control " name="comment" id="comment" placeholder="Write your comment">
                      @csrf
                    </div>
                  </div>

          </form>
          
          @php
                $iC=0;
            @endphp
            @foreach ($post->comments as $comment)
            
            <div class="container row py-3 mx-auto justify-content-center" >
              <div class="col-sm-2">
                <img src="{{asset('storage/'.$post->userImg)}}"   class="rounded img-fluid mb-3" alt="userImg" style="width: 100%; height: 70px; object-fit: cover; object-position: 50% 0;">

              </div>
              <div class="col-sm-10">
                <div class="col-sm-10">
                  <div class="form-group row ">
                    <div class="col-sm-11">

                      <a href="" class="font-weight-bold px-2">{{$comment->userN}} </a>
                      <span> - {{$comment->updated_at->format('d M Y')}}</span>
                    </div>
                    @if ($user_id==$comment->user_id)
                        
                    @include('dropdown',[
                      'containerClass'=>'col-sm-1',
                      'deleteRoute'=>'commentDelete',
                      'updateRoute'=>'commentUpdate',
                      'row'=>$comment,
                      'c'=>$iC
                    ])
                  </div>
                  @endif

    
                </div>
                <div class="col-sm-9">
                  <span class="text-justify" style="word-wrap:break-word;">{{$comment->text}}</span>

                </div>
              </div>
            </div>
            @php
                $iC++;
            @endphp
            @endforeach 

        </div>
      </div>
      @php
          
          $c++;
      @endphp

    @endforeach