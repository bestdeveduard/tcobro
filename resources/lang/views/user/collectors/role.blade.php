@extends('layouts.master')
@section('title')
Collectors
@endsection
@section('content')
<div class="card">
  <div class="card-body">

    <h4>Collector permits</h4>
    {!! Form::open(array('url' => 'user/collector/role/'.$id.'/update','class'=>'',"enctype" => "multipart/form-data")) !!}
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          
          <div class="form-group">
            <hr>
            <h4>{{trans_choice('general.manage',1)}} {{trans_choice('general.permission',2)}}</h4>
            <div class="col-md-6">
              <table class="table table-stripped table-hover">
                @foreach($data as $permission)
                <tr>
                  <td>
                    @if($permission->parent_id==0)
                    <strong>{{$permission->name}}</strong>
                    @else
                    __ {{$permission->name}}
                    @endif
                  </td>
                  <td>
                    @if(!empty($permission->description))
                    <i class="fa fa-info" data-toggle="tooltip"
                      data-original-title="{!!  $permission->description!!}"></i>
                    @endif
                  </td>
                  <td>
                    <input @if(array_key_exists($permission->slug, (array)$permi)) checked="" @endif type="checkbox" data-parent="{{$permission->parent_id}}"
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
        </div>
      </div>
    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
      <div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>

</div>


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