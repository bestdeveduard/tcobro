@extends('layouts.master')
@section('title')
Tcobro Web|Metodos de pago
@endsection


@section('content')
  <p align="right"><a href="{{ url('loan/loan_repayment_method/create') }}" type="button" class="btn btn-primary mr-2">Crear Metodo</a></p>   
<div class="card">
  <div class="card-body">
      <h4>Metodos de pago</h4>      
    <!---<div class="panel-heading">
      <h2 class="panel-title">Metodos de pago</h2>

      <div class="heading-elements">
        <a href="{{ url('loan/loan_repayment_method/create') }}"
          class="btn btn-info btn-sm">Agregar metodo</a>
      </div>
    </div>--->
    <div class="panel-body">
        <div class="table-responsive">
      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th><center>ID</center></th>
            <th><center>Nombre</center></th>
            <th><center>Clasificacion</center></th>
            <th><center>Acciones</center></th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key)
          <tr>
            <td style="width:5px";><center>{{ $key->id }}</center></td>
            <td><center>{{ $key->name }}</center></td>            
            <td><center>
                    @if ($key->type_order == 1)
                        Pagos en efectivo
                    @elseif ($key->type_order == 0)
                        Otros pagos
                    @else
                      ERROR                   
                    @endif            
            </center></td>
            <td style="width:15px";>
                
                
                
              <a href="{{ url('loan/loan_repayment_method/'.$key->id.'/edit') }}">
                <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                Editar
                </button>                    
              </a>
              <a href="{{ url('loan/loan_repayment_method/'.$key->id.'/delete') }}" class="delete">
                <button style="width:110px; height:28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-danger btn-icon-text">
                Eliminar
                </button>                  
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>      
    </div>
    <!-- /.panel-body -->
  </div>
  <!-- /.box -->
</div>

@endsection


@section('footer-scripts')

@endsection