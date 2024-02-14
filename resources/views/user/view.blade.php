@extends('layout')
@section('title', 'Home')
@section('content')
    <div>

        <div class="row">

            <div class="col-sm-2">
                <img src="{{asset('storage/'.$user->imgPath)}}" class="rounded img-fluid mb-3" id="imgInfo" alt="userImg" style="width: 300px; height: 70px; object-fit: cover; object-position: 50% 0;">

            </div>
            

            <div class="col-sm-8">

                <h3 class="title " id="nameInfo">{{$user->name}}</h3>
                <p id="emailInfo">{{$user->email}}</p>
                @if ($errors->any())
                    <div class="alert alert-failure">
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </div>
                    
                @endif   
            </div>
            <div class="col-sm-2">
                
                @if (\Auth::id()==$user->id)
                
                    

                    <div class="box">

                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" 
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ...
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        
                                <form action="{{route('delete')}}"  method="post" id="form{{$user->id}}">
                                @csrf
                                @method('delete')
                                
                                <div class="form-inline">
                                    <input  type="hidden" value="{{$user->id}}" name="id">
                                    
                                </div>
                                
                                
                                <button type="submit" class="dropdown-item" data-toggle="modal" data-target="#{{$user->id}}">
                                    Delete
                                </button>
                                </form>
                        
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#updateName">
                                    Edit Name
                                </button>

                                <button type="button" class="dropdown-item" data-toggle="modal" 
                                data-target="#updateEmail">
                                    Edit Email
                                </button>

                                <button type="button" class="dropdown-item" data-toggle="modal" 
                                data-target="#update_img">
                                    Edit Image
                                </button>

                                <button type="button" class="dropdown-item" data-toggle="modal" 
                                data-target="#updatePassword">
                                    Edit Password
                                </button>
                                
                            </div>
                        </div>
                    
                        
                        
                        
                    </div>
                    
                    @include('user.modal',[
                        'buttonName'=>'updateName',
                        'info'=>'Set your new Name',
                        'route'=>'update',
                        'value'=>$user->name,
                        'option'=>1,
                        'id'=>$user->id,
                        'type'=>'text',
                        'label'=>'Name:',
                        'columnName'=>'name'
                        
                        ])


                    @include('user.modal',[
                        'buttonName'=>'updateEmail',
                        'info'=>'Set your new Email',
                        'route'=>'update',
                        'value'=>$user->email,
                        'option'=>2,
                        'id'=>$user->id,
                        'type'=>'email',
                        'label'=>'Email:',
                        'columnName'=>'email'

                        
                        ])

                    


                    @include('user.modal',[
                        'buttonName'=>'updatePassword',
                        'info'=>'Set your new Password',
                        'route'=>'update',
                        'value'=>'',
                        'option'=>3,
                        'id'=>$user->id,
                        'type'=>'password',
                        'label'=>'Password:',
                        'label2'=>"Confirm Password",
                        'columnName'=>'password'


                        ])

                    @include('user.modal',[
                        'buttonName'=>'update_img',
                        'info'=>'Set your new Img',
                        'route'=>'update',
                        'value'=>$user->img,
                        'option'=>4,
                        'id'=>$user->id,
                        'type'=>'file',
                        'label'=>'Img:',
                        'columnName'=>'img'

                        
                        ])
                    
                @else
                <form  method="POST" name="followForm" action="{{ route('follow') }}" >
                    {{-- <form action="{{route('follow')}}"  method="POST"> --}}
              
              
                        <div class="form-inline">
                          <input type="number" value="{{$user->id}}" hidden name="id">
                          
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
                @endif
                <span>{{$user->followersCount}} Followers</span>

            </div>
        </div>




                              
            <div id="data-wrapper  " class=" rounded pt-3 pb-3 mx-auto g-0 " style="background-color: #F0DFBC">
                @include('homeData',['user_id'=>$user->id])
            </div>
                    <!-- Data Loader -->
        
            <div class="auto-load text-center mx-auto justify-content-center" style="display: none;">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                    <path fill="#000"
                        d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                        <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                        from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                    </path>
                </svg>
            </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    /*
        Aqui vamos a escribir el codigo ajax para 
        hacer las actualizaciones sin recargar pantalla
        primero necesitamos una funcion de evento que detenga los
        formulatios dentro de nuestro dropdown,
        luego vamos a imprimir esa informacion por pantalla
        una vez mandemos la info por pantalla, vamos a 
        mandarla a nuestra ruta de laravel
    */








    var ENDPOINT = "{{route('home')}}";
    var page = 1;
  
    /*------------------------------------------
    --------------------------------------------
    Call on Scroll
    --------------------------------------------
    --------------------------------------------*/
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 20)) {
            page++;
            infinteLoadMore(page);
        }
    });
  
    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMore(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response.html == '') {
                    $('.auto-load').html("We don't have more data to display :(");
                    return;
                }
  
                $('.auto-load').hide();
                $("#data-wrapper").append(response.html);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }


    
    $(".formUpdate").on('submit',function(e){
        e.preventDefault();
        var formData=   new FormData(this);

        $.ajax({

            url:$(this).attr('action'),
            type:"post",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function (data,textStatus,xhr){
                //console.log(data)
                var element = $('#'+data.data.property+'Info');
                if(data.data.property!='img'){
                    
                    element.text(data.data.value);
                }else{
                    element.attr('src',data.data.value);
                }
                var closeBtn= $(this).closest('.close');
                closeBtn.click();
            }
            
        })
        return false;
    });
        
    $(document).on('click',".follow_form",function(e){
        
        e.preventDefault();
        var myForm = $(this).closest('form');
        // console.log(myForm);
        $.ajax({
            url:myForm.attr('action'),
            type:"post",
            data:myForm.serialize()
        
        })
        .done(function (data,textStatus,xhr){
            //Aqui debemos cambiar la clase y atributos del boton
            const btn = e.target;
            if(textStatus=='nocontent'){

                btn.classList.remove('btn-success');
                btn.classList.add('btn-warning');
                btn.innerHTML= "Follow";
            }else if(textStatus=='success'){
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-success');
                btn.innerHTML= "Followed";
            }
           
        })
        .fail(function (response){
            console.log(response);
        });
     })

       

    
</script>
@endsection

