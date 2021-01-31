@extends('layouts.master')
@section('title')
Tcobro | Permisos
@endsection
@section('content')

    {!! Form::open(array('url' => 'user/collector/role/'.$id.'/update','class'=>'',"enctype" => "multipart/form-data")) !!}
<div class="card">
  <div class="card-body">
    <h4>Permisos de cobrador</h4> 
    <br>
    <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped table-condensed table-hover">
                @foreach($data as $permission)
                <tr>
                  <td>
                    @if($permission->parent_id==0)
                    <strong>{{$permission->name}}</strong>
                    @else
                    - {{$permission->name}}
                    @endif
                  </td>
                  <td style="display: none;">
                    @if(!empty($permission->description))
                    <i class="fa fa-info" data-toggle="tooltip"
                      data-original-title="{!!  $permission->description!!}"></i>
                    @endif
                  </td>
                  <td>
                    <input class="form-check-input" @if(array_key_exists($permission->slug, (array)$permi)) checked="" @endif type="checkbox" data-parent="{{$permission->parent_id}}"
                    name="permission[]" value="{{$permission->slug}}"
                    id="{{$permission->id}}"
                    class="styled pcheck">
                    <label class="" for="{{$permission->id}}">

                    </label>
                  </td>
                </tr>
                @endforeach
                
      </table>
    </div>
  </div>
  <br>
     <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Confirmar</button>
     <a style="width:115px;" class="btn btn-light" href="{{ url('user/collector/data') }}">Cancelar</a>    
</div>  
</div>

 
    <!-- /.panel-body -->
    {!! Form::close() !!}



<script>
$(document).ready(function() {
  $(".pcheck").on('click', function(e) {
    if ($(this).is(":checked")) {
      if ($(this).attr('data-parent') == 0) {
        var id = $(this).attr('id');
        $(":checkbox[data-parent=" + id + "]").attr('checked', 'checked');

      }
    } else {
      if ($(this).attr('data-parent') == 0) {
        var id = $(this).attr('id');
        $(":checkbox[data-parent=" + id + "]").removeAttr('checked');

      }
    }
    $.uniform.update();
  });
})
</script>
@endsection

@section('footer-scripts')

@endsection