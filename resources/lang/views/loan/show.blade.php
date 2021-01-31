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

  <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Barra de acciones</h4>
                  <div class="text-center">
            @if(Sentinel::hasAccess('repayments.create'))          
                <a href="{{url('loan/'.$loan->id.'/repayment/create')}}">
                    <button type="button" class="btn btn-success btn-sm">
                        Crear nuevo pago <i class="fas fa-chevron-circle-right ml-1"></i>
                    </button>
                </a>
            @endif    
            
                <a href="#" class="" data-toggle="modal" data-target="#addCharge">
                    <button type="button" class="btn btn-primary btn-sm">
                        Agregar saldo <i class="fas fa-chevron-circle-right ml-1"></i></button>
                </a>  

                <a href="#" class="" data-toggle="modal" data-target="#writeoffLoan">
                    <button type="button" class="btn btn-primary btn-sm">
                        Llevar a perdida <i class="fas fa-chevron-circle-right ml-1"></i></button>
                </a> 
                
                <a href="{{url('loan/'.$loan->id.'/loan_comment/create')}}">
                <button type="button" class="btn btn-primary btn-sm">Agregar comentarios<i class="fas fa-chevron-circle-right ml-1"></i></button>
                </a>
                
            @if(Sentinel::hasAccess('loans.update'))    
                <a href="{{url('loan/'.$loan->id.'/edit')}}" >
                    <!---{{url('loan/'.$loan->id.'/undisburse')}}--->
                    <button type="button" class="btn btn-secondary btn-sm">
                        Editar prestamo <i class="fas fa-chevron-circle-right ml-1"></i></button>
                 </a>
            @endif     
            
            @if(Sentinel::hasAccess('loans.delete'))
                <a href="{{url('loan/'.$loan->id.'/delete')}}" >
                    <button type="button" class="btn btn-danger btn-sm">
                        Eliminar prestamo <i class="fas fa-chevron-circle-right ml-1"></i></button>
                </a>
            @endif
                  </div>
                 
                  <!-- Modal Ends -->
                </div>
              </div>
              
              
              
<!---<div class="card">

  <div class="row">
    <div class="col-md-12">
      <div class="border-left-primary" style="padding: 15px 16px;">
        <div class="panel-heading">
          <h6 class="panel-title">Perfil del Cliente</h6>

          <div class="heading-elements">

          </div>
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-md-2">
              @if(!empty($loan->borrower->photo))
              <a href="{{asset('uploads/'.$loan->borrower->photo)}}" class="fancybox"> <img class="img-thumbnail"
                  src="{{asset('uploads/'.$loan->borrower->photo)}}" alt="user image" style="max-height: 150px" /></a>
              @else
              <img class="img-thumbnail" src="{{asset('assets/dist/img/user.png')}}" alt="user image"
                style="max-height: 150px" />
              @endif
            </div>

            <div class="col-md-3 form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Nombre Cliente
                    :</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  <span>{{$loan->borrower->title}} {{$loan->borrower->first_name}} {{$loan->borrower->last_name}}</span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Codigo Referencia
                    :</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  <span>#{{$loan->borrower->id}}</span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Genero
                    :</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  @if($loan->borrower->gender=="Male")
                  <span class="">{{trans_choice('general.male',1)}}</span>
                  @endif
                  @if($loan->borrower->gender=="Female")
                  <span class="">{{trans_choice('general.female',1)}}</span>
                  @endif
                </div>
              </div>

            </div>
            <div class="col-md-3 form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Edad
                    :</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  @if ($loan->borrower->dob)
                  <span>{{date("Y-m-d")-$loan->borrower->dob}} {{trans_choice('general.year',2)}}</span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Telefono:</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  <span> <a href="{{url('communication/sms/create?borrower_id='.$loan->borrower->id)}}">
                      {{$loan->borrower->mobile}}</a></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Correo Electronico
                    :</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  <span> <a
                      href="{{url('communication/email/create?borrower_id='.$loan->borrower->id)}}">{{$loan->borrower->email}}</a></span>
                </div>
              </div>

            </div>
            <div class="col-md-3 form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Empresa donde labora
                    :</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  <span>{{$loan->borrower->business_name}}</span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4"><strong>Direccion donde reside:</strong></label>
                <div class="col-md-8" style="padding-top: 9px;">
                  <span>{{$loan->borrower->address}}</span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-4"><strong>Pais de residencia:</strong></label>
                <div class="col-sm-8" style="padding-top: 9px;">
                  @if($loan->borrower->country)
                  <span>{{$loan->borrower->country->name}}</span>
                  @endif
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="panel-footer panel-footer-condensed"><a class="heading-elements-toggle"><i
              class="icon-more"></i></a>
          <div class="heading-elements">
            <span class="heading-text">Fecha de Creacion:
              <?php
                $fecha_creacion_cliente = $loan->borrower->created_at;
                $timestamp = strtotime($fecha_creacion_cliente);
                $fecha_creacion_cliente2 = date("d-m-Y", $timestamp);
                ?>
            <span class="text-semibold">{{$fecha_creacion_cliente2}}</span></span>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>--->

