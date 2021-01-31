@extends('layouts.master')
@section('title')
T-Cobro Web|Catalogo de cuentas
@endsection
@section('content')
  <p align="right"><a href="{{ url('chart_of_account/create') }}" type="button" class="btn btn-primary mr-2">Crear Cuenta</a></p>  
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Catalogo de cuentas</h4>

      <div class="heading-elements">
        @if(Sentinel::hasAccess('capital.create'))

        @endif
      </div>
    </div>
    <div class="panel-body ">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th style="width:5px";><center>Codigo</center></th>
              <th><center>Nombre</center></th>
              <th><center>Descripcion</center></th>
              <th><center>Tipo</center></th>              
              <th style="width:15px";><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td><center>{{ $key->gl_code }}</center></td>
              <td><center>{{ $key->name }}</center></td>
              <td><center>{!! $key->notes !!}</center></td>              
              <td><center>
                @if($key->account_type=="expense")
                {{trans_choice('general.expense',1)}}
                @endif
                @if($key->account_type=="asset")
                {{trans_choice('general.asset',1)}}
                @endif
                @if($key->account_type=="equity")
                {{trans_choice('general.equity',1)}}
                @endif
                @if($key->account_type=="liability")
                {{trans_choice('general.liability',1)}}
                @endif
                @if($key->account_type=="income")
                {{trans_choice('general.income',1)}}
                @endif
              </center></td>
              <td>
                <a href="{{ url('chart_of_account/'.$key->id.'/edit') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Editar </button>               
                </a>
                <a href="{{ url('chart_of_account/'.$key->id.'/delete') }}">
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
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')
<script>
$('#data-table').DataTable({
  "order": [
    [0, "asc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [4]
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