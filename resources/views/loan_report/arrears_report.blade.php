@extends('layouts.master')
@section('title')
Tcobros | Reporte de prestamos en atraso
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title">
        Reporte de prestamos en atraso
      </h3>

      <div class="heading-elements">
      </div>
    </div>
    <div class="panel-body hidden-print">
      <h4 class=""></h4>
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
    <div class="row">      

        <br><br>
        <div class="col-md-2" style="color:#22ae60;">          
         <h5>Final</h5>   
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>

        <div class="col-md-2" style="color:#22ae60;">          
         <h5>.</h5>   

            <div class="btn-group">
                <button type="button" style="border-color:#f0f0f0; width:180px;" class="btn dropdown-toggle legitRipple"
                data-toggle="dropdown">Descargar
                </button>
              <ul style="width:180px;" class="dropdown-menu dropdown-menu-right">
                <li>
                  <a href="{{url('report/loan_report/arrears_report/excel?end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-excel"></i> <span style="position: relative; top: -6px;">Excel</span>
                  </a>
                </li>
              </ul>
            </div> 
        </div>
       
     </div> 
<br>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Buscar</button>
          <a style="width:115px;" class="btn btn-light" href="{{Request::url()}}">Cancelar</a>  
          
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    <!-- /.panel-body -->
  </div>
</div>
<!-- /.box -->
<br>
  @if(!empty($end_date))