<br>
<div class="card">
  <div class="row">
    <div class="col-md-12">
      <!-- Custom Tabs -->
      <div class="panel-white">
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            @if($loan->status=="disbursed" || $loan->status=="closed" || $loan->status=="withdrawn" ||
            $loan->status=="written_off" || $loan->status=="rescheduled" )
            <li class="nav-item"><a class="nav-link" href="#transactions" data-toggle="tab"
                aria-expanded="true"><strong>HISTORIAL DE TRANSACCIONES</strong></a></li>
            <li class="nav-item"><a class="nav-link" href="#loan_schedule" data-toggle="tab"
                aria-expanded="false"><strong>CALENDARIO DE PAGO</strong></a></li>
            <li class="nav-item"><a class="nav-link" href="#pending_dues" data-toggle="tab"
                aria-expanded="false"><strong>RESUMEN DE BALANCES</strong></a>
            </li>

            @endif
            <li class="nav-item active"><a class="nav-link active" href="#loan_terms" data-toggle="tab"
                aria-expanded="false"><strong>INFORMACION</strong></a>
            </li>

            <!-- <li class="nav-item"><a class="nav-link" href="#loan_collateral" data-toggle="tab"
                                        aria-expanded="false"><strong>GARANTIAS</strong></a>
                        </li> -->
            <li class="nav-item"><a class="nav-link" href="#loan_guarantors" data-toggle="tab"
                aria-expanded="false"><strong>GARANTE</strong></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="#loan_files" data-toggle="tab"
                aria-expanded="false"><strong>DOCUMENTOS</strong></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="#loan_comments" data-toggle="tab"
                aria-expanded="false"><strong>OBSERVACIONES</strong></a>
            </li>
          </ul>

          <div class="tab-content">
            @if($loan->status=="disbursed" || $loan->status=="closed" || $loan->status=="withdrawn" ||
            $loan->status=="written_off" || $loan->status=="rescheduled" )
            <!-- /.tab-pane -->
            <div class="tab-pane " id="transactions">
              <!---<div class="btn-group-horizontal">
                @if(Sentinel::hasAccess('repayments.create'))
                <a type="button" class="btn btn-info m-10"
                  href="{{url('loan/'.$loan->id.'/repayment/create')}}">{{trans_choice('general.add',1)}}
                  {{trans_choice('general.repayment',1)}}</a>
                @endif
              </div>--->
              <div class="box box-info">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="table-responsive">
                        <table id="order-listing" class="table">
                          <thead>
                            <tr>
                              <th>
                                Referencia
                              </th>
                              <th>
                                Fecha Efectiva
                              </th>
                              <th>
                                Fecha Procesamiento
                              </th>
                              <th>
                                Tipo de Transaccion
                              </th>

                              <th style="display: none;">
                                Debito
                              </th>
                              <th style="display: none;">
                                Credito
                              </th>
                              <th>
                                Monto
                              </th>
                              <th>
                                Usuario  
                              </th>
                              <!---<th>
                                Balance
                              </th>
                              <th>
                                Referencias
                              </th>--->
                              <th class="text-center">
                                {{trans_choice('general.action',1)}}
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $balance = 0;
                            ?>
                            @foreach(\App\Models\LoanTransaction::where('loan_id',$loan->id)->whereIn('reversal_type',['user','none'])->get()
                            as $key)
                            <?php 
                            $balance = $balance + ($key->debit - $key->credit);
                            ?>
                            <tr>
                              <td>{{$key->id}}</td>
                              <td>
                                <?php
                                $date_history = $key->date;
                                $timestamp = strtotime($date_history);
                                $fecha_historica = date("d-m-Y", $timestamp);
                                ?>
                                {{$fecha_historica}}
                              </td>
                              <td>
                                <?php
                                $date_process = $key->created_at;
                                $timestamp = strtotime($date_process);
                                $fecha_procesamiento = date("d-m-Y", $timestamp);
                                ?>

                                {{$fecha_procesamiento}}</td>

                              <td>
                                @if($key->transaction_type=='disbursement')
                                Capital
                                @endif
                                @if($key->transaction_type=='specified_due_date_fee')

                                @if($key->notes=="")
                                {{trans_choice("Ajuste de Saldo (+)",2)}}
                                @else
                                {{$key->notes}}
                                @endif

                                @endif
                                @if($key->transaction_type=='')
                                Reduccion de saldo (-)
                                @endif
                                @if($key->transaction_type=='installment_fee')
                                {{trans_choice('general.installment_fee',2)}}
                                @endif
                                @if($key->transaction_type=='overdue_installment_fee')
                                {{trans_choice('general.overdue_installment_fee',2)}}
                                @endif
                                @if($key->transaction_type=='loan_rescheduling_fee')
                                {{trans_choice('general.loan_rescheduling_fee',2)}}
                                @endif
                                @if($key->transaction_type=='overdue_maturity')
                                {{trans_choice('general.overdue_maturity',2)}}
                                @endif
                                @if($key->transaction_type=='disbursement_fee')
                                {{trans_choice('general.disbursement',1)}} {{trans_choice('general.charge',2)}}
                                @endif
                                @if($key->transaction_type=='interest')
                                Interes 
                                @endif
                                @if($key->transaction_type=='repayment')
                                Pago
                                @endif
                                @if($key->transaction_type=='penalty')
                                Mora
                                @endif
                                @if($key->transaction_type=='interest_waiver')
                                {{trans_choice('general.interest',1)}} {{trans_choice('general.waiver',2)}}
                                @endif
                                @if($key->transaction_type=='waiver')
                                Ajuste
                                @endif
                                @if($key->transaction_type=='charge_waiver')
                                {{trans_choice('general.charge',1)}} {{trans_choice('general.waiver',2)}}
                                @endif
                                @if($key->transaction_type=='write_off')
                                Balance Castigado
                                @endif
                                @if($key->transaction_type=='write_off_recovery')
                                Pago de recuperacion
                                @endif
                                @if($key->reversed==1)
                                @if($key->reversal_type=="user")
                                <span class="text-danger"><b>(Reversado)</b></span>
                                @endif
                                @if($key->reversal_type=="system")
                                <span class="text-danger"><b>(Reversado)</b></span>
                                @endif
                                @endif
                              </td>
                              <td style="display: none;">{{number_format($key->debit,2)}}</td>
                              <td style="display: none;">{{number_format($key->credit,2)}}</td>
                              <?php
                                $value_credit = $key->credit;
                                $value_debit = $key->debit;
                                $value_amount_trxn = abs($value_debit - $value_credit);
                                ?>
                              <td><strong>{{number_format($value_amount_trxn,2)}}</strong></td>
                              <td><strong>{{$key->user_id}}</strong></td>
                              <!---<td><strong>{{number_format($balance,2)}}</strong></td>
                              <td>{{$key->receipt}}</td>--->
                              
                              
                              
                <td>
                <center>    
                 @if($key->transaction_type=='repayment' && $key->reversible==1)
                    <a href="{{url('loan/transaction/'.$key->id.'/print')}}">
                        <img src="https://img.icons8.com/carbon-copy/64/000000/print.png"/>
                    </a>

                    <a href="{{url('loan/repayment/'.$key->id.'/edit')}}">
                        <img src="https://img.icons8.com/cute-clipart/64/000000/edit.png" />
                    </a>     
                    @if(Sentinel::hasAccess('repayments.delete'))
                    <a href="{{url('loan/repayment/'.$key->id.'/reverse')}}">
                      <img src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" />
                    </a>
                    @endif
                    @endif
                    @if($key->transaction_type=='penalty' && $key->reversible==1)  
                    ...
                    @endif
                    @if($key->transaction_type=='installment_fee' && $key->reversible==1)
                    ...
                    @endif
                    @if($key->transaction_type=='specified_due_date_fee' && $key->reversible==1)
                    ...
                    @endif                    
                </center>    
                </td>                              
                              
                              
                              
                              
                              <!---
                              <td class="text-center">
                                <ul class="icons-list">
                                  <li class="dropdown">
                                    <a href="#" data-toggle="dropdown">
                                      <img src="https://img.icons8.com/pastel-glyph/25/000000/plus.png" />
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                      <li>
                                        <a href="{{url('loan/transaction/'.$key->id.'/show')}}"><i
                                            class="fa fa-search"></i> Visualizar
                                        </a>
                                      </li>
                                      <li>

                                        @if($key->transaction_type=='repayment' && $key->reversible==1)
                                      <li>
                                        <a href="{{url('loan/transaction/'.$key->id.'/print')}}" target="_blank"><i
                                            class="icon-printer"></i> Imprimir recibo
                                        </a>
                                      </li>
                                      <li>
                                        <a href="{{url('loan/transaction/'.$key->id.'/pdf')}}" target="_blank"><i
                                            class="icon-file-pdf"></i> Descargar recibo
                                        </a>
                                      </li>
                                      @if(Sentinel::hasAccess('repayments.delete'))
                                      <li>
                                        <a href="{{url('loan/repayment/'.$key->id.'/edit')}}"><i class="fa fa-edit"></i>
                                          Modificar pago
                                        </a>
                                      </li>
                                      <li>
                                        <a href="{{url('loan/repayment/'.$key->id.'/reverse')}}" class="delete"><i
                                            class="fa fa-minus-circle"></i> Reversar pago
                                        </a>
                                      </li>
                                      @endif
                                      @endif
                                      @if($key->transaction_type=='penalty' && $key->reversible==1)
                                      <li>
                                        <a href="{{url('loan/transaction/'.$key->id.'/waive')}}" class="delete"><i
                                            class="fa fa-minus-circle"></i> {{ trans('general.waive') }}
                                        </a>
                                      </li>
                                      @endif
                                      @if($key->transaction_type=='installment_fee' && $key->reversible==1)
                                      <li>
                                        <a href="{{url('loan/transaction/'.$key->id.'/waive')}}" class="delete"><i
                                            class="fa fa-minus-circle"></i> {{ trans('general.waive') }}
                                        </a>
                                      </li>
                                      @endif
                                      @if($key->transaction_type=='specified_due_date_fee' && $key->reversible==1)
                                      <li>
                                        <a href="{{url('loan/transaction/'.$key->id.'/waive')}}" class="delete"><i
                                            class="fa fa-minus-circle"></i> {{ trans('general.waive') }}
                                        </a>
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->
            <!-- /.tab-pane -->
            <div class="tab-pane" id="loan_schedule">
              <!---<div class="row">
                <div class="col-sm-3">

                  <div class="input-group-btn">
                    <button type="button" class="btn btn-info dropdown-toggle m-10" data-toggle="dropdown"
                      aria-expanded="false">Mas opciones
                      <span class="fa fa-caret-down"></span></button>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <a href="{{url('loan/'.$loan->id.'/schedule/print')}}" target="_blank">Imprimir</a>
                      </li>
                      <li>
                        <a href="{{url('loan/'.$loan->id.'/schedule/pdf')}}" target="_blank">Descargar en PDF</a>
                      </li>
                      @if(Sentinel::hasAccess('communication.create'))
                      <li>
                        <a href="{{url('loan/'.$loan->id.'/schedule/email')}}">Enviar por correo</a>
                      </li>
                      @endif
                      <li>
                        <a href="{{url('loan/'.$loan->id.'/schedule/excel')}}" target="_blank">Descargar en Excel</a>
                      </li>

                      <li>
                                            <a href="{{url('loan/'.$loan->id.'/schedule/csv')}}"
                                               target="_blank">Download in CSV</a></li>
                    </ul>
                  </div>
                </div>
              </div>--->
              <div class="box box-success">
                <div class="panel-body table-responsive no-padding">
                  <table id="order-listing" class="table">
                    <tbody>
                      <tr class="bg-secondary">
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
                        //check for disbursement charges
                        $disbursement_charges = \App\Models\LoanTransaction::where('loan_id',
                            $loan->id)->where('transaction_type',
                            'disbursement_fee')->where('reversed', 0)->sum('debit');
                        ?>
                      <tr>
                        <td></td>
                        <td>
                          <!---Fecha desembolso prestamos--->
                          {{$loan->release_date}}
                        </td>
                        <td></td>
                        <td>
                          <!---Descripcion transaccion principal--->
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

                        // ***CALCULO INTERES***
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
                                //find the corresponding paid by date
                                $p_paid = 0;
                                foreach (\App\Models\LoanTransaction::where('loan_id',
                                    $loan->id)->where('transaction_type',
                                    'repayment')->where('reversed', 0)->orderBy('date',
                                    'asc')->get() as $key) {
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
                      <tr class="@if($overdue==1) danger  @endif @if($overdue==0 && $outstanding==0) success  @endif">
                        <td>
                          {{$count}}
                        </td>
                        <td>
                          <?php
                            //Fechas de pago esperada del prestamo            
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
                            //Fecha pago tardio recibido            
                            $pago_tardio_in = $paid_by;
                            $timestamp = strtotime($pago_tardio_in);
                            $pago_tardio_out = date("d-m-Y", $timestamp);
                            ?>
                          {{$pago_tardio_out}}

                          @endif
                          @if(!empty($paid_by) && $overdue==0)
                          <?php
                            //Fecha pago tardio recibido            
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
                          <!--- REVISAR MORA --->
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

            <div class="tab-pane" id="pending_dues">
              <div class="tab_content">
                <?php
                    $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($loan->id,
                        $loan->release_date, date("Y-m-d"));
                    $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($loan->id,
                        $loan->release_date, date("Y-m-d"));
                ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <h6>
                          <b>% Pagado
                            :</b>
                        </h6>
                      </div>
                      <div class="col-md-6">
                        <?php
                            $count = \App\Models\LoanSchedule::where('due_date', '<=',
                                date("Y-m-d"))->where('loan_id', $loan->id)->count();
                        ?>
                        @if($count>0)
                        <h6><b>{{round(($count-$total_overdue)/$count)}}%</b></h6>
                        @else
                        <h6><b>0 %</b></h6>
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <h6>
                          <b>Monto total en atraso:</b>
                        </h6>
                      </div>
                      <div class="col-md-6">
                        @if(($loan_due_items["principal"]+$loan_due_items["interest"]+$loan_due_items["fees"]+$loan_due_items["penalty"])>($loan_paid_items["principal"]+$loan_paid_items["interest"]+$loan_paid_items["fees"]+$loan_paid_items["penalty"]))
                        <h6><b>
                            <span
                              class="text-danger">{{number_format(($loan_due_items["principal"]+$loan_due_items["interest"]+$loan_due_items["fees"]+$loan_due_items["penalty"])-($loan_paid_items["principal"]+$loan_paid_items["interest"]+$loan_paid_items["fees"]+$loan_paid_items["penalty"]),2)}}</span></b>
                        </h6>
                        @else
                        <h6><b> <span class="text-danger">0.00</span></b></h6>
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <h6>
                          <b>Dias en atraso:</b>
                        </h6>
                      </div>
                      <div class="col-md-6">
                        @if(!empty($overdue_date))
                        <?php
                            $date1 = new DateTime($overdue_date);
                            $date2 = new DateTime(date("Y-m-d"));
                            $days_arrears_count = $date2->diff($date1)->format("%a");
                        ?>
                        <h6>
                          <b><span class="text-danger">{{$days_arrears_count}}</span></b>
                        </h6>
                        @else
                        <h6><b> <span class="text-success">Al dia</span></b></h6>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-6">
                        <h6>
                          <b>Ultimo pago:</b>
                        </h6>
                      </div>
                      <div class="col-md-6">
                        <?php
                            $last_payment = \App\Models\LoanTransaction::where('loan_id', $loan->id)->where('transaction_type',
                                                        'repayment')->where('reversed', 0)->orderBy('date',
                                                        'desc')->first();
                            ?>
                        @if(!empty($last_payment))
                        <h6><b>{{number_format($last_payment->credit,2)}}
                            <?php                                    
                                $fecha_de_ultpago_in = $last_payment->date;
                                $fecha_de_ultpago_process = strtotime($fecha_de_ultpago_in);
                                $fecha_de_ultpago_out = date("d-m-Y", $fecha_de_ultpago_process);
                            ?>
                            en fecha {{$fecha_de_ultpago_out}}</b></h6>
                        @else
                        No se han realizado pagos
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <h6>
                          <b>Proximo pago:</b>
                        </h6>
                      </div>
                      <div class="col-md-6">
                        <?php
                            $count = \App\Models\LoanSchedule::where('due_date', '<=',
                                date("Y-m-d"))->where('loan_id', $loan->id)->count();
                            $first = 0;
                        ?>
                        @foreach($next_payment as $key=>$value)
                        <?php
                            if ($key > date("Y-m-d")) {
                                if ($first == 0) {
                                    $fecha_de_proxpago_in = $key;
                                    $fecha_de_proxpago_process = strtotime($fecha_de_proxpago_in);
                                    $fecha_de_proxpago_out = date("d-m-Y", $fecha_de_proxpago_process);
                            
                                
                                    echo ' <h6><b>' . number_format($value,2) . ' en fecha ' . $fecha_de_proxpago_out . '</b></h6>';
                                }
                                
                                $first = $first + 1;
                            }
                        ?>
                        @endforeach
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <h6>
                          <b>Fecha de vencimiento:</b>
                        </h6>
                      </div>
                      <div class="col-md-6">
                        <?php
                            $fecha_de_vencimiento_in = \App\Models\LoanSchedule::where('loan_id', $loan->id)->orderBy('due_date','asc')->get()->last()->due_date;
                            $fecha_de_vencimiento_process = strtotime($fecha_de_vencimiento_in);
                            $fecha_de_vencimiento_out = date("d-m-Y", $fecha_de_vencimiento_process);
                        ?>
                        <h6>
                          <b>{{$fecha_de_vencimiento_out}}</b>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>


                <table id="order-listing" class="table">
                  <tbody>
                    <tr>
                      <th width="200">
                        <b>Balances</b>
                      </th>
                      <th style="text-align:right;">
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
                    </tr>
                    <?php
                    $loan_total_nopaid_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                    $loan_total_nopaid_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                    $loan_total_nopaid_fee = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                    $loan_total_nopaid_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                    $loan_total_nopaid_total = $loan_total_nopaid_principal + $loan_total_nopaid_interest + $loan_total_nopaid_fee + $loan_total_nopaid_penalty;
                    ?>
                    <tr>
                      <td class="text-bold bg-danger">Balance Total
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_nopaid_principal,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_nopaid_interest,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_nopaid_fee,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_nopaid_penalty,2)}}
                      </td>
                      <td style="text-align:right; font-weight:bold">
                        {{number_format($loan_total_nopaid_total,2)}}
                      </td>
                    </tr>
                    <?php
                        $loan_total_paid_principal = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->sum('credit');
                            $loan_total_paid_interest = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->sum('credit');
                                $loan_total_paid_charge = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->sum('credit');
                            $loan_total_paid_penalty = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->sum('credit');
                        $total_paid_balance1 = $loan_total_paid_principal + $loan_total_paid_interest + $loan_total_paid_charge + $loan_total_paid_penalty;
                            
                        $id_total_pending_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
                        $id_total_pending_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
                        $id_total_pending_charge = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
                        $id_total_pending_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
                        
                        $loan_total_pending_principal = $loan_total_nopaid_principal - $loan_total_paid_principal;
                        $loan_total_pending_interest = $loan_total_nopaid_interest - $loan_total_paid_interest;
                        $loan_total_pending_charge = $loan_total_nopaid_fee - $loan_total_paid_charge;
                        $loan_total_pending_penalty = $loan_total_nopaid_penalty - $loan_total_paid_penalty;
                        $loan_total_pending_total = $loan_total_pending_principal + $loan_total_pending_interest + $loan_total_pending_charge + $loan_total_pending_penalty;
                    ?>
                    <tr>
                      <td class="text-bold bg-green">
                        Balance Pagado
                      </td>
                      <td style="text-align:right">

                        {{number_format($loan_total_paid_principal,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_paid_interest,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_paid_charge,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_paid_penalty,2)}}
                      </td>
                      <td style="text-align:right; font-weight:bold">
                        {{number_format($total_paid_balance1,2)}}
                      </td>
                    </tr>

                    <tr>
                      <td class="text-bold btn-info">
                        Balance Pendiente
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_pending_principal,2)}}
                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_pending_interest,2)}}

                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_pending_charge,2)}}

                      </td>
                      <td style="text-align:right">
                        {{number_format($loan_total_pending_penalty,2)}}

                      </td>
                      <td style="text-align:right; font-weight:bold">
                        {{number_format($loan_total_pending_total,2)}}

                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>

            <div class="modal fade" id="waiveInterest">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">*</span></button>
                    <h4 class="modal-title">{{trans_choice('general.waive',1)}} {{trans_choice('general.interest',1)}}
                    </h4>
                  </div>
                  {!! Form::open(array('url' => url('loan/'.$loan->id.'/waive_interest'),'method'=>'post')) !!}
                  <div class="modal-body">
                    <div class="form-group">
                      <div class="form-line">
                        {!! Form::label('date',trans_choice('general.date',1),array('class'=>' control-label')) !!}
                        {!! Form::text('date',date("Y-m-d"),array('class'=>'form-control
                        date-picker','required'=>'required')) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-line">
                        {!! Form::label('amount',trans_choice('general.amount',1),array('class'=>' control-label')) !!}
                        {!!
                        Form::text('amount',\App\Helpers\GeneralHelper::loan_total_interest($loan->id)-$loan_paid_items['interest'],array('class'=>'form-control
                        touchspin',''=>'','required'=>'required')) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-line">
                        {!! Form::label( 'notes',trans_choice('general.note',2),array('class'=>' control-label')) !!}
                        {!! Form::textarea('notes',null,array('class'=>'form-control','rows'=>'3')) !!}
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Procesar</button>
                    <button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
                  </div>
                  {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
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
                        foreach (\App\Models\Charge::where('charge_type',
                            'specified_due_date')->where('active',
                            1)->get() as $key) {
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
                      <!--{!! Form::textarea('notes',null,array('class'=>'form-control','rows'=>'3')) !!}-->
                      {!! Form::select('notes',array('Ajuste de Interes (+)'=>trans_choice("Ajuste de Interes
                      (+)",1),'Ajuste de Mora (+)'=>trans_choice("Ajuste de Mora (+)",1)),null,array('class'=>'
                      select2','required'=>'required')) !!}
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-info">{{trans_choice('general.save',1)}}</button>
                    <button type="button" class="btn default"
                      data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
                  </div>
                  {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            @endif

            <div class="tab-pane active" id="loan_terms">
              <div class="row">
                <div class="col-sm-8">
                  @if($loan->status=='pending')
                  <div class="col-sm-6">
                    @if(Sentinel::hasAccess('loans.approve'))
                    <button type="button" class="btn btn-success m-10" data-toggle="modal"
                      data-target="#approveLoan">{{trans_choice('general.approve',1)}}</button>
                    <button type="button" class="btn btn-danger m-10" data-toggle="modal"
                      data-target="#declineLoan">{{trans_choice('general.decline',1)}}</button>
                    @endif
                  </div>
                  @endif
                  @if($loan->status=='declined')
                  <div class="col-sm-6">
                    @if(Sentinel::hasAccess('loans.approve'))
                    <button type="button" class="btn btn-success m-10" data-toggle="modal"
                      data-target="#approveLoan">{{trans_choice('general.approve',1)}}</button>
                    @endif
                  </div>
                  @endif
                  @if($loan->status=='approved')
                  <div class="col-sm-6">
                    @if(Sentinel::hasAccess('loans.disburse'))
                    <button type="button" class="btn btn-success m-10" data-toggle="modal"
                      data-target="#disburseLoan">{{trans_choice('general.disburse',1)}}</button>
                    <a type="button" class="btn btn-danger  delete m-10"
                      href="{{url('loan/'.$loan->id.'/unapprove')}}">{{trans_choice('general.undo',1)}}
                      {{trans_choice('general.approval',1)}}</a>
                    @endif
                  </div>
                  @endif
                  @if($loan->status=='written_off')
                  <div class="col-sm-6">
                    @if(Sentinel::hasAccess('loans.writeoff'))
                    <a type="button" class="btn btn-danger  delete m-10"
                      href="{{url('loan/'.$loan->id.'/unwrite_off')}}">{{trans_choice('general.undo',1)}}
                      {{trans_choice('general.write_off',1)}}</a>
                    @endif
                  </div>
                  @endif
                  @if($loan->status=='withdrawn')
                  <div class="col-sm-6">
                    @if(Sentinel::hasAccess('loans.withdraw'))
                    <a type="button" class="btn btn-danger  delete m-10"
                      href="{{url('loan/'.$loan->id.'/unwithdraw')}}">{{trans_choice('general.undo',1)}}
                      {{trans_choice('general.withdrawal',1)}}</a>
                    @endif
                  </div>
                  @endif
                  @if($loan->status=='disbursed')
                  <!----<div class="col-sm-3">
                    <div class="btn-group-horizontal">
                      @if(Sentinel::hasAccess('loans.disburse'))
                      <a type="button" class="btn btn-danger delete m-10"
                        href="{{url('loan/'.$loan->id.'/undisburse')}}">{{trans_choice('general.undo',1)}}
                        {{trans_choice('general.disbursement',1)}}</a>
                      @endif
                    </div>
                  </div>--->
                  <!---
                  <div class="col-sm-3">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-info dropdown-toggle m-10" data-toggle="dropdown"
                        aria-expanded="false">Mas opciones
                        <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu" role="menu">
                        @if(Sentinel::hasAccess('loans.writeoff'))
                        <li>
                          <a href="#" class="" data-toggle="modal" data-target="#writeoffLoan">Llevar a perdida</a>
                        </li>
                        @endif
                        @if(Sentinel::hasAccess('loans.update'))
                        <li>
                          <a href="#" class="" data-toggle="modal" data-target="#waiveInterest">- Reducir saldo</a>
                        </li>
                        @endif
                        @if(Sentinel::hasAccess('loans.update'))
                        <li>
                          <a href="#" class="" data-toggle="modal" data-target="#addCharge">+ Agregar saldo</a>
                        </li>
                        @endif
                      </ul>
                    </div>
                  </div>--->
                  @endif

                  @if($loan->status=="disbursed" || $loan->status=="closed" || $loan->status=="withdrawn" ||
                  $loan->status=="written_off" || $loan->status=="rescheduled" )
                  <!---
                  <div class="col-sm-3">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-info dropdown-toggle m-10" data-toggle="dropdown"
                        aria-expanded="false">Generar Calendario
                        <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu" role="menu">

                        <li>
                          <a href="{{url('loan/'.$loan->id.'/loan_statement/print')}}" target="_blank">Imprimir</a>
                        </li>

                        <li>
                          <a href="{{url('loan/'.$loan->id.'/loan_statement/pdf')}}" target="_blank">Descargar en
                            PDF</a>
                        </li>
                        @if(Sentinel::hasAccess('communication.create'))
                        <li>
                          <a href="{{url('loan/'.$loan->id.'/loan_statement/email')}}">Enviar por Email</a>
                        </li>
                        @endif
                      </ul>
                    </div>
                  </div>--->
                  @endif
                </div>

                <!---
                <div class="col-sm-4 pull-right">
                  <div class="btn-group-horizontal">
                    @if(Sentinel::hasAccess('loans.update'))
                    <a type="button" class="btn btn-info m-10"
                      href="{{url('loan/'.$loan->id.'/edit')}}">{{trans_choice('general.edit',1)}}
                      {{trans_choice('general.loan',1)}}</a>
                    @endif

                    @if(Sentinel::hasAccess('loans.delete'))
                    <a type="button" class="btn btn-info m-10 deleteLoan"
                      href="{{url('loan/'.$loan->id.'/delete')}}">{{trans_choice('general.delete',1)}}
                      {{trans_choice('general.loan',1)}}</a>
                    @endif
                  </div>
                </div>--->
              </div>

              <div class="panel-body no-padding">
                <table class="table table-condensed">
                  <tbody>
                    <tr>
                      <td>
                        <b>Estatus del Prestamo</b>
                      </td>
                      <td>
                        @if($loan->maturity_date < date("Y-m-d") && \App\Helpers\GeneralHelper::loan_total_balance($loan->
                          id)>0)
                          <span class="label label-danger">{{trans_choice('general.past_maturity',1)}}</span>
                          @else
                          @if($loan->status=='pending')
                          <span class="label label-warning">{{trans_choice('general.pending',1)}}
                            {{trans_choice('general.approval',1)}}</span>
                          @endif
                          @if($loan->status=='approved')
                          <span class="label label-info">{{trans_choice('general.awaiting',1)}}
                            {{trans_choice('general.disbursement',1)}}</span>
                          @endif
                          @if($loan->status=='disbursed')
                          <span class="label label-info">{{trans_choice('general.active',1)}}</span>
                          @endif
                          @if($loan->status=='declined')
                          <span class="label label-danger">{{trans_choice('general.declined',1)}}</span>
                          @endif
                          @if($loan->status=='withdrawn')
                          <span class="label label-danger">{{trans_choice('general.withdrawn',1)}}</span>
                          @endif
                          @if($loan->status=='written_off')
                          <span class="label label-danger">{{trans_choice('general.written_off',1)}}</span>
                          @endif
                          @if($loan->status=='closed')
                          <span class="label label-success">{{trans_choice('general.closed',1)}}</span>
                          @endif
                          @if($loan->status=='pending_reschedule')
                          <span class="label label-warning">{{trans_choice('general.pending',1)}}
                            {{trans_choice('general.reschedule',1)}}</span>
                          @endif
                          @if($loan->status=='rescheduled')
                          <span class="label label-info">{{trans_choice('general.rescheduled',1)}}</span>
                          @endif
                          @endif
                      </td>
                    </tr>
                    <tr>
                      <td width="200">
                        <b>Prestamo Numero</b>
                      </td>
                      <td>000{{$loan->id}}</td>
                    </tr>
                    <tr>
                      <td>
                        <b>Ruta</b>
                      </td>
                      <td>
                        @if(!empty($loan->loan_product))
                        {{$loan->loan_product->name}}
                        @endif
                      </td>
                    </tr>

                    <tr style="display: none;" >
                      <td><b>Desembolsado por</b></td>
                      <td>
                        @if(!empty($loan->loan_disbursed_by))
                        {{$loan->loan_disbursed_by->name}}
                        @endif
                      </td>
                    </tr>

                    <tr>

                      <td>
                        <b>Monto Aprobado</b>
                      </td>
                      <td>{{number_format($loan->principal,2)}}</td>

                    </tr>

                    <tr>

                      <td>
                        <b>Fecha de Desembolso</b>
                      </td>
                      <?php
                        $original_date = $loan->release_date;
                        $timestamp = strtotime($original_date);
                        $fecha_de_desembolso = date("d-m-Y", $timestamp);
                        ?>
                      <td>
                        {{$fecha_de_desembolso}}
                      </td>

                    </tr>

                    <tr>
                      <td>
                        <b>Fecha del primer Pago</b>
                      </td>
                      <?php
                        $original_date_first = $loan->first_payment_date;
                        $timestamp_first = strtotime($original_date_first);
                        $fecha_de_primerpago = date("d-m-Y", $timestamp_first);
                    ?>
                      <td>{{$fecha_de_primerpago}}</td>
                    </tr>

                    <tr>
                      <td>
                        <b>Tipo de interes</b>
                      </td>
                      <td>
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
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <b>Interes aplicado</b>
                      </td>
                      <td>{{number_format($loan->interest_rate,2)}}% / {{$loan->interest_period}}
                      </td>
                    </tr>                    
                    
                    <tr style="display: none;" >
                      <td>
                        <b>Mora activada</b>
                      </td>
                      <td><input type="checkbox" name="penalty_status_active" id="penalty_status_active" @if ($loan->penalty_status == 1) checked @endif value="1" class="form-control" style="width: 20px;" onchange="update_penalty_status(this)">
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <b>Duracion</b>
                      </td>
                      <td>{{number_format($loan->loan_duration,2)}}

                        @if($loan->loan_duration_type=='month')
                        Mes
                        @endif
                        @if($loan->loan_duration_type=='day')
                        Dia
                        @endif
                        @if($loan->loan_duration_type=='week')
                        Semana
                        @endif
                        @if($loan->loan_duration_type=='year')
                        Año
                        @endif
                      </td>
                    </tr>
                    
                    <tr>
                      <td><b>Frecuencia de pago</b></td>
                      <td>
                        @if($loan->repayment_cycle=='daily')
                        {{trans_choice('general.daily',1)}}
                        @endif
                        @if($loan->repayment_cycle=='weekly')
                        {{trans_choice('general.weekly',1)}}
                        @endif
                        @if($loan->repayment_cycle=='monthly')
                        {{trans_choice('general.monthly',1)}}
                        @endif
                        @if($loan->repayment_cycle=='bi_monthly')
                        {{trans_choice('general.bi_monthly',1)}}
                        @endif
                        @if($loan->repayment_cycle=='quarterly')
                        {{trans_choice('general.quarterly',1)}}
                        @endif
                        @if($loan->repayment_cycle=='semi_annual')
                        {{trans_choice('general.semi_annually',1)}}
                        @endif
                        @if($loan->repayment_cycle=='annually')
                        {{trans_choice('general.annual',1)}}
                        @endif
                      </td>
                    </tr>

                    <tr>
                      <td><b>Cantidad de pagos</b></td>
                      <td>
                        {{\App\Models\LoanSchedule::where('loan_id',$loan->id)->count()}}
                      </td>
                    </tr>

                    <tr>
                      <td></td>
                    </tr>

                  </tbody>
                </table>
              </div>

            </div>

            <div class="tab-pane" id="loan_collateral">
              <div class="btn-group-horizontal">
                @if(Sentinel::hasAccess('collateral.create'))
                <a type="button" class="btn btn-info m-10"
                  href="{{url('collateral/'.$loan->id.'/create?return_url='.Request::url())}}">{{trans_choice('general.add',1)}}
                  {{trans_choice('general.collateral',1)}}</a>
                @endif
              </div>
              <div class="box box-success">
                <div class="table-responsive">
                  <table id="data-table" class="table table-striped table-condensed table-hover">
                    <thead>
                      <tr>
                        <th>{{trans_choice('general.type',1)}}</th>
                        <th>{{trans_choice('general.name',1)}}</th>
                        <th>{{trans_choice('general.value',1)}}</th>
                        <th>{{trans_choice('general.status',1)}}</th>
                        <th>{{trans_choice('general.date',1)}}</th>
                        <th>{{ trans_choice('general.action',1) }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($loan->collateral as $key)
                      <tr>
                        <td>
                          @if(!empty($key->collateral_type))
                          {{$key->collateral_type->name}}
                          @endif
                        </td>
                        <td>{{ $key->name }}</td>
                        <td>{{ $key->value }}</td>
                        <td>
                          @if($key->status=='deposited_into_branch')
                          {{trans_choice('general.deposited_into_branch',1)}}
                          @endif
                          @if($key->status=='collateral_with_borrower')
                          {{trans_choice('general.collateral_with_borrower',1)}}
                          @endif
                          @if($key->status=='returned_to_borrower')
                          {{trans_choice('general.returned_to_borrower',1)}}
                          @endif
                          @if($key->status=='repossession_initiated')
                          {{trans_choice('general.repossession_initiated',1)}}
                          @endif
                          @if($key->status=='repossessed')
                          {{trans_choice('general.repossessed',1)}}
                          @endif
                          @if($key->status=='sold')
                          {{trans_choice('general.sold',1)}}
                          @endif
                          @if($key->status=='lost')
                          {{trans_choice('general.lost',1)}}
                          @endif
                        </td>
                        <td>{{ $key->date }}</td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown"
                              aria-expanded="false">
                              {{ trans('general.choose') }} <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              @if(Sentinel::hasAccess('collateral.view'))
                              <li><a href="{{ url('collateral/'.$key->id.'/show') }}"><i class="fa fa-search"></i>
                                  {{ trans('general.view') }}
                                </a></li>
                              @endif
                              @if(Sentinel::hasAccess('collateral.update'))
                              <li><a href="{{ url('collateral/'.$key->id.'/edit') }}"><i class="fa fa-edit"></i>
                                  {{ trans('general.edit') }}
                                </a></li>
                              @endif
                              @if(Sentinel::hasAccess('collateral.delete'))
                              <li>
                                <a href="{{ url('collateral/'.$key->id.'/delete') }}" class="delete"><i
                                    class="fa fa-trash"></i> {{ trans('general.delete') }}
                                </a>
                              </li>
                              @endif
                            </ul>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="loan_guarantors">
              <div class="btn-group-horizontal">
                @if(Sentinel::hasAccess('loans.guarantor.create'))
                <a type="button" class="btn btn-info m-10" data-toggle="modal"
                  data-target="#addGuarantor">{{trans_choice('general.add',1)}}
                  {{trans_choice('general.guarantor',1)}}</a>
                @endif
              </div>
              <div class="box box-success">
                <div class="table-responsive">
                  <table id="data-table" class="table table-bordered table-condensed table-hover">
                    <thead>
                      <tr>
                        <th>{{trans_choice('general.full_name',1)}}</th>
                        <th>{{trans_choice('general.business',1)}}</th>
                        <th>{{trans_choice('general.unique',1)}}#</th>
                        <th>{{trans_choice('general.mobile',1)}}</th>
                        <th>{{trans_choice('general.email',1)}}</th>
                        <th>{{ trans_choice('general.action',1) }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($loan->guarantors as $key)
                      @if(!empty($key->guarantor))
                      <tr>
                        <td>{{ $key->guarantor->first_name }} {{ $key->guarantor->last_name }}</td>
                        <td>{{ $key->guarantor->business_name }}</td>
                        <td>{{ $key->guarantor->unique_number }}</td>
                        <td>{{ $key->guarantor->mobile }}</td>
                        <td>{{ $key->guarantor->email }}</td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown"
                              aria-expanded="false">
                              {{ trans('general.choose') }} <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">

                              @if(Sentinel::hasAccess('loans.guarantor.create'))
                              <li>
                                <a href="{{ url('guarantor/'.$key->guarantor->id.'/show') }}"><i
                                    class="fa fa-search"></i> {{trans_choice('general.detail',2)}}
                                </a>
                              </li>
                              @endif
                              @if(Sentinel::hasAccess('loans.guarantor.delete'))
                              <li>
                                <a href="{{ url('loan/guarantor/'.$key->guarantor->id.'/remove') }}" class="delete"><i
                                    class="fa fa-minus"></i> {{ trans('general.remove') }}
                                </a>
                              </li>
                              @endif
                              @if(Sentinel::hasAccess('loans.guarantor.update'))
                              <li>
                                <a href="{{ url('guarantor/'.$key->guarantor->id.'/edit') }}"><i class="fa fa-edit"></i>
                                  {{ trans('general.edit') }}
                                </a>
                              </li>
                              @endif
                              @if(Sentinel::hasAccess('loans.guarantor.delete'))
                              <li>
                                <a href="{{ url('guarantor/'.$key->guarantor->id.'/delete') }}" class="delete"><i
                                    class="fa fa-trash"></i> {{ trans('general.delete') }}
                                </a>
                              </li>
                              @endif
                            </ul>
                          </div>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="loan_files">
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
            
            <div class="tab-pane" id="loan_comments">
              <div class="tab_content card-body">
                <!---<div class="btn-group-horizontal">
                  <a type="button" class="btn btn-info m-10"
                    href="{{url('loan/'.$loan->id.'/loan_comment/create')}}">{{trans_choice('general.add',1)}}
                    {{trans_choice('general.comment',2)}}</a>
                </div>--->


                <div class="table-responsive">
                  <table id="data-table" class="table">
                    <thead>
                      <tr class="bg-secondary">
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
                          <!---<div class="media-left">
                            <a href="#"><img src="{{ asset('assets/themes/limitless/images/placeholder.jpg') }}" class="img-circle img-md" alt=""></a>
                          </div>--->
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
                            <a href="{{url('loan/'.$loan->id.'/loan_comment/'.$comment->id.'/delete')}}"><img
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
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
      </div>
      <!-- nav-tabs-custom -->
    </div>
  </div>
  <div class="modal fade" id="approveLoan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">Aprobar prestamo</h4>
        </div>
        {!! Form::open(array('url' => url('loan/'.$loan->id.'/approve'),'method'=>'post')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('Fecha aprobacion',null,array('class'=>' control-label')) !!}
              {!! Form::text('approved_date',date("Y-m-d"),array('class'=>'form-control
              date-picker','required'=>'required')) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('Monto aprobado',null,array('class'=>' control-label')) !!}
              {!! Form::text('approved_amount',$loan->principal,array('class'=>'form-control
              touchspin','required'=>'required')) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label( 'Comentarios',null,array('class'=>' control-label')) !!}
              {!! Form::textarea('approved_notes','',array('class'=>'form-control','rows'=>'3')) !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Procesar</button>
          <button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="disburseLoan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">Desembolsar prestamo</h4>
        </div>
        {!! Form::open(array('url' => url('loan/'.$loan->id.'/disburse'),'method'=>'post')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('Fecha desembolso',null,array('class'=>' control-label')) !!}
              {!! Form::date('disbursed_date',$loan->release_date,array('class'=>'form-control
              date-picker','required'=>'required')) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('Fecha primer pago',null,array('class'=>' control-label')) !!}
              {!! Form::date('first_payment_date',$loan->first_payment_date,array('class'=>'form-control
              date-picker',''=>'','required'=>'required')) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('Desembolsado por',null,array('class'=>' control-label')) !!}
              {!!
              Form::select('loan_disbursed_by_id',$loan_disbursed_by,null,array('class'=>'form-control','required'=>'required'))
              !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label( 'Comentarios',null,array('class'=>' control-label')) !!}
              {!! Form::textarea('disbursed_notes','',array('class'=>'form-control','rows'=>'3')) !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">Procesar</button>
          <button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="declineLoan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">Declinar prestamo</h4>
        </div>
        {!! Form::open(array('url' => url('loan/'.$loan->id.'/decline'),'method'=>'post')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('Fecha declinacion',null,array('class'=>' control-label')) !!}
              {!! Form::text('declined_date',date("Y-m-d"),array('class'=>'form-control
              date-picker','required'=>'required')) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label( 'Comentarios',null,array('class'=>' control-label')) !!}
              {!! Form::textarea('declined_notes','',array('class'=>'form-control','rows'=>'3','required'=>'required'))
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
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="withdrawLoan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">{{trans_choice('general.withdraw',1)}} {{trans_choice('general.loan',1)}}</h4>
        </div>
        {!! Form::open(array('url' => url('loan/'.$loan->id.'/withdraw'),'method'=>'post')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('withdrawn_date',trans_choice('general.date',1),array('class'=>' control-label')) !!}
              {!! Form::text('withdrawn_date',date("Y-m-d"),array('class'=>'form-control
              date-picker','required'=>'required')) !!}
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              {!! Form::label( 'withdrawn_notes',trans_choice('general.note',2),array('class'=>' control-label')) !!}
              {!! Form::textarea('withdrawn_notes','',array('class'=>'form-control','rows'=>'3','required'=>'required'))
              !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">{{trans_choice('general.save',1)}}</button>
          <button type="button" class="btn default" data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="withdrawSaving">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">{{trans_choice('general.withdraw',1)}} {{trans_choice('general.saving',1)}}</h4>
        </div>
        {!! Form::open(array('url' =>'','method'=>'post','id'=>'withdrawSavingForm')) !!}
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('amount',trans_choice('general.amount',1),array('class'=>'')) !!}
            {!! Form::text('amount',null, array('class' => 'form-control touchspin',
            'id'=>'accepted_amount','required'=>'')) !!}
          </div>
          <div class="form-group">
            {!! Form::label('date',trans_choice('general.date',2),array('class'=>'')) !!}
            {!! Form::text('date',date("Y-m-d"), array('class' => 'form-control date-picker',
            'placeholder'=>'','required'=>'')) !!}
          </div>
          <div class="form-group">
            {!! Form::label('time',trans_choice('general.time',2),array('class'=>'')) !!}
            {!! Form::text('time',date("H:i"), array('class' => 'form-control time-picker',
            'placeholder'=>'','required'=>'')) !!}
          </div>
          <div class="form-group">
            {!! Form::label('notes',trans_choice('general.note',2),array('class'=>'')) !!}
            {!! Form::textarea('notes',null, array('class' => 'form-control', 'placeholder'=>'',)) !!}
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">{{trans_choice('general.save',1)}}</button>
          <button type="button" class="btn default" data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="rescheduleLoan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">{{trans_choice('general.reschedule',1)}} {{trans_choice('general.loan',1)}}</h4>
        </div>
        {!! Form::open(array('url' => url('loan/'.$loan->id.'/reschedule'),'method'=>'get')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('type',trans_choice('general.reschedule',1).'
              '.trans_choice('general.on',1),array('class'=>' control-label')) !!}
              {!!
              Form::select('type',['0'=>trans_choice('general.outstanding_p',1),'1'=>trans_choice('general.outstanding_p_i',1),'2'=>trans_choice('general.outstanding_p_i_f',1),'3'=>trans_choice('general.outstanding_total',1)],null,array('class'=>'form-control','required'=>'required'))
              !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">{{trans_choice('general.save',1)}}</button>
          <button type="button" class="btn default" data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="addGuarantor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">*</span></button>
          <h4 class="modal-title">{{trans_choice('general.add',1)}} {{trans_choice('general.guarantor',1)}}</h4>
        </div>
        {!! Form::open(array('url' => url('loan/'.$loan->id.'/guarantor/add'),'method'=>'post')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="form-line">
              {!! Form::label('guarantor_id',trans_choice('general.guarantor',1),array('class'=>' control-label')) !!}
              {!! Form::select('guarantor_id',$guarantors,null,array('class'=>'
              select2','required'=>'required','placeholder'=>'')) !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info">{{trans_choice('general.save',1)}}</button>
          <button type="button" class="btn default" data-dismiss="modal">{{trans_choice('general.close',1)}}</button>
        </div>
        {!! Form::close() !!}
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
  $("body").addClass('sidebar-xs');
  $('#withdrawSaving').on('shown.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var amount = $(e.relatedTarget).data('amount');
    var url = "{!!  url('loan/'.$loan->id.'/guarantor') !!}/" + id + "/withdraw";
    $(e.currentTarget).find("#withdrawSavingForm").attr('action', url);
    $(e.currentTarget).find("#accepted_amount").val(amount);
  });
  $('.deleteLoan').on('click', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    swal({
      title: '{{trans_choice('
      Estas seguro ? ',1)}}',
      text : '{{trans_choice('
      general.delete_loan_msg ',1)}}',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '{{trans_choice('
      Si ',1)}}',
      cancelButtonText: '{{trans_choice('
      No ',1)}}'
    }).then(function() {
      window.location = href;
    })
  });
  $('.deletePayment').on('click', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    swal({
      title: '{{trans_choice('
      Estas seguro ? ',1)}}',
      text : '{{trans_choice('
      general.delete_payment_msg ',1)}}',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '{{trans_choice('
      Si ',1)}}',
      cancelButtonText: '{{trans_choice('
      No ',1)}}'
    }).then(function() {
      window.location = href;
    })
  });
  $('.deleteComment').on('click', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    swal({
      title: '{{trans_choice('
      Estas seguro ? ',1)}}',
      text : '',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '{{trans_choice('
      Si ',1)}}',
      cancelButtonText: '{{trans_choice('
      No ',1)}}'
    }).then(function() {
      window.location = href;
    })
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