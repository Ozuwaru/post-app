

<div class="{{$containerClass}}">

  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle dropdownMenuButton" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      ...
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

      <form action="{{route($deleteRoute)}}"  method="post" id="form{{$c}}-delete" class="deleteForm ">
        @csrf
        @method('delete')
      
        <div class="form-inline">
          <input  type="hidden" value="{{$row->id}}" name="id">
          
        </div>
         
      
        {{-- <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('form{{$c}}').submit(); return false;">Delete</a> --}}
        <button type="submit" class="dropdown-item" data-toggle="modal" >
          Delete
        </button>
      </form>

      <button type="button" class="dropdown-item" data-toggle="modal" data-target="#{{$c}}-update">
        Edit
      </button>
      
      @isset($img)
        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#{{$c}}-updateImg">
          Edit Post Image
        </button>
      @endisset








    </div>
  </div>


  
  
</div>

<!-- Modal -->
{{-- <div class="modal fade" id="{{$c}}-update" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" class="ModalLabel">Update your data:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route($updateRoute)}}" method="POST" class="updateForm " >
          @csrf
          @method('patch')
          <div class="form-group row">
            <label for="text" class="col-sm-2 col-form-label"></label>
              <input type="text" class="form-control" name="text" minlength="8" value="{{$row->text}}">
              <input  type="hidden" value="{{$row->id}}" name="id">
              <input  type="hidden" value="{{$c}}" name="number">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div> --}}


@include('user.modal',
[
  'buttonName'=>"{$c}-update",
  'data'=>"{$c}-update",
  'info'=>'Set your new text',
  'route'=>$updateRoute,
  'value'=>$data->text,
  'option'=>1,
  'id'=>$data->id,
  'type'=>'text',
  'label'=>'New text:',
  'columnName'=>'text'
])

@isset($img)
    
  @include('user.modal',
  [
    'buttonName'=>"{$c}-updateImg",
    'data'=>"{$c}-updateImg",
    'info'=>'Set your new img',
    'route'=>$updateRoute,
    'value'=>$data->imgPath,
    'option'=>4,
    'id'=>$data->id,
    'type'=>'file',
    'label'=>'New img:',
    'columnName'=>'imgPath'
  ])
@endisset