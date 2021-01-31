@extends('layouts.master')
@section('title')
Tcobro web | Pagos
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Pagos</h4>

      <!---<div class="heading-elements">
        @if(Sentinel::hasAccess('borrowers.create'))
        <a href="{{ url('repayment/create') }}" class="btn btn-info btn-sm">Crear nuevo pago</a>
        @endif
      </div>--->
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th style="width:5px" ;>
                <center>
                  ID
                </center>
              </th>
              <th>
                <center>
                  Fecha
                </center>
              </th>
              <!---<th>
                {{trans_choice('general.loan',1)}}
              </th>--->
              <th>
                <center>
                  Prestamo
                </center>
              </th>

              <th>
                <center>
                  Usuario
                </center>
              </th>
              <th>
                <center>
                  Método
                </center>
              </th>
              <!---<th><center>
               Estatus
              </center></th>--->
              <th>
                <center>
                  Monto
                </center>
              </th>
              <th style="width:12px" ;>
                <center>
                  Acciones
                </center>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td>
                <center>{{$key->id}}</center>
              </td>
              <td>
                <center>{{$key->date}}</center>
              </td>
              <!---<td><a href="{{url('loan/'.$key->loan_id.'/show')}}"> {{$key->loan_id}}</a></td>--->
              <td>
                <center>
                  @if(!empty($key->borrower))
                  <!---<a href="{{url('borrower/'.$key->borrower_id.'/show')}}">--->
                  <a href="{{url('loan/'.$key->loan_id.'/show')}}">
                    {{$key->borrower->first_name}}
                    {{$key->borrower->last_name}}</a>
                  @else
                  <span class="label label-danger">{{trans_choice('general.broken',1)}} <i
                      class="fa fa-exclamation-triangle"></i> </span>
                  @endif
                </center>
              </td>

              <td>
                <center>
                  @if(!empty($key->user))
                  {{$key->user->first_name}} {{$key->user->last_name}}
                  @endif
                </center>
              </td>

              <td>
                <center>
                  @if(!empty($key->loan_repayment_method))
                  {{$key->loan_repayment_method->name}}
                  @endif
                </center>
              </td>
              <!---<td><center>
              
                    @if ($key->reversed == 0)
                      <button style="width:110px; height: 28px; background-color:#00df95; border-color:#00df95;"  type="button" class="btn btn-success btn-icon-text">
                        Procesado
                      </button>       
                    @elseif ($key->reversed == 1)
                      <button style="width:110px; height: 28px; background-color:" type="button" class="btn btn-warning">
                        Reversado
                      </button>                      
                    @else
                      <button style="width:110px; height: 28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-success btn-icon-text">
                        Reversado
                      </button>                      
                    @endif              
              
              
              </center></td>--->
              <td>
                <center>
                  ${{number_format($key->credit,2)}}
                </center>
              </td>

              <td>
                @if(Sentinel::hasAccess('repayments.delete'))
                <a href="{{url('loan/repayment/'.$key->id.'/edit')}}">
                  <button
                    style="width:110px; height:28px; color: white; background-color:#4c82c3; border-color:#4c82c3;"
                    type="button" class="btn btn-white btn-icon-text">
                    Editar
                  </button>
                </a>
                @endif
                @if($key->transaction_type=='repayment' && $key->reversible==1)
                <a href="{{url('loan/transaction/'.$key->id.'/print')}}" target="_blank">
                  <button
                    style="width:110px; height:28px; color: white; background-color:#008080; border-color:#008080;"
                    type="button" class="btn btn-white btn-icon-text">
                    Imprimir
                  </button>
                </a>
                @endif
                @if(Sentinel::hasAccess('repayments.delete'))
                <a href="{{url('loan/repayment/'.$key->id.'/reverse')}}" class="delete">
                  <button
                    style="width:110px; height:28px; color: white; background-color:#de3501; border-color:#de3501;"
                    type="button" class="btn btn-white btn-icon-text">
                    Eliminar
                  </button>
                </a>
                @endif
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
$('#repayments-data-table').DataTable({
  dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
  autoWidth: false,
  columnDefs: [{
    orderable: false,
    width: '100px',
    targets: [6]
  }],
  "order": [
    [1, "desc"]
  ],
  language: {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}:",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  },
});
</script>
@endsection