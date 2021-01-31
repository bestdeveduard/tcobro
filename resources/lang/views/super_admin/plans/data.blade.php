@extends('layouts.master')
@section('title')
T-Cobro Web| Planes de pago
@endsection


@section('content')

  <p align="right"><a href="{{ url('super_admin/createplan') }}" type="button" class="btn btn-primary mr-2">Crear plan</a></p>          
  <div class="card">
    <div class="card-body">
      <h4>Planes de pago</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                    <th style="width:5px";><center>#</center></th>
                    <th><center>Nombre</center></th>
                    <th><center>Duracion (Dias)</center></th>
                    <th><center>Precio</center></th>
                    <th><center>Cant. Usuarios</center></th>
                    <th><center>Cant. rutas</center></th>                      
                    <th style="width:12px";><center>Acciones</center></th>
                </tr>
              </thead>
              <tbody>
                @php
                  $num = 1;
                @endphp
                @foreach($plans as $key)
                <tr>
                    <td><center>{{ $num }}</center></td>
                    <td><center>{{ $key->name }}</center></td>
                    <td><center>{{ $key->duration }}</center></td>
                    <td><center>${{ number_format($key->amount,2) }}</center></td>
                    <td><center>{{ $key->delimited_user }}</center></td>
                    <td><center>{{ $key->delimited_route }}</center></td>
                    <td>
                    <a href="{{ url('super_admin/'.$key->id.'/editplan') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Editar </button>                        
                    </a> 
                    
                    <a id="deleteProductId" plan_id="{{ $key->id }}">
                      <button style="width:110px; height:28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-danger btn-icon-text">
                          Eliminar
                        </button>
                    </a> 
                    
                    
                    <!---background-color:yellow; border-color:yellow;--->
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
          <h4 class="modal-title" id="deleteProductModalLabel">Eliminar plan</h4>
        </div>
        {!! Form::open(array('url' =>url('super_admin/deleteplan'), 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
          {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
          {!! Form::hidden('plan_id',  '', array('class'=>'form-control', 'id'=>'plan_id')) !!}
          <div class="modal-body">
            <center><h5>Seguro que deseas eliminar este plan?</h5></center>              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="deleteProduct">Procesar</button>
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
