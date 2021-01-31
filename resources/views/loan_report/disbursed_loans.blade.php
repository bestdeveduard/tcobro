@extends('layouts.master')
@section('title')
Tcobro | Prestamos realizados
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title">
        Reporte de prestamos realizados<!---{{trans_choice('general.ledger',1)}}
        @if(!empty($start_date))
        for period: <b>{{$start_date}} to {{$end_date}}</b>
        @endif--->
      </h3>

      <div class="heading-elements">
      </div>
    </div>
    <div class="panel-body hidden-print">
      <h4 class=""></h4>
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
    <div class="row">      

        <div class="col-md-2" style="color:#22ae60;">          
         <h5>Inicial</h5>   
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>

        <br><br>
        <div class="col-md-2" style="color:#22ae60;">          
         <h5>Final</h5>   
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>

        <br><br>
        <div style="display: none;" class="col-md-4">
          {!! Form::label('loan_product_id',trans_choice('general.product',1),array('class'=>'')) !!}
          {!! Form::select('loan_product_id',$loan_products,$loan_product_id, array('class' => 'form-control
          select2','required'=>'required')) !!}
        </div>

        <div class="col-md-2" style="color:#22ae60;">          
         <h5>.</h5>   

            <div class="btn-group">
                <button type="button" style="border-color:#f0f0f0; width:180px;" class="btn dropdown-toggle legitRipple"
                data-toggle="dropdown">Descargar
                </button>
              <ul style="width:180px;" class="dropdown-menu dropdown-menu-right">
                <li>
                  <a href="{{url('report/loan_report/disbursed_loans/excel?start_date='.$start_date.'&end_date='.$end_date.'&loan_product_id='.$loan_product_id)}}"
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
@if(!empty($start_date))
<div class="card">
  <div class="card-body">
    <div class="panel-body">
    <div class="table-responsive">
      <table id="order-listing" class="table table-striped table-condensed table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>{{trans_choice('general.borrower',1)}}</th>
            <th>Ruta</th>
            <th>Estatus</th>
            <th>Fecha</th>
            <!---<th>Vencimiento</th>--->
            <th>Capital</th>
            <th>Interes</th>
                        <th>Penalidad</th>
            <th>Ajuste</th>
            <th>Total</th>
            <th>Pagado</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
          <?php
                    $total_outstanding = 0;
                    $total_due = 0;
                    $total_payments = 0;
                    $total_principal = 0;
                    $total_interest = 0;
                    $total_fees = 0;
                    $total_penalty = 0;
                    $total_amount = 0;

          ?>
          @foreach($data as $key)
          <?php
                        $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($key->id);
                        $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($key->id);
                        $due = $loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"];
                        $payments = $loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"];
                        $balance = $due - $payments;
                        $principal = $loan_due_items["principal"];
                        $interest = $loan_due_items["interest"];
                        $fees = $loan_due_items["fees"];
                        $penalty = $loan_due_items["penalty"];

                        $total_outstanding = $total_outstanding + $balance;
                        $total_due = $total_due + $due;
                        $total_principal = $total_principal + $principal;
                        $total_interest = $total_interest + $interest;
                        $total_fees = $total_fees + $fees;
                        $total_penalty = $total_penalty + $penalty;
                        $total_payments = $total_payments + $payments;
          ?>
<tr>
            <td><a href="{{url('loan/'.$key->id.'/show')}}">{{$key->id}}</a></td>
            <td>
              @if(!empty($key->borrower))
              <a href="{{url('borrower/'.$key->borrower_id.'/show')}}">{{$key->borrower->first_name}}
                {{$key->borrower->last_name}}</a>
              @endif
            </td>
            <td>
              @if(!empty($key->loan_product))
              {{$key->loan_product->name}}
              @endif
            </td>
            <td>
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
            </td>
            <td>
              <?php
                                $fecha_desembolso = $key->release_date;
                                $timestamp = strtotime($fecha_desembolso);
                                $date_desembolso = date("d-m-Y", $timestamp);
                            ?>
              {{$date_desembolso}}</td>
            <!---<td>
              <?php
                                $fecha_vencimiento = $key->maturity_date;
                                $timestamp = strtotime($fecha_vencimiento);
                                $date_vencimiento = date("d-m-Y", $timestamp);
                            ?>
              {{$date_vencimiento}}
            </td>--->
            
            <td>{{number_format($principal,2)}}</td>
            <td>{{number_format($interest,2)}}</td>
            <td>{{number_format($penalty,2)}}</td>            
            <td>{{number_format($fees,2)}}</td>
            <td>{{number_format($due,2)}}</td>
            <td>{{number_format($payments,2)}}</td>
            <td>{{number_format($balance,2)}}</td>
          </tr>
          @endforeach

        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>{{number_format($total_principal,2)}}</th>
            <th>{{number_format($total_interest,2)}}</th>
            <th>{{number_format($total_penalty,2)}}</th>            
            <th>{{number_format($total_fees,2)}}</th>

            <th>{{number_format($total_due,2)}}</th>
            <th>{{number_format($total_payments,2)}}</th>
            <th>{{number_format($total_outstanding,2)}}</th>

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