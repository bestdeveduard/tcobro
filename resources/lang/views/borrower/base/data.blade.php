@extends('layouts.master')
@section('title')
T-Cobro Web | Base
@endsection
@section('content')
<p align="right"><a href="{{ url('baseuser/create') }}" type="button" class="btn btn-primary mr-2">Crear Base</a></p>
<div class="card">
  <div class="card-body">
    <h3>Base</h3>
    <br>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Ruta</th>
                <th>Cobrador</th>
                <th>Monto</th>
                <th>Estatus</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              @php
              $key = 1;
              @endphp
              @foreach($bases as $base)
              <tr>
                <td>{{$key}}</td>
                <td>{{$base->create_at}}</td>
                <td>{{$base->route_name}}</td>
                <td>{{$base->first_name}} {{$base->last_name}}</td>
                <td>$ {{ number_format($base->amount,2) }}</td>
                <td>
                <?php    
                $ahora = date("Y-m-d");
                $base_a = $base->create_at;
                $calculo = $ahora > $base_a;
                ?>
                  @if($calculo == 1)
                  <label style="width: 100px;" class="badge badge-secondary">Inactivo</label>
                  @else
                  <label style="width: 100px;" class="badge badge-success">Activo</label>
                  @endif                  
                </td>
                <td>
                  <a href="{{ url('baseuser/'.$base->id.'/edit') }}">
                      <img src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
                      
                 <!---<a id="deleteProductId" plan_id="{{$base->id}}">
                      <img src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" />
                      </a>--->
                </td>
              </tr>
              @php
              $key = $key + 1;
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
        <h4 class="modal-title" id="deleteProductModalLabel">Delete User</h4>
      </div>
      {!! Form::open(array('url' =>url('baseuser/delete'), 'name'=>'deleteProduct', 'id'=>'deleteProduct',
      'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
      {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
      {!! Form::hidden('plan_id', '', array('class'=>'form-control', 'id'=>'plan_id')) !!}
      <div class="modal-body">
        <center>
          <h5>Seguro que deseas eliminar este registro?</h5>
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
  $('#plan_id').val(plan_id);
  $("#deleteproductmodal").modal('show');
});
</script>
@endsection

@section('footer-scripts')

@endsection