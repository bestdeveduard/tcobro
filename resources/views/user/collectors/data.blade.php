@extends('layouts.master')
@section('title')
Collectors
@endsection
@section('content')
<div class="card">
  <div class="card-body">

    @if(Session::has('flash_notification.message'))
    <script>
    toastr. {
      {
        Session::get('flash_notification.level')
      }
    }('{{ Session::get("flash_notification.message") }}', 'Response Status')
    </script>
    @endif
    @if (isset($msg))
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{ $msg }}
    </div>
    @endif
    @if (isset($error))
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{ $error }}
    </div>
    @endif
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="panel-heading">
      <h2 class="panel-title">Reports collector user</h2>

      <div class="heading-elements">
        <a href="{{ url('user/collector/create') }}" class="btn btn-info btn-xs">
          Add Collector
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Member ID</th>
                <th>Collector name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Condition</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
              $num = 1;
              @endphp

              @foreach($data as $key)
              <tr>
                <td>{{$num}}</td>
                <td>{{ $key->business_id }}</td>
                <td>{{ $key->first_name }} {{ $key->last_name }}</td>
                <td>{{ $key->email }}</td>
                <td>{{ $key->phone }}</td>
                <td>Secondary</td>
                <td>
                  <a href="{{url('user/collector/'.$key->id.'/role')}}"><img
                      src="https://img.icons8.com/dusk/64/000000/admin-settings-male.png" /></a>
                  <a href="{{url('user/collector/'.$key->id.'/edit')}}"><img
                      src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
                  <a id="deleteProductId" plan_id="{{ $key->id }}"><img
                      src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" /></a>
                </td>
              </tr>
              @php
              $num++;
              @endphp
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="deleteProductModalLabel">Delete Collector</h4>
      </div>
      {!! Form::open(array('url' =>url('user/collector/delete'), 'name'=>'deleteProduct', 'id'=>'deleteProduct',
      'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
      {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
      {!! Form::hidden('user_id', '', array('class'=>'form-control', 'id'=>'user_id')) !!}
      <div class="modal-body">
        <center>
          <h5>Are you sure to delete this collector?</h5>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="deleteProduct">Delete</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).on('click', '#deleteProductId', function() {
  var plan_id = $(this).attr('plan_id');
  $('#user_id').val(plan_id);
  $("#deleteproductmodal").modal('show');
});
</script>
@endsection

@section('footer-scripts')

@endsection