<div class="card">
  <div class="card-body">
    <div class="panel-body">
    <div class="table-responsive">
      <table id="order-listing" class="table table-striped table-condensed table-hover">
        <thead>
          <tr>
            <!---<th>Creado por</th>--->
            <th>#</th>            
            <th><center>Nombre</center></th>
            <th><center>Ruta</center></th> 
            <th><center>Estatus</center></th>      
            <th><center>Fecha</center></th>
            <!---<th>{{trans_choice('general.phone',1)}}</th>--->


            <th><center>Prestado</center></th>
            <!---<th>{{trans_choice('general.disbursed',1)}}</th>--->
            <th><center>Vencimiento</center></th>
            <!---<th>{{trans_choice('general.principal',1)}}</th>
            <th>{{trans_choice('general.interest',1)}}</th>
            <th>{{trans_choice('general.fee',2)}}</th>
            <th>{{trans_choice('general.penalty',1)}}</th>--->
            <th>Balance Total</th>            
            <th>Balance Atraso</th>

            <th><center>Dias atraso</center></th>
            <!---<th>{{trans_choice('general.day',2)}} {{trans_choice('general.in',2)}} {{trans_choice('general.arrears',2)}}
            </th>--->

          </tr>
        </thead>
        <tbody>
          <?php
                    $total_outstanding = 0;
                    $total_due = 0;
                    $total_principal = 0;
                    $total_interest = 0;
                    $total_fees = 0;
                    $total_penalty = 0;
                    $total_amount = 0;
                    ?>
          @foreach(\App\Models\Loan::where('first_payment_date','<=',$end_date)->where('branch_id',
          Sentinel::getUser()->business_id)->where('status', 'disbursed')->orderBy('release_date','asc')->get() as $key)
            <?php
                        $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($key->id,
                            $key->release_date, $end_date);
                        $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($key->id,
                            $key->release_date, $end_date);
                        $balance = \App\Helpers\GeneralHelper::loan_total_balance($key->id);
                        $due = ($loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"]) - ($loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"]);
                        $principal = $loan_due_items["principal"];
                        $interest = $loan_due_items["interest"];
                        $fees = $loan_due_items["fees"];
                        $penalty = $loan_due_items["penalty"];
                        if ($due > 0) {
                            $total_outstanding = $total_outstanding + $balance;
                            $total_due = $total_due + $due;
                            $total_principal = $total_principal + $principal;
                            $total_interest = $total_interest + $interest;
                            $total_fees = $total_fees + $fees;
                            $total_penalty = $total_penalty + $penalty;
                            $total_amount = $total_amount + $key->principal;
                            //lets find arrears information
                            $schedules = \App\Models\LoanSchedule::where('loan_id', $key->id)->where('due_date', '<=',
                                $end_date)->orderBy('due_date', 'asc')->get();
                            $payments = $loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"];
                            if ($payments > 0) {
                                foreach ($schedules as $schedule) {
                                    if ($payments > $schedule->principal + $schedule->interest + $schedule->penalty + $schedule->fees) {
                                        $payments = $payments - ($schedule->principal + $schedule->interest + $schedule->penalty + $schedule->fees);
                                    } else {
                                        $payments = 0;
                                        $overdue_date = $schedule->due_date;
                                        break;
                                    }
                                }
                            } else {
                                $overdue_date = $schedules->first()->due_date;
                            }
                            $date1 = new DateTime($overdue_date);
                            $date2 = new DateTime($end_date);
                            $days_arrears = $date2->diff($date1)->format("%a");
                            $transaction = \App\Models\LoanTransaction::where('loan_id',
                                $key->id)->where('transaction_type',
                                'repayment')->where('reversed', 0)->orderBy('date', 'desc')->first();
                            if (!empty($transaction)) {
                                $date2 = new DateTime($transaction->date);
                                $date1 = new DateTime($end_date);
                                $days_last_payment = $date2->diff($date1)->format("%r%a");
                            } else {
                                $days_last_payment = 0;
                            }
                        }
                        ?>
            @if($due >0)
            <tr>
              <td><center>
                  <a href="{{url('loan/'.$key->id.'/show')}}">{{$key->id}}</a>
              </center></td>                
              <!--<td>
                @if(!empty($key->loan_officer))
                <a href="{{url('user/'.$key->loan_officer_id.'/show')}}">{{$key->loan_officer->first_name}}
                  {{$key->loan_officer->last_name}}</a>
                @endif
              </td>--->
              <td><center>
                @if(!empty($key->borrower))
                <a href="{{url('borrower/'.$key->borrower_id.'/show')}}">{{$key->borrower->first_name}}
                  {{$key->borrower->last_name}}</a>
                @endif
              </center></td>
              <td><center>
                @if(!empty($key->loan_product))
                {{$key->loan_product->name}}
                @endif
              </center></td> 
            <td><center>
              @if($key->status=='pending')
              <span class="label label-warning">Pendiente de aprobacion}</span>
              @endif
              @if($key->status=='approved')
              <span class="label label-warning">Aprobado</span>
              @endif
              @if($key->status=='disbursed')
                      <button style="width:110px; height: 28px; background-color:#00df95; border-color:#00df95;"  type="button" class="btn btn-success btn-icon-text">
                        Activo
                      </button>   
              @endif
              @if($key->status=='declined')
              <span class="label label-danger">Declinado</span>
              @endif
              @if($key->status=='withdrawn')
              <span class="label label-danger">{{trans_choice('general.withdrawn',1)}}</span>
              @endif
              @if($key->status=='written_off')
              <span class="label label-danger">Castigado</span>
              @endif
              @if($key->status=='closed')
              <span class="label label-success">Cancelado</span>
              @endif
              @if($key->status=='pending_reschedule')
              <span class="label label-warning">{{trans_choice('general.pending',1)}}
                {{trans_choice('general.reschedule',1)}}</span>
              @endif
              @if($key->status=='rescheduled')
              <span class="label label-info">{{trans_choice('general.rescheduled',1)}}</span>
              @endif
            <center></td>              
            <td><center>
                <?php
                                $fecha_desembolso = $key->release_date;
                                $timestamp = strtotime($fecha_desembolso);
                                $date_desembolso = date("d-m-Y", $timestamp);
                ?>
              {{$date_desembolso}}
              </center></td>              
              
              <!---
              <td>
                @if(!empty($key->borrower))
                {{$key->borrower->mobile}}
                @endif
              </td>--->


              <td><center>${{number_format($key->principal,2)}}</center></td>
              <!---<td>{{$key->release_date}}</td>--->
              <td><center>
                <?php
                                $fecha_venc = $key->maturity_date;
                                $timestamp = strtotime($fecha_venc);
                                $fecha_venc = date("d-m-Y", $timestamp);
                ?>
                  {{$fecha_venc}}
            </center></td>
              <!---<td>{{number_format($principal,2)}}</td>
              <td>{{number_format($interest,2)}}</td>
              <td>{{number_format($fees,2)}}</td>
              <td>{{number_format($penalty,2)}}</td>--->
              <td>${{number_format($balance,2)}}</td>              
              <td><center>${{number_format($due,2)}}</center></td>

              <td><center>{{$days_arrears}}</center></td>
              <!---<td>{{$days_last_payment}}</td>--->
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
          <tr>
            <!---<th></th>--->
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>            
            <th><center>{{number_format($total_amount,2)}}</center></th>
            <th></th>

            <!---<th>{{number_format($total_principal,2)}}</th>
            <th>{{number_format($total_interest,2)}}</th>
            <th>{{number_format($total_fees,2)}}</th>
            <th>{{number_format($total_penalty,2)}}</th>--->
            <th>{{number_format($total_due,2)}}</th>            
            <th>{{number_format($total_outstanding,2)}}</th>

            <th></th>

          </tr>
        </tfoot>

      </table>
    </div>
  </div>
</div>  
</div>
  <script>
  $(document).ready(function() {
    $("body").addClass('sidebar-xs');
  });
  </script>
@endif
@endsection
@section('footer-scripts')
   
@endsection