@extends('layouts.master')
@section('title')CrediData | Reporte de Rutas
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">Reporte de Rutas</h2>

      <div class="heading-elements">
        <a href="{{ url('loan/loan_product/create') }}" class="btn btn-info btn-sm">Agregar ruta</a>
      </div>
    </div>
    <div class="panel-body">
      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Ruta</th>
            <th>Accion</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key)
          <tr>
            <td>{{ $key->id }}</td>
            <td>{{ $key->name }}</td>
            <td>
              <a href="{{ url('loan/loan_product/'.$key->id.'/edit') }}"><img
                  src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
              <a href="{{ url('loan/loan_product/'.$key->id.'/delete') }}"><img
                  src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" /></a>

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