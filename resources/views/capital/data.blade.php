@extends('layouts.master')
@section('title')
Tcobro web | Capital
@endsection
@section('content')
    @if(Sentinel::hasAccess('capital.create'))
    <p align="right"><a href="{{ url('capital/create') }}" type="button" class="btn btn-primary mr-2">Agregar Capital</a></p>
    @endif            
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Capital</h4>
    </div>
    <div class="panel-body ">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th><center>Fecha</th>                
              <th><center>Cuenta</th>
              <th><center>Monto</th>
              <th><center>Descripcion</th>
              <th><center>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td><center>{{ $key->date }}</center></td>                
              <td>
                <center>
                @if(!empty($key->debit_chart))
                {{$key->credit_chart->name}}
                @endif
                </center>    
              </td>
              <td><center>${{ number_format($key->amount,2) }}</center></td>
              <td><center>{{ $key->notes }}</center></td>
              <td style="width:12px";>
                <!---<a href="{{ url('capital/'.$key->id.'/edit') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Editar
                        </button>                 
                </a>--->
                <a href="{{ url('capital/'.$key->id.'/delete') }}" class="delete">
                     <button style="width:110px; height: 28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-danger btn-icon-text">
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
  "paging": true,
  "lengthChange": true,
  "displayLength": 15,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "order": [
    [2, "desc"]
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