@extends('layouts.master')
@section('title')
T-Cobro Web | Rutas
@endsection
@section('content')
<!---  <p align="right"><a href="{{ url('loan/loan_product/create') }}" type="button" class="btn btn-primary mr-2">Crear Ruta</a></p>     ---> 
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Reporte de Rutas</h4>
    </div>
    <div class="panel-body">
      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th style="width:5px";><center>ID</center></th>
            <th><center>Ruta</center></th>
            <th style="width:12px";><center>Accion</center></th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key)
          <tr>
            <td><center>{{ $key->id }}</center></td>
            <td><center>{{ $key->name }}</center></td>
            <td>
              <a href="{{ url('loan/loan_product/'.$key->id.'/edit') }}">
        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
            Editar
        </button>  
              </a>
              <a href="{{ url('loan/loan_product/'.$key->id.'/delete') }}">
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
    <!-- /.panel-body -->
  </div>
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')

@endsection