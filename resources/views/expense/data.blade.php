@extends('layouts.master')
@section('title')
Tcobro web | Gastos
@endsection
@section('content')
        @if(Sentinel::hasAccess('expenses.create'))
            <p align="right"><a href="{{ url('expense/create') }}" type="button" class="btn btn-primary mr-2">Crear Gasto</a></p>
        @endif
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Gastos</h2>
     </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th><center>Fecha</center></th>   
              <th><center>Gasto</center></th>              
              <th><center>Monto</center></th>              


              <th><center>Recurrente</center></th>
              <th><center>Descripcion</center></th>
              <!---<th><center>Archivos</center></th>--->
              <th style="width:12px";><center>Acciones</center></th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
            <td>
                <center>  
                  {{ $key->date }}
                </center>  
            </td>  
            <td>
            <center>
                @if(!empty($key->expense_type))
                {{$key->expense_type->name}}
                @endif
            </center>
            </td>            
            <td>
                <center>
                  ${{ number_format($key->amount,2) }}
                </center>   
            </td>            



            <td>
                <center>    
                @if($key->recurring==1)
                {{trans_choice('general.yes',1)}}
                @else
                {{trans_choice('general.no',1)}}
                @endif
                </center>              
            </td>
            <td>
                <center>
                {{ $key->notes }}
                </center>            
            </td>
              <!---<td>
                <ul class="">
                  @foreach(unserialize($key->files) as $k=>$value)
                  <li><a href="{!!asset('uploads/'.$value)!!}" target="_blank">{!! $value!!}</a></li>
                  @endforeach
                </ul>
              </td>--->
              <td>
                <a href="{{ url('expense/'.$key->id.'/edit') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Editar
                        </button> 
                </a>
                <a href="{{ url('expense/'.$key->id.'/delete') }}" class="delete">
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
$('#order-listing').DataTable({
  "order": [
    [2, "desc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [6]
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