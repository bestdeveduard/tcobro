@extends('layouts.master')
@section('title')
Tcobro Web | Prestamos
@endsection
@section('content')
  <p align="right"><a href="{{ url('loan/create') }}" type="button" class="btn btn-primary mr-2">Crear Prestamo</a></p>
<div class="card">
  <div class="card-body">
      <h4>Prestamos</h4>
    <div class="panel-heading">
      <h2 class="panel-title">

        @if(isset($_REQUEST['status']))
        @if($_REQUEST['status']=='pending')
        Pendiente de aprobacion
        @endif
        @if($_REQUEST['status']=='approved')
        Pendiente de desembolso
        @endif
        @if($_REQUEST['status']=='disbursed')
        {{trans_choice('general.loan',2)}} {{trans_choice('general.disbursed',1)}}
        @endif
        @if($_REQUEST['status']=='declined')
        {{trans_choice('general.loan',2)}} {{trans_choice('general.declined',1)}}
        @endif
        @if($_REQUEST['status']=='withdrawn')
        {{trans_choice('general.loan',2)}} {{trans_choice('general.withdrawn',1)}}
        @endif
        @if($_REQUEST['status']=='written_off')
        {{trans_choice('general.loan',2)}} {{trans_choice('general.written_off',1)}}
        @endif
        @if($_REQUEST['status']=='closed')
        {{trans_choice('general.loan',2)}} {{trans_choice('general.closed',1)}}
        @endif
        @if($_REQUEST['status']=='rescheduled')
        {{trans_choice('general.loan',2)}} {{trans_choice('general.rescheduled',1)}}
        @endif
        @else
        
        @endif
      </h2>
      <!---<div class="heading-elements">
        @if(Sentinel::hasAccess('loans.create'))
        <a href="{{ url('loan/create') }}" class="btn btn-info btn-sm">Crear Prestamo</a>
        @endif
      </div>--->
    </div>
    <div class="panel-body table-responsive">
      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Ruta</th>            
            <th>Capital prestado</th>
            <!---<th>Interes</th>
            <th>Mora</th>
            <th>Ajustes</th>--->
            <th>Balance</th>
            <th>No. Cuota</th>            
            <!---<th>Desembolsado</th>--->


            <th>Utilidad</th>
            <th>Estatus</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key)
          <tr>
            <td>{{$key->id}}</td>
            <td>
            @if(!empty($key->disbursed_date))
            {{$key->disbursed_date}}
              @else
              <label style="width: 100px;" class="badge badge-danger">No encontrada</label>
              @endif            
            </td>
            <td>
              @if(!empty($key->borrower))
              <a>{{$key->borrower->first_name}}
                {{$key->borrower->last_name}}</a>
              @else
              <span class="label label-danger">{{trans_choice('general.broken',1)}} <i
                  class="fa fa-exclamation-triangle"></i> </span>
              @endif
            </td>
            <td>
              @if(!empty($key->loan_product))
              {{$key->loan_product->name}}
              @else
              <label style="width: 100px;" class="badge badge-danger">No encontrada</label>
              @endif
            </td>            
            <td>
              @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
              ${{number_format($key->principal,2)}}
              @else
              ${{number_format($key->principal,2)}}
              @endif
            </td>
            <!---<td>
                INTERES 0
            </td>
            <td>
                MORA 0
            </td>
            <td>
                AJUSTES 0
            </td>--->
            <td>
            @if($key->status=='closed')
            $0.00
            @else
              ${{number_format(\App\Helpers\GeneralHelper::loan_total_balance($key->id),2)}}
            @endif  
             </td>      
             
            <td>
            @php
              $paid_count = 0;
              $paid_amount = 0;
              $unpaid_count = 0;
              $unpaid_amount = 0;

              $paid_rate = 0;
              $unpaid_rate = 0;

              $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $key->id)->sum('principal');
              $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
              $balancePrincipal = $totalPrincipal - $payPrincipal;

              $loan_schedules = \App\Models\LoanSchedule::where('loan_id', $key->id)->get();
              $payments = \App\Models\LoanTransaction::where('loan_id', $key->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');

              foreach ($loan_schedules as $schedule) {
                  $schedule_count = count($loan_schedules);
                  $principal = $balancePrincipal / $schedule_count;            
                  $loanRate = $key->interest_rate;

                  if ($key->repayment_cycle=='daily') {
                      $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                  } elseif ($key->repayment_cycle=='weekly') {
                      $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                  } elseif ($key->repayment_cycle=='bi_monthly') {
                      $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                  } elseif ($key->repayment_cycle=='monthly') {
                      $interest = ($balancePrincipal * $loanRate) / 100.00;        
                  } else {
                      $interest = 0;
                  }            
                                      
                  $due = $principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived;
                  $paid = 0;
                                                  
                  if ($payments > 0) {
                      if ($payments > $due) {
                          $paid = $due;
                          $payments = $payments - $due;                    
                      } else {
                          $paid = $payments;
                          $payments = 0;
                      }
                  } else {
                  }
                  $outstanding = $due - $paid;
                              
                  if ($outstanding == 0) {
                      $paid_amount = $paid_amount + $paid;
                      $paid_count = $paid_count + 1;                
                  }
                  if ($outstanding != 0) {
                      $unpaid_amount = $unpaid_amount + $outstanding;
                      $unpaid_count = $unpaid_count + 1;
                  }
                  $paid_rate = $paid_rate + $paid / $due;
                  $unpaid_rate = $unpaid_rate + $outstanding / $due;
              }
              @endphp
              {{number_format($paid_rate, 2, '.', "")}} de {{number_format($paid_count + $unpaid_count,2)}}
            </td>
            
            <!---<td>{{$key->release_date}}</td>--->


            <td>
            @php
              $total_principal = 0;
              $total_fees = 0;
              $total_interest = 0;
              $total_penalty = 0;
              $transaction_type = '';
              $transaction_date = '';
              foreach (\App\Models\LoanTransaction::where('transaction_type', 'repayment')->where('reversed', 0)->where('loan_id', $key->id)->where('branch_id', Sentinel::getUser()->business_id)->get() as $trans) {                  

                  $interest = \App\Models\JournalEntry::where('loan_transaction_id', $trans->id)->where('reversed',0)->where('name', "Interest Repayment")->sum('credit');

                  $fees = \App\Models\JournalEntry::where('loan_transaction_id', $trans->id)->where('reversed',0)->where('name', "Fees Repayment")->sum('credit');

                  $penalty = \App\Models\JournalEntry::where('loan_transaction_id', $trans->id)->where('reversed',0)->where('name', "Penalty Repayment")->sum('credit');

                  $total_principal = $total_principal + $principal;
                  $total_interest = $total_interest + $interest;
                  $total_fees = $total_fees + $fees;
                  $total_penalty = $total_penalty + $penalty;

                  $transaction_type = $key->transaction_type;            
              }
            @endphp
            ${{number_format($total_interest + $total_fees + $total_penalty, 2)}}
            </td>
            <td>
              @if($key->maturity_date<date("Y-m-d") && \App\Helpers\GeneralHelper::loan_total_balance($key->id)>0)
              <label style="width: 100px;  background-color:#b71c1c;" class="badge badge-danger">Vencido</label>
              @else
                @if($key->status=='pending')
                <span class="label label-warning">Pendiente de aprobacion</span>
                @endif
                @if($key->status=='approved')
                <span class="label label-warning">Pendiente de desembolso</span>
                @endif
                @if($key->status=='disbursed')
                <label style="width: 100px;" class="badge badge-success">Activo</label>
                @endif
                @if($key->status=='declined')
                <span class="label label-danger">Declinado</span>
                @endif
                @if($key->status=='withdrawn')
                <span class="label label-danger">{{trans_choice('general.withdrawn',1)}}</span>
                @endif
                @if($key->status=='written_off')
                <span class="label label-danger">Llevado a perdida</span>
                @endif
                @if($key->status=='closed')
                <label style="width: 100px;" class="badge badge-secondary">Cancelado</label>
                @endif
                @if($key->status=='pending_reschedule')
                <span class="label label-warning">{{trans_choice('general.pending',1)}}
                  {{trans_choice('general.reschedule',1)}}</span>
                @endif
                @if($key->status=='rescheduled')
                <span class="label label-info">{{trans_choice('general.rescheduled',1)}}</span>
                @endif
              @endif
            </td>
            <td>
        <a href="{{ url('loan/'.$key->id.'/repayment/create') }}">
            <button style="width:110px; height:28px; background-color:#22ae60; border-color:#22ae60;" type="button" class="btn btn-success btn-icon-text">
                Pagar
            </button>    
        </a>
        <a href="{{ url('loan/'.$key->id.'/show') }}">
            <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                Abrir
            </button>    
        </a>                
                
            </td>
            <!---<td>
              <ul class="icons-list">
                <li class="dropdown">
                  <a href="#" data-toggle="dropdown">
                    <img src="https://img.icons8.com/pastel-glyph/25/000000/plus.png" />
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    @if(Sentinel::hasAccess('loans.view'))
                    <li><a href="{{ url('loan/'.$key->id.'/show') }}"><i class="fa fa-search"></i>Abrir
                      </a>
                    </li>
                    @endif
                    @if(Sentinel::hasAccess('loans.create'))
                    <li><a href="{{ url('loan/'.$key->id.'/edit') }}"><i class="fa fa-edit"></i>Editar</a>
                    </li>
                    @endif
                    @if(Sentinel::hasAccess('loans.delete'))
                    <li><a href="{{ url('loan/'.$key->id.'/delete') }}" class="delete"><i
                          class="fa fa-trash"></i>Eliminar</a>
                    </li>
                    @endif
                  </ul>
                </li>
              </ul>
            </td>--->
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

<script>
$('#data-table').DataTable({
  "order": [
    [4, "desc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [7]
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
  }
});
</script>
@endsection