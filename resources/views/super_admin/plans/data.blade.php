@extends('layouts.master')
@section('title')
    {{ trans_choice('general.user',2) }}
@endsection
@section('content')

  <p align="right"><a href="{{ url('super_admin/createplan') }}" type="button" class="btn btn-primary mr-2">Crear plan</a></p>          
  <div class="card">
    <div class="card-body">
      <h2>Plan member</h2>
      <br>
      <br>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Plan name</th>
                    <th>Duration</th>
                    <th>Amount</th>
                    <th>Quantity User</th>
                    <th>Quantity Route</th>                      
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $num = 1;
                @endphp
                @foreach($plans as $key)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $key->name }}</td>
                    <td>{{ $key->duration }}</td>
                    <td>${{ number_format($key->amount,2) }}</td>
                    <td>{{ $key->delimited_user }}</td>
                    <td>{{ $key->delimited_route }}</td>
                    <td>
                    <a href="{{ url('super_admin/'.$key->id.'/editplan') }}"><button class="btn btn-outline-primary">Editar</button></a> 
                    <a id="deleteProductId" plan_id="{{ $key->id }}"><button class="btn btn-outline-danger">Eliminar</button></a>                            
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="deleteProductModalLabel">Delete Plan</h4>
        </div>
        {!! Form::open(array('url' =>url('super_admin/deleteplan'), 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
          {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
          {!! Form::hidden('plan_id',  '', array('class'=>'form-control', 'id'=>'plan_id')) !!}
          <div class="modal-body">
            <center><h5>Are you sure to delete this plan?</h5></center>              
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
    $(document).on('click', '#deleteProductId', function(){
      var plan_id = $(this).attr('plan_id');
      $('#plan_id').val(plan_id);
      $("#deleteproductmodal").modal('show');
    });
  </script>
@endsection

@section('footer-scripts')  
@endsection
