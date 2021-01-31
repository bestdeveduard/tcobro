@extends('layouts.master')
@section('title')
Tcobro Web | Clientes
@endsection
@section('content')
<p align="right">
  <a href="{{ url('borrower/download_report') }}" type="button" class="btn btn-primary mr-2">Download Report</a>
  <a href="{{ url('borrower/download_excel') }}" type="button" class="btn btn-primary mr-2">Download Template</a>
  <a type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#upload_excel" style="color: white;">Upload Template</a>
  <a href="{{ url('borrower/create') }}" type="button" class="btn btn-primary mr-2">Crear cliente</a>
</p>

<div class="card">
  <div class="card-body">
    @if(Session::has('flash_notification.message'))
      <script>toastr.{{ Session::get('flash_notification.level') }}('{{ Session::get("flash_notification.message") }}', 'Success')</script>
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
      <h4>
          Clientes
      </h4>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th><center>ID</center></th>
                <th><center>Fecha</center></th>
                <th><center>Nombre</center></th>
                <th><center>Direccion</center></th>
                <th><center>Telefono</center></th>
                <th><center>Movil</center></th>
                <th><center>Valoracion</center></th>
                <th><center>Referencia</center></th>
                <th><center>Estatus</center></th>
                <th><center>Acciones</center></th>
                <!---<th>Acciones</th>--->
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key)

              <tr>
                <td><center>{{ $key->id }}</center></td>
                <td>                    
                  <?php
                  $creado_date_in = $key->created_at;
                  $timestamp = strtotime($creado_date_in);
                  $fecha_creacion_cliente2 = date("d-m-Y", $timestamp);
                  ?>
                  <center>{{ $fecha_creacion_cliente2 }}</center>
                </td>
                <td><center>{{ $key->first_name }} {{ $key->last_name }}</center></td>
                <td><center>{{ $key->address }}, {{ $key->country->name }}</center></td>
                <td><center>{{ $key->phone }}</center></td>
                <td><center>{{ $key->mobile }}</center></td>
                <td><center>100%</center></td>
                <td><center>{{ $key->referencia_1 }}</center></td>
                <td><center>
                  @if($key->active==0)
                <label style="width: 100px;" class="badge badge-danger">Lista negra</label>    
                
                  @elseif(count($key->loans)==0)
                <label style="width: 100px;" class="badge badge-secondary">Inactivo</label>
                
                  @elseif(count($key->loans) > 0)
                <label style="width: 100px;" class="badge badge-success">Activo</label>
                  @endif
                <center></td>
                
                <td>
                <center>    
                    <a href="{{ url('borrower/'.$key->id.'/show') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Abrir
                        </button>  
                    </a>
                    
                    <a href="{{ url('borrower/'.$key->id.'/edit') }}">
                        <button style="width:110px; height:28px; background-color:#22ae60; border-color:#22ae60;" type="button" class="btn btn-info btn-icon-text">
                            Editar
                        </button>   
                    </a>     
                    
                    <!---
                    <a href="{{ url('borrower/'.$key->id.'/delete') }}" class="delete">
                      <button style="width:110px; height: 28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-danger btn-icon-text">
                        Eliminar
                      </button>
                    </a>--->
                </center>    
                </td>     
                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.panel-body -->
</div>
<!-- /.box -->

<div class="modal fade" id="upload_excel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: -14px;">
          <span aria-hidden="true">X</span></button>
        <h4 class="modal-title">Upload Borrower Excel Data</h4>
      </div>
      {!! Form::open(array('url' => url('borrower/upload_excel'),'method'=>'post', 'name' => 'form', "enctype"=>"multipart/form-data")) !!}
      {{ csrf_field() }}
      <div class="modal-body">
        <div class="form-group">
          <div class="form-line">
            {!!  Form::label('excel_file',"Choose excel file",array('class'=>' control-label')) !!}
            {!! Form::file('file',array('class' => 'form-control file-styled', 'accept' => '.xlsx, .xls, .csv')) !!}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">{{trans_choice('general.save',1)}}</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
      </div>
      {!! Form::close() !!}
    </div>    
  </div>  
</div>

@endsection

@section('footer-scripts')
<script>
$('#data-table').DataTable({
  "order": [
    [0, "desc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [5]
  }],
  "language": {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  },
  responsive: false
});
</script>
@endsection