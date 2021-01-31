@extends('layouts.master')
@section('title')
Tcobro Web | Base
@endsection
@section('content')
<p align="right"><a href="{{ url('baseuser/create') }}" type="button" class="btn btn-primary mr-2">Crear Base</a></p>
<div class="card">
  <div class="card-body">
    <h4>Base</h4>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th style="width:5px";><center>#       </center></th>
                <th><center>Fecha   </center></th>
                <th><center>Ruta    </center></th>
                <th><center>Cobrador</center></th>
                <th><center>Monto   </center></th>
                <th><center>Notas </center></th>
                <th><center>Estatus </center></th>
                <th style="width:12px";><center>Accion</th>
              </tr>
            </thead>
            <tbody>
              @php
              $key = 1;
              @endphp
              @foreach($bases as $base)
              <tr>
                <td><center>{{$key}}                            </center></td>
                <td><center>{{$base->create_at}}                </center></td>
                <td>{{$base->route_name}}                       </td>
                <td>{{$base->first_name}} {{$base->last_name}}  </td>
                <td>$ {{ number_format($base->amount,2) }}      </td>
                <td>{{$base->note}}                             </td>   
                <td>
                    <center>
                <?php    
                $ahora = date("Y-m-d");
                $base_a = $base->create_at;
                $calculo = $ahora > $base_a;
                ?>
                  @if($calculo == 1)
                      <button style="width:110px; height: 28px;" type="button" class="btn btn-warning">
                        Cerrada
                      </button> 
                  @else
                    <button style="width:110px; height: 28px; background-color:#00df95; border-color:#00df95;"  type="button" class="btn btn-success btn-icon-text">
                        Abierta
                    </button>
                  @endif                  
                    <center>
                </td>
             
                <td>
                  <a href="{{ url('baseuser/'.$base->id.'/edit') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Editar
                        </button>  
                      </a>
                      
                 <a id="deleteProductId" plan_id="{{$base->id}}">
                     <button style="width:110px; height: 28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-danger btn-icon-text">
                        Eliminar
                      </button>
                      </a>
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
        <h4 class="modal-title" id="deleteProductModalLabel">Eliminar base</h4>
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
        <button type="submit" class="btn btn-primary" id="deleteProduct">Eliminar</button>
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