

<!-- Modal -->
<div class="modal fade" id="{{$buttonName}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$info}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body my-0 py-0">
        <form action="{{route($route)}}" method="POST" enctype="multipart/form-data" id="{{$buttonName}}-form" class="formUpdate">
          @csrf
          @method('patch')
          <div class="form-group ">
            <label for="data" class=" col-form-label">{{$label}}</label>
              <input type="{{$type}}" class="form-control mb-2" name="{{$columnName}}" 
              minlength="8" value="{{$value}}">
              
              @if ($option==3)
            <label for="{{$columnName}}" class=" col-form-label">{{$label2}}</label>

                <input type="{{$type}}" class="form-control" name="{{$columnName}}_confirmation" 
                minlength="8" value="{{$value}}">
                  
              @endif
              <input  type="hidden" value="{{$option}}" name="option">
              
              <input  type="hidden" value="{{$buttonName}}" name="idToChange">
              <input  type="hidden" value="{{$id}}" name="id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" class="close">Close</button>
            <button type="submit" class="btn btn-primary  dataSendForm"  id="{{$buttonName}}-submit">Save changes</button>
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div>