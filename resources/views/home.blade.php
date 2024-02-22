@extends('layout')
@section('title', 'Home')
@section('content')

      {{-- 
        Cosas que quedan por realizar:
        2- Opcion para cambiarle nombre al usuario.
        3- Opcion para ver el perfil de cada usuario
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
            <input type="file" class="form-control"  name="img" id="img_path"  >

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
  <div id="data-wrapper" class=" rounded pt-3 pb-3 mx-auto g-0 " style="background-color: #F0DFBC">
    @include('homeData')
  </div>
  <!-- Data Loader -->
  <div class="auto-load text-center" style="display: none;">
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
                    $('.auto-load').html("End of results.");
                    return;
                }
  
                $('.auto-load').hide();
                $("#data-wrapper").append(response.html);
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }


    
    
    /*
      Aqui escribiremos el resto del codigo que se encargará de 
      manejar los eventos de forma asincrona, sin recargar la pantalla
    */

      /*  
      this code allows us to edit the comments, the posts data is not updated,
      i don't really know the reason for that, i've tried to fix it, but is still not working
    */
       
    $(".updateForm").on('submit',function(e){
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
                var id= '#'+formData.get('number')+'-text';
                console.log(id)
                $(id).text(data.text);
                console.log($(id).get('id'));
            }
            
        })
        return false;
    });
    
</script>
@endsection

