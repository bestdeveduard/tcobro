@extends('layouts.master')
@section('title')
T-Cobro Web | Detalle de prestamo
@endsection
@section('content')
@if($loan->borrower->blacklisted==1)
<div class="row">
  <div class="col-sm-12">
    <div class="alert bg-danger">{{trans_choice('general.blacklist_notification',1)}}</div>
  </div>
</div>
@endif

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <div class="border-bottom text-center pb-4" style="background-color:#cddaff;">
              <br>
              <br>
              @if(!empty($borrower->photo))
              <img src="{{asset('uploads/'.$borrower->photo)}}" alt="profile" class="img-lg rounded-circle mb-3" />
              @else
              <img src="{{asset('uploads/usericon.png')}}" alt="profile"
                class="img-lg rounded-circle mb-3" />
              @endif
              
              <div class="mb-3">
                <h3>
                  @if(!empty($loan->borrower))
                  {{$loan->borrower->first_name}} {{$loan->borrower->last_name}}
                  @endif
                </h3>
              </div>
            </div>
            <div class="py-4">
              <p class="clearfix">
                <span class="float-left">
                  <strong>ID</strong>
                </span>
                <span class="float-right text-muted">
                  {{$loan->id}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Estatus</strong>
                </span>
                <span class="float-right text-muted">
                  @if($loan->maturity_date < date("Y-m-d") && \App\Helpers\GeneralHelper::loan_total_balance($loan->
                    id)>0)
                    {{trans_choice('general.past_maturity',1)}}
                    @else
                    @if($loan->status=='pending')
                    Pendiente aprobacion
                    @endif
                    @if($loan->status=='approved')
                    Esperando desembolso
                    @endif
                    @if($loan->status=='disbursed')
                    Activo
                    @endif
                    @if($loan->status=='declined')
                    Declinado
                    @endif
                    @if($loan->status=='withdrawn')
                    {{trans_choice('general.withdrawn',1)}}
                    @endif
                    @if($loan->status=='written_off')
                    LLevado a perdida
                    @endif
                    @if($loan->status=='closed')
                    Cancelado
                    @endif
                    @if($loan->status=='pending_reschedule')
                    {{trans_choice('general.pending',1)}} {{trans_choice('general.reschedule',1)}}
                    @endif
                    @if($loan->status=='rescheduled')
                    {{trans_choice('general.rescheduled',1)}}
                    @endif
                    @endif
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Ruta</strong>
                </span>
                <span class="float-right text-muted">
                  @if(!empty($loan->loan_product))
                  {{$loan->loan_product->name}}
                  @endif
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Creado por</strong>
                </span>
                <span class="float-right text-muted">
{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Interes</strong>
                </span>
                <span class="float-right text-muted">
                  @if($loan->interest_method=='declining_balance_equal_installments')
                  Interes Amortizable (Base Balance General)
                  @endif
                  @if($loan->interest_method=='declining_balance_equal_principal')
                  Interes Amortizable (Base Capital)
                  @endif
                  @if($loan->interest_method=='interest_only')
                  Interes unico
                  @endif
                  @if($loan->interest_method=='flat_rate')
                  Interes fijo
                  @endif
                  @if($loan->interest_method=='compound_interest')
                  {{trans_choice('general.compound_interest',1)}}
                  @endif
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Cuotas pagadas</strong>
                </span>
                <span class="float-right text-muted">


            <?php
              $paid_count = 0;
              $paid_amount = 0;
              $unpaid_count = 0;
              $unpaid_amount = 0;

              $paid_rate = 0;
              $unpaid_rate = 0;

              $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $loan->id)->sum('principal');
              $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
              $balancePrincipal = $totalPrincipal - $payPrincipal;

              $loan_schedules = \App\Models\LoanSchedule::where('loan_id', $loan->id)->get();
              $payments = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');

 
 
              foreach ($loan_schedules as $schedule) {
                  $schedule_count = count($loan_schedules);
                  $principal = $balancePrincipal / $schedule_count;            
                  $loanRate = $loan->interest_rate;

                  if ($loan->repayment_cycle=='daily') {
                      $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                  } elseif ($loan->repayment_cycle=='weekly') {
                      $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                  } elseif ($loan->repayment_cycle=='bi_monthly') {
                      $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                  } elseif ($loan->repayment_cycle=='monthly') {
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
              
              
              ?>
              {{number_format($paid_rate, 2, '.', "")}} de {{number_format($paid_count + $unpaid_count,2)}}
   
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Modalidad</strong>
                </span>
                <span class="float-right text-muted">
                  Mensual
                </span>
              </p>
            </div>
          </div>

          <div class="col-lg-9">
            <h4>Informacion del Préstamo</h4>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Fecha desembolso</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$loan->disbursed_date}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">

                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Capital prestado</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$ {{number_format($loan->approved_amount,2)}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Tasa de interes</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$loan->interest_rate}} %">
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Balance pendiente</strong></label>
                                        <?php
                                       $loan_total_nopaid_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                                        $loan_total_nopaid_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                                        $loan_total_nopaid_fee = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                                        $loan_total_nopaid_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                                        $loan_total_nopaid_total = $loan_total_nopaid_principal + $loan_total_nopaid_interest + $loan_total_nopaid_fee + $loan_total_nopaid_penalty;
 
                                        $loan_total_paid_principal = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->sum('credit');
                                        $loan_total_paid_interest = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Interest Repayment")->where('debit','=',NULL)->sum('credit');
                                        $loan_total_paid_charge = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Fees Repayment")->where('debit','=',NULL)->sum('credit');
                                        $loan_total_paid_penalty = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Penalty Repayment")->where('debit','=',NULL)->sum('credit');
                                        $total_paid_balance1 = $loan_total_paid_principal + $loan_total_paid_interest + $loan_total_paid_charge + $loan_total_paid_penalty;
                                     
                                    $id_total_pending_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                                    $id_total_pending_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                                    $id_total_pending_charge = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                                    $id_total_pending_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                                    
                                    $loan_total_pending_principal = $loan_total_nopaid_principal - $loan_total_paid_principal;
                                    $loan_total_pending_interest = $loan_total_nopaid_interest - $loan_total_paid_interest;
                                    $loan_total_pending_charge = $loan_total_nopaid_fee - $loan_total_paid_charge;
                                    $loan_total_pending_penalty = $loan_total_nopaid_penalty - $loan_total_paid_penalty;
                                    $loan_total_pending_total = abs($loan_total_pending_principal + $loan_total_pending_interest + $loan_total_pending_charge + $loan_total_pending_penalty);
                                        ?>                    
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$ {{number_format($loan_total_pending_total,2)}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Cuota</strong></label>
                                        <?php
                                       $loan_total_nopaid_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                                        $loan_total_nopaid_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                                        $loan_total_nopaid_fee = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                                        $loan_total_nopaid_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                                        $loan_total_nopaid_total = $loan_total_nopaid_principal + $loan_total_nopaid_interest + $loan_total_nopaid_fee + $loan_total_nopaid_penalty;
                                        $cantidad = \App\Models\LoanSchedule::where('loan_id',$loan->id)->count();
                                        $cuota = $loan_total_nopaid_total / $cantidad;
 ?>                    
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$ {{number_format($cuota,2)}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Ultimo pago</strong></label>
                                                    <?php
    $last_payment = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type',
                                                        'repayment')->where('reversed', 0)->orderBy('date',
                                                        'desc')->first();
                                                    ?>
                                                    @if(!empty($last_payment))
                                                        <h6><b>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$ {{number_format($last_payment->credit,2)}}">                                                       
                                                       </b></h6>
                                                    @else
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$ 0.00">
                                                    @endif                    

                      
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Balance en atraso</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$10,500.00">
                      
                      
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Balance pagado</strong></label>
                                        <?php
                                       $loan_total_nopaid_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                                        $loan_total_nopaid_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                                        $loan_total_nopaid_fee = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                                        $loan_total_nopaid_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                                        $loan_total_nopaid_total = $loan_total_nopaid_principal + $loan_total_nopaid_interest + $loan_total_nopaid_fee + $loan_total_nopaid_penalty;
 
                                        $loan_total_paid_principal = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->sum('credit');
                                        $loan_total_paid_interest = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Interest Repayment")->where('debit','=',NULL)->sum('credit');
                                        $loan_total_paid_charge = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Fees Repayment")->where('debit','=',NULL)->sum('credit');
                                        $loan_total_paid_penalty = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Penalty Repayment")->where('debit','=',NULL)->sum('credit');
                                        $total_paid_balance1 = $loan_total_paid_principal + $loan_total_paid_interest + $loan_total_paid_charge + $loan_total_paid_penalty;
                                     
                                    $id_total_pending_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                                    $id_total_pending_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                                    $id_total_pending_charge = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                                    $id_total_pending_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                                    
                                    $loan_total_pending_principal = $loan_total_nopaid_principal - $loan_total_paid_principal;
                                    $loan_total_pending_interest = $loan_total_nopaid_interest - $loan_total_paid_interest;
                                    $loan_total_pending_charge = $loan_total_nopaid_fee - $loan_total_paid_charge;
                                    $loan_total_pending_penalty = $loan_total_nopaid_penalty - $loan_total_paid_penalty;
                                    $loan_total_pending_total = abs($loan_total_pending_principal + $loan_total_pending_interest + $loan_total_pending_charge + $loan_total_pending_penalty);
                                        ?>                   
<!---                   
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$11,500.00">
--->

                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="$ {{number_format($total_paid_balance1,2)}}">                      
                  </div>
                </div>
              </div>
              

                                        
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Fecha de finalización</strong></label>
                                <?php
                                    $fecha_de_vencimiento_in = \App\Models\LoanSchedule::where('loan_id', $loan->id)->orderBy('due_date','asc')->get()->last()->due_date;
                                    $fecha_de_vencimiento_process = strtotime($fecha_de_vencimiento_in);
                                    $fecha_de_vencimiento_out = date("d-m-Y", $fecha_de_vencimiento_process);
                                ?>                      
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$fecha_de_vencimiento_out}}">
                  </div>
                </div>
              </div>




              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong></strong></label>
                    <a href="{{url('loan/'.$loan->id.'/repayment/create')}}"
                      style="background-color:green; color:white;" class="btn btn-white btn-block mb-2"><i
                        class="fas fa-dollar-sign"></i> Recibir
                      pago</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong></strong></label>
                    <div class="dropdown">
                      <button style="background-color:#4c82c3; color:white;"
                        class="btn btn-white btn-block mb-2 dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-edit"></i> Editar
                      </button>
                      <div class="dropdown-menu btn-block mb-2" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{url('loan/'.$loan->id.'/edit')}}">Editar prestamo</a>
                        <a class="delete dropdown-item" href="{{url('loan/'.$loan->id.'/delete')}}">Eliminar
                          prestamo</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong></strong></label>
                    <div class="dropdown">
                      <button style="background-color:#4c82c3; color:white;"
                        class="btn btn-white btn-block mb-2 dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mas opciones
                      </button>
                      <div class="dropdown-menu btn-block mb-2" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#writeoffLoan">Llevar a
                          perdida</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addCharge">Agregar
                          balance</a>
                        <button class="dropdown-item" id="observation">Observaciones</button>
                        <button class="dropdown-item" id="contrato">Contrato</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addCharge">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">*</span></button>
        <h4 class="modal-title">Agregar ajuste de saldo</h4>
      </div>
      {!! Form::open(array('url' => url('loan/'.$loan->id.'/add_charge'),'method'=>'post')) !!}
      <div class="modal-body">
        <?php
          $specified_charges = [];
          foreach (\App\Models\Charge::where('charge_type', 'specified_due_date')->where('active', 1)->get() as $key)
          {
            $specified_charges[$key->id] = $key->name;
          }
        ?>
        <div style="display: none;" class="form-group">
          {!! Form::label('charge',trans_choice('general.charge',1),array('class'=>' ')) !!}
          {!! Form::select('charge',$specified_charges,null,array('class'=>' select2')) !!}
        </div>
        <div class="form-group">
          {!! Form::label('date',trans_choice('general.date',1),array('class'=>' control-label')) !!}
          {!! Form::text('date',date("Y-m-d"),array('class'=>'form-control
          date-picker','required'=>'required')) !!}
        </div>
        <div class="form-group">
          {!! Form::label('amount',trans_choice('general.amount',1),array('class'=>' control-label')) !!}
          {!! Form::text('amount',null,array('class'=>'form-control
          touchspin',''=>'','required'=>'required')) !!}
        </div>
        <div class="form-group">
          {!! Form::label( 'notes',trans_choice("Motivo del ajuste",2),array('class'=>' control-label')) !!}          
          {!! Form::select('notes',array('Ajuste de Interes (+)'=>trans_choice("Ajuste de Interes
          (+)",1),'Ajuste de Mora (+)'=>trans_choice("Ajuste de Mora (+)",1)),null,array('class'=>'
          select2','required'=>'required')) !!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">{{trans_choice('general.save',1)}}</button>
        <button type="button" class="btn default" data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
      </div>
      {!! Form::close() !!}
    </div>    
  </div>  
</div>

<div class="modal fade" id="writeoffLoan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">*</span></button>
        <h4 class="modal-title">LLevar a perdida</h4>
      </div>
      {!! Form::open(array('url' => url('loan/'.$loan->id.'/write_off'),'method'=>'post')) !!}
      <div class="modal-body">
        <div class="form-group">
          <div class="form-line">
            {!! Form::label('Fecha de castigo',trans_choice('general.date',1),array('class'=>' control-label')) !!}
            {!! Form::text('written_off_date',date("Y-m-d"),array('class'=>'form-control
            date-picker','required'=>'required')) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="form-line">
            {!! Form::label( 'Comentarios',trans_choice('general.note',2),array('class'=>' control-label')) !!}
            {!!
            Form::textarea('written_off_notes','',array('class'=>'form-control','rows'=>'3','required'=>'required'))
            !!}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Procesar</button>
        <button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
      </div>
      {!! Form::close() !!}
    </div>    
  </div>
</div>

<br>


<div class="card" id="history_table">
  <div class="card-body">
    <h4><strong>Historial de pagos</strong></h4>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <tbody>
              <tr style="background-color: #92acf7; color: white;">
                <th style="width: 10px">
                  <b>#</b>
                </th>
                <th>
                  <b>Fecha</b>
                </th>
                <th style="text-align:right;">
                  <b>Recibido</b>
                </th>
                <th>
                  <b>Transaccion</b>
                </th>
                <th style="">
                  <b>Capital</b>
                </th>
                <th style="text-align:right;">
                  <b>Interes</b>
                </th>
                <th style="text-align:right;">
                  <b>Cargos</b>
                </th>
                <th style="text-align:right;">
                  <b>Mora</b>
                </th>

                <th style="text-align:right;">
                  <b>Total</b>
                </th>
                <th style="text-align:right;">
                  <b>Pagado</b>
                </th>
                <th style="text-align:right;">
                  <b>Pendiente</b>
                </th>
                <th style="text-align:right;">
                  <b>Balance</b>
                </th>
              </tr>
              <?php                
                $disbursement_charges = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type', 'disbursement_fee')->where('reversed', 0)->sum('debit');
                ?>
              <tr>
                <td></td>
                <td>                  
                  {{$loan->release_date}}
                </td>
                <td></td>
                <td>                  
                  {{trans_choice('general.disbursement',1)}}
                </td>
                <td></td>
                <td></td>
                <td style="text-align:right;">
                  @if(!empty($disbursement_charges))
                  <b>{{number_format($disbursement_charges,2)}}</b>
                  @endif
                </td>
                <td></td>
                <td style="text-align:right;">
                  @if(!empty($disbursement_charges))
                  <b>{{number_format($disbursement_charges,2)}}</b>
                  @endif
                </td>
                <td style="text-align:right;">
                  @if(!empty($disbursement_charges))
                  <b>{{number_format($disbursement_charges,2)}}</b>
                  @endif
                </td>
                <td>
                </td>

                <?php
                  $totalPrincipal = \App\Models\LoanSchedule::where('loan_id',
                  $loan->id)->sum('principal');
                  $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
                  $balancePrincipal = $totalPrincipal - $payPrincipal;
                ?>

                <td style="text-align:right;">
                  {{number_format($balancePrincipal,2)}}
                </td>
              </tr>
              <?php
                                           
                $timely = 0;
                $total_overdue = 0;
                $overdue_date = "";
                $total_till_now = 0;
                $count = 1;
                $total_due = 0;
                $principal_balance = $balancePrincipal;
                $payments = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');
                $total_paid = $payments;
                $next_payment = [];
                $next_payment_amount = "";
                $totalPrincipal = 0;
                $totalInterest = 0;
                $loans_type = $loan->repayment_cycle;
                
                foreach ($loan->schedules as $schedule) {
                  $schedule_count = count($loan->schedules);
                  $principal = $balancePrincipal / $schedule_count;
                  $cuotas = $loan->loan_duration;
                  $loanRate = $loan->interest_rate;

                  if ($loan->repayment_cycle=='daily') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                  } elseif ($loan->repayment_cycle=='weekly') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                  } elseif ($loan->repayment_cycle=='bi_monthly') {
                    $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                  } elseif ($loan->repayment_cycle=='monthly') {
                    $interest = ($balancePrincipal * $loanRate) / 100.00;        
                  } else {
                    $interest = 0;
                  }
                
                  $principal_balance = $principal_balance - $principal;
                  $totalPrincipal += $principal;
                  $totalInterest += $interest;
                                      
                  $due = $principal + $interest + $schedule->fees + $schedule->penalty- $schedule->interest_waived;
                  $total_due = $total_due + ($principal + $interest + $schedule->fees + $schedule->penalty - $schedule->interest_waived);                                              
                                      
                  $paid = 0;
                  $paid_by = '';
                  $overdue = 0;
                
                  if ($payments > 0) {
                    if ($payments > $due) {
                      $paid = $due;
                      $payments = $payments - $due;
                      
                      $p_paid = 0;
                      foreach (\App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type', 'repayment')->where('reversed', 0)->orderBy('date', 'asc')->get() as $key) {
                        $p_paid = $p_paid + $key->credit;
                        if ($p_paid >= $total_due) {
                          $paid_by = $key->date;
                          if ($key->date > $schedule->due_date && date("Y-m-d") > $schedule->due_date) {
                              $overdue = 1;
                              $total_overdue = $total_overdue + 1;
                              $overdue_date = '';
                          }
                          break;
                        }
                      }
                    } else {
                      $paid = $payments;
                      $payments = 0;
                      if (date("Y-m-d") > $schedule->due_date) {
                        $overdue = 1;
                        $total_overdue = $total_overdue + 1;
                        $overdue_date = $schedule->due_date;
                      }
                      $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty- $schedule->interest_waived) - $paid);
                    }
                  } else {
                    if (date("Y-m-d") > $schedule->due_date) {
                      $overdue = 1;
                      $total_overdue = $total_overdue + 1;
                      $overdue_date = $schedule->due_date;
                    }
                    $next_payment[$schedule->due_date] = (($schedule->principal + $schedule->interest + $schedule->fees + $schedule->penalty- $schedule->interest_waived));
                  }
                  $outstanding = $due - $paid;

                ?>
              <tr class="@if($overdue==1) bg-danger  @endif @if($overdue==0 && $outstanding==0) bg-success  @endif">
                <td>
                  {{$count}}
                </td>
                <td>
                  <?php                            
                    $fechas_de_pagos = $schedule->due_date;
                    $timestamp = strtotime($fechas_de_pagos);
                    $fechas_de_pagos_final = date("d-m-Y", $timestamp);
                  ?>
                  {{$fechas_de_pagos_final}} </td>

                <td style="">
                  @if(empty($paid_by) && $overdue==1)
                  En atraso
                  @endif
                  @if(!empty($paid_by) && $overdue==1)
                  <?php                            
                  $pago_tardio_in = $paid_by;
                  $timestamp = strtotime($pago_tardio_in);
                  $pago_tardio_out = date("d-m-Y", $timestamp);
                  ?>
                  {{$pago_tardio_out}}

                  @endif
                  @if(!empty($paid_by) && $overdue==0)
                  <?php                            
                  $pago_atiempo_in = $paid_by;
                  $timestamp = strtotime($pago_atiempo_in);
                  $pago_atiempo_out = date("d-m-Y", $timestamp);
                  ?>
                  {{$pago_atiempo_out}}

                  @endif

                </td>

                <td>
                  {{$schedule->description}}
                </td>
                <td style="text-align:right">
                  {{number_format($principal,2)}}
                </td>
                <td style="text-align:right">
                  @if($schedule->interest_waived>0)
                  <s> {{number_format($schedule->interest_waived,2)}}</s>
                  @endif
                  {{number_format($interest,2)}}
                </td>
                <td style="text-align:right">
                  {{number_format($schedule->fees,2)}}
                </td>
                <td style="text-align:right">                  
                  {{number_format($schedule->penalty,2)}}
                </td>
                <td style="text-align:right; font-weight:bold">
                  {{number_format($due,2)}}
                </td>

                <td style="text-align:right;">
                  {{number_format($paid,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format($outstanding,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format($principal_balance,2)}}
                </td>

              </tr>
              <?php
              $count++;
              }
              ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight:bold">{{trans_choice('general.total',1)}}
                  {{trans_choice('general.due',1)}}</td>
                <td style="text-align:right;">
                  {{number_format($totalPrincipal,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format($totalInterest,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format(\App\Helpers\GeneralHelper::loan_total_fees($loan->id)+$disbursement_charges,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format(\App\Helpers\GeneralHelper::loan_total_penalty($loan->id),2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format($total_due+$disbursement_charges,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format($total_paid+$disbursement_charges,2)}}
                </td>
                <td style="text-align:right;">
                  {{number_format(\App\Helpers\GeneralHelper::loan_total_balance($loan->id),2)}}
                </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>
</div>

<div class="card" style="display: none;" id="observation_table">
  <div class="card-body">
    <h4><strong>Observaciones</strong></h4>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="data-table" class="table">
            <thead>
              <tr style="background-color: #92acf7; color: white;">
                <th></th>
                <th>Usuario</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              @foreach($loan->comments as $comment)
              <tr>
                <td>
                </td>
                <td>
                  <i class="icon-user"></i>
                  @if(!empty(\App\Models\User::find($comment->user_id)))
                  {{\App\Models\User::find($comment->user_id)->first_name}}
                  {{\App\Models\User::find($comment->user_id)->last_name}}
                  @endif
                </td>
                <td>{!! $comment->notes !!}</td>
                <td><i class="icon-alarm"></i> {{$comment->created_at}}</td>
                <td>
                  <div class="btn-group-horizontal">
                    <a href="{{url('loan/'.$loan->id.'/loan_comment/'.$comment->id.'/edit')}}"><img
                        src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
                    <a href="{{url('loan/'.$loan->id.'/loan_comment/'.$comment->id.'/delete')}}" class="delete"><img
                        src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" /></a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>      
    </div>
  </div>
</div>

<div class="card" id="loan_files" style="display: none;">
  <div class="card-body">
    <h4><strong>Contrato</strong></h4>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="tab-pane">
          <p>Para agregar nuevos archivos de préstamos o eliminar archivos existentes, haga clic en el <b>Términos
              del préstamo</b> pestaña y
            entonces
            <b>Editar préstamo</b>.
          </p>
          <ul class="" style="font-size:12px; padding-left:10px">

            @foreach(unserialize($loan->files) as $key=>$value)
            <li><a href="{!!asset('uploads/'.$value)!!}" target="_blank">{!! $value!!}</a></li>
            @endforeach
          </ul>
        </div>
      </div>      
    </div>
  </div>
</div>

@endsection
@section('footer-scripts')
<script>
$('#repayments-data-table').DataTable({
  dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
  autoWidth: false,
  columnDefs: [{
    orderable: false,
    width: '100px',
    targets: [8]
  }],
  "order": [
    [0, "asc"]
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
  drawCallback: function() {
    $('.delete').on('click', function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      swal({
        title: 'Estas seguro?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
      }).then(function() {
        window.location = href;
      })
    });
  }
});
</script>
<script>
$(document).ready(function() {
  $('#observation').on('click', function(e) {
    $('#observation_table').css('display', 'block');
    $('#history_table').css('display', 'none');
    $('#loan_files').css('display', 'none');
  });

  $('#contrato').on('click', function(e) {
    $('#loan_files').css('display', 'block');
    $('#history_table').css('display', 'none');
    $('#observation_table').css('display', 'none');
  });
});

function update_penalty_status(obj) {
  var loan_id = <?php echo $loan->id ?>;
  console.log('id ==== ' + loan_id);
  var status = obj.checked;
  var sendVal = 1;
  if (status == true) {
    sendVal = 1;
  } else {
    sendVal = 0;
  }
  var post_url = "{{url('loan/update_penalty_status')}}";
  var form_data = {
    id: loan_id,
    status: sendVal,
    _token: "{{csrf_token()}}"
  };
  console.log(form_data);
  console.log(post_url);

  $.post(post_url, form_data, function(response) {
    console.log('=========  response data  ======= ' + response);
  });
}
</script>
@endsection