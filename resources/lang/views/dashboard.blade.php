@extends('layouts.master')
@section('title')
Tcobro Web | Dashboard
@endsection
@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="d-flex align-items-baseline flex-wrap mt-3">
      <h2 class="mr-4 mb-0">Dashboard</h2>
      <div class="d-flex align-items-baseline mt-2 mt-sm-0">
        <i class="fas fa-home mr-1 text-muted"></i>
        <i class="fas fa-chevron-right fa-xs mr-1 text-muted"></i>
        <p class="mb-0 mr-1">Dashboard</p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  @if(Sentinel::hasAccess('dashboard.registered_borrowers'))
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-around align-items-center">
          <div class="icon-rounded-primary">
            <i class="fas fa-users"></i>
          </div>
          <div>
            
              <h5  style="color:#22ae60;">Clientes activos</h5>
            
              <h5 class="mb-0">
                <?php
                $active_count = 0;
                foreach(\App\Models\Borrower::where('branch_id', Sentinel::getUser()->business_id)->get() as $key) {
                    if ($key->active == 1 && count($key->loans) > 0) {
                        $active_count++;
                    }
                }
              ?>
                <center>
                    {{ $active_count }} de
                    {{ \App\Models\Borrower::where('branch_id', Sentinel::getUser()->business_id)->count() }}
                </center>
              </h5>
       
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  
  <div class="col-md-3 grid-margin stretch-card">
  <?php
  $total = \App\Models\Loan::where('branch_id', Sentinel::getUser()->business_id)->count();
  $active = \App\Models\Loan::where('branch_id', Sentinel::getUser()->business_id)->where('status', 'disbursed')->count();
  ?>
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-around align-items-center">
          <div class="icon-rounded-primary">
            <i class="fas fa-user"></i>
          </div>
          <div>
            <center>
              <h5 style="color:#22ae60;">Pr&#232;stamos activos</h5>
            </center>            
            <center>
              <h5 class="mb-0">{{ $active }}<!---{{ $total }}---></h5>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>  

  @if(Sentinel::hasAccess('dashboard.total_collections'))
  <div class="col-md-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-around align-items-center">
          <div class="icon-rounded-primary">
              <i class="fas fa-dollar-sign"></i>
          </div>
          <div>
            <center>
              <h5 style="color:#22ae60;">Capital prestado</h5>
            </center>
            <center>
              <h5 class="mb-0">${{ number_format(\App\Helpers\GeneralHelper::loans_total_principal(),2) }}</h5>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  
  <div class="col-md-3 grid-margin stretch-card">
  <?php
  $total = \App\Models\LoanTransaction::where('branch_id', Sentinel::getUser()->business_id)->where('transaction_type', 'repayment')->where('reversed', 0)->sum('credit');
  ?>
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-around align-items-center">
          <div class="icon-rounded-primary">
            <i class="fas fa-dollar-sign"></i>
          </div>
          <div>
            <center>
              <h5 style="color:#22ae60;">Cuentas por cobrar</h5>
            </center>
    <?php
        $loan_total_pending_principal_cxp = 0;
         $loan_total_pending_interest_cxp = 0;
           $loan_total_pending_charge_cxp = 0;
          $loan_total_pending_penalty_cxp = 0;

        foreach(\App\Models\Loan::where('branch_id', Sentinel::getUser()->business_id)->get() as $loan) {
            $loan_total_nopaid_principal_cxp = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
            $loan_total_nopaid_interest_cxp = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
            $loan_total_nopaid_fee_cxp = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
            $loan_total_nopaid_penalty_cxp = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);
            
            $loan_total_paid_principal_cxp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_interest_cxp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Interest Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_charge_cxp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Fees Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_penalty_cxp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Penalty Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');            
            
            $loan_total_pending_principal_cxp = $loan_total_pending_principal_cxp + $loan_total_nopaid_principal_cxp - $loan_total_paid_principal_cxp;
             $loan_total_pending_interest_cxp = $loan_total_pending_interest_cxp + $loan_total_nopaid_interest_cxp - $loan_total_paid_interest_cxp;
               $loan_total_pending_charge_cxp = $loan_total_pending_charge_cxp + $loan_total_nopaid_fee_cxp - $loan_total_paid_charge_cxp;
              $loan_total_pending_penalty_cxp = $loan_total_pending_penalty_cxp + $loan_total_nopaid_penalty_cxp - $loan_total_paid_penalty_cxp;
              $loan_total_cxp_number = $loan_total_pending_principal_cxp + $loan_total_pending_interest_cxp + $loan_total_pending_charge_cxp + $loan_total_pending_penalty_cxp;
        }
    ?>
            <center>
              <h5 class="mb-0">
              ${{ number_format($loan_total_cxp_number,2) }}
              </h5>
            </center>            
          </div>
        </div>
      </div>
    </div>
  </div>  

  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-around align-items-center">
                    <!---
          <div class="icon-rounded-primary">
            <i class="fas fa-dollar-sign"></i>
          </div>--->     
          <div>
            <center>
              <h5 style="color:#22ae60;">Utilidad disponible</h5>
            </center>
            <center>
              <h5 style="color:#FF8C00;" class="mb-0">
              <?php
              
        $utilidad_total_disp = 0;

        foreach(\App\Models\Loan::where('branch_id', Sentinel::getUser()->business_id)->get() as $loan) {

            $loan_total_paid_interest_disp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Interest Repayment")->where('reversed', 0)->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_charge_disp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Fees Repayment")->where('reversed', 0)->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_penalty_disp = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Penalty Repayment")->where('reversed', 0)->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');            
            
            $gastos_totales = \App\Models\Expense::where('branch_id', Sentinel::getUser()->business_id)->sum('amount');
        
        $utilidad_total_disp = ($loan_total_paid_interest_disp + $loan_total_paid_charge_disp + $loan_total_paid_penalty_disp) - $gastos_totales;
        
        }
                
              ?>      
              ${{ number_format($utilidad_total_disp,2) }}              
              <!---{{ number_format($total,2) }}--->
              </h5>
            </center>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    $principal_interest = \App\Helpers\GeneralHelper::loans_total_due();
    $pagos_total = \App\Helpers\GeneralHelper::loans_total_paid();
    $deuda_total = abs($principal_interest - $pagos_total);
    ?>
  @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
  <div class="col-md-6 grid-margin stretch-card">    
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-around align-items-center">
                <!---
          <div class="icon-rounded-primary">
            <i class="fas fa-dollar-sign"></i>
          </div>   --->        
          <div>
            <center>
              <h5 style="color:#22ae60;">Capital disponible</h5>
            </center>
            
            @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
            <center>
              <!---<h5 class="mb-0">${{ number_format($deuda_total,2) }}</h5>--->
              <h5 class="mb-0" style="color:#00008B;"><?php
              
        foreach(\App\Models\Loan::where('branch_id', Sentinel::getUser()->business_id)->get() as $loan) {
            $loan_total_paid_principal_v2 = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');

                $value = \App\Models\Capital::where('branch_id', Sentinel::getUser()->business_id)->sum('amount');
                $abc = \App\Helpers\GeneralHelper::loans_total_principal();
                $abc_2 = 0;
                // CAPITAL RETORNADO
                $valu_2 = ($value - $abc) + $loan_total_paid_principal_v2;
        }
        

              ?>
              ${{ number_format($valu_2,2) }}
              </h5>
            </center>
            @else
            <center>
              <!---<h5 class="mb-0">${{ number_format($deuda_total,2) }}</h5>--->
              <h5 class="mb-0"><?php
                $value = \App\Models\Capital::where('branch_id', Sentinel::getUser()->business_id)->sum('amount');
              ?>
              ${{ number_format($value,2) }}
              </h5>              
            </center>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>


<div class="row">
  <div class="col-lg-7 col-xl-6 grid-margin stretch-card">
    <div class="card overflow-hidden">
    <?php
        $loan_total_pending_principal = 0;
        $loan_total_pending_interest = 0;
        $loan_total_pending_charge = 0;
        $loan_total_pending_penalty = 0;

        foreach(\App\Models\Loan::where('branch_id', Sentinel::getUser()->business_id)->get() as $loan) {
            $loan_total_nopaid_principal = \App\Helpers\GeneralHelper::loan_total_principal($loan->id);
            $loan_total_nopaid_interest = \App\Helpers\GeneralHelper::loan_total_interest($loan->id);
            $loan_total_nopaid_fee = \App\Helpers\GeneralHelper::loan_total_fees($loan->id);
            $loan_total_nopaid_penalty = \App\Helpers\GeneralHelper::loan_total_penalty($loan->id);

            $loan_total_paid_principal = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Principal Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_interest = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Interest Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_charge = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Fees Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            $loan_total_paid_penalty = \App\Models\JournalEntry::where('loan_id', $loan->id)->where('name', "Penalty Repayment")->where('debit','=',NULL)->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');            
            
            $loan_total_pending_principal = $loan_total_pending_principal + $loan_total_nopaid_principal - $loan_total_paid_principal;
            $loan_total_pending_interest = $loan_total_pending_interest + $loan_total_nopaid_interest - $loan_total_paid_interest;
            $loan_total_pending_charge = $loan_total_pending_charge + $loan_total_nopaid_fee - $loan_total_paid_charge;
            $loan_total_pending_penalty = $loan_total_pending_penalty + $loan_total_nopaid_penalty - $loan_total_paid_penalty;
        }
        $cobrar = [];
        $cobrar[] = $loan_total_pending_principal;
        $cobrar[] = $loan_total_pending_interest;
        $cobrar[] = $loan_total_pending_charge;
        $cobrar[] = $loan_total_pending_penalty;
    ?>
      <div id="downloadsCarousel" class="carousel slide card-carousel downloads-carousel position-static"
        data-ride="carousel">
        <div class="carousel-innter">
          <div class="carousel-item active">
            <div class="card-body">
              <h4 style="color:#262261;" class="card-title" style="color:#22ae60;">Cuentas por cobrar</h4>
              <canvas id="pieChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7 col-xl-6 grid-margin stretch-card">
    <div class="card overflow-hidden">
    <?php
        $prestamo = [];
        $labels = [];        
        // if (\App\Models\Loan::where('status', 'pending')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
        //     $prestamo[] = \App\Models\Loan::where('status', 'pending')->where('branch_id', Sentinel::getUser()->business_id)->count();
        //     $labels[] = 'Pendientes';
        // }
        // if (\App\Models\Loan::where('status', 'approved')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
        //     $prestamo[] = \App\Models\Loan::where('status', 'approved')->where('branch_id', Sentinel::getUser()->business_id)->count();
        //     $labels[] = 'Aprobado';
        // }
        if (\App\Models\Loan::where('status', 'disbursed')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
            $prestamo[] = \App\Models\Loan::where('status', 'disbursed')->where('branch_id', Sentinel::getUser()->business_id)->count();
            $labels[] = 'Desembolsados';
        }
        // if (\App\Models\Loan::where('status', 'rescheduled')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
        //     $prestamo[] = \App\Models\Loan::where('status', 'rescheduled')->where('branch_id', Sentinel::getUser()->business_id)->count();
        //     $labels[] = 'Reprogramados';
        // }
        if (\App\Models\Loan::where('status', 'written_off')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
            $prestamo[] = \App\Models\Loan::where('status', 'written_off')->where('branch_id', Sentinel::getUser()->business_id)->count();
            $labels[] = 'Perdidas';
        }
        // if (\App\Models\Loan::where('status', 'declined')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
        //     $prestamo[] = \App\Models\Loan::where('status', 'declined')->where('branch_id', Sentinel::getUser()->business_id)->count();
        //     $labels[] = 'Declinado';
        // }
        if (\App\Models\Loan::where('status', 'closed')->where('branch_id', Sentinel::getUser()->business_id)->count() != 0) {
            $prestamo[] = \App\Models\Loan::where('status', 'closed')->where('branch_id', Sentinel::getUser()->business_id)->count();
            $labels[] = 'Cerrados';
        }        
      ?>
      <div id="downloadsCarousel" class="carousel slide card-carousel downloads-carousel position-static"
        data-ride="carousel">
        <div class="carousel-innter">
          <div class="carousel-item active">
            <div class="card-body">
              <h4 style="color:#262261;" class="card-title">Estatus de prestamo</h4>
              <canvas id="doughnutChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-7 col-xl-6 grid-margin stretch-card">
    <div class="card overflow-hidden">
    <?php
        $date = date('Y-m-d');
        $dt = explode('-', $date);        
        $year = $dt[0];
        $areaChartValues = [];

        for($i = 1; $i < 13; $i++) {
            $data = \App\Models\LoanTransaction::where('transaction_type',
            'repayment')->where('reversed', 0)->where('branch_id', Sentinel::getUser()->business_id)->where('year',
            $year)->where('month', $i)->get();

            $total_principal = 0;
            $total_fees = 0;
            $total_interest = 0;
            $total_penalty = 0;
            $total_total = 0;

            foreach($data as $key) {
                $principal = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Principal Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
                
                $interest = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Interest Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');

                $fees = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Fees Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');

                $penalty = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Penalty Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
                
                $total_payment = \App\Models\LoanTransaction::where('id', $key->id)->where('reversed', 0)->where('transaction_type', "repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
                
                
                
                $total_principal = $total_principal + $principal;
                $total_interest = $total_interest + $interest;
                $total_fees = $total_fees + $fees;
                $total_penalty = $total_penalty + $penalty;                
            }
            $total_total = $total_interest + $total_penalty + $total_fees;
            $areaChartValues[] = $total_total;
        }                    
    ?>
      <div id="downloadsCarousel" class="carousel slide card-carousel downloads-carousel position-static"
        data-ride="carousel">
        <div class="carousel-innter">
          <div class="carousel-item active">
            <div class="card-body">
              <h4 style="color:#262261;" class="card-title">Utilidad por mes</h4>
              <canvas id="areaChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-7 col-xl-6 grid-margin stretch-card">
    <div class="card overflow-hidden">
    <?php
        $date = date('Y-m-d');
        $dt = explode('-', $date);        
        $c_year = $dt[0];
        $c_month = $dt[1];
        $barChartValues = [];
        $barChartLabels = [];
        $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        for($i = $c_month - 5; $i < $c_month + 1; $i++) {
            if ($i <= 0) {
                $month = $i + 12;
                $year = $c_year - 1;
            } else {
                $month = $i;
                $year = $c_year;
            }
            $data = \App\Models\Expense::where('branch_id', Sentinel::getUser()->business_id)->where('month', $month)->where('year', $year)->sum('amount');
            $barChartLabels[] = $months[$month - 1];
            $barChartValues[] = $data;
        }        
    ?>
      <div id="downloadsCarousel" class="carousel slide card-carousel downloads-carousel position-static"
        data-ride="carousel">
        <div class="carousel-innter">
          <div class="carousel-item active">
            <div class="card-body">
              <h4 style="color:#262261;" class="card-title">Gastos por mes</h4>
              <canvas id="barChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!---
  @if(Sentinel::hasAccess('dashboard.loans_collected_monthly_graph'))
  <div class="col-lg-7 col-xl-12 grid-margin stretch-card">
    <div class="card overflow-hidden">
      <div id="downloadsCarousel" class="carousel slide card-carousel downloads-carousel position-static"
        data-ride="carousel">
        <div class="carousel-innter">
          <div class="carousel-item active">
            <div class="card-body">
              <h4 style="color:#262261;" class="card-title">Capital desembolsado por mes</h4>              
              <div class="panel-body  no-padding">                
                <div id="monthly_disbursed_loans_data" class="chart" style="height: 420px;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif--->
</div>






<!-- GRAFICA PIE -->
<div class="row">
  <!-- @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
  <div class="col-md-4">
    <div class="panel panel-flat">
      <div class="panel-body">
        <div class="list-group no-border no-padding-top bg-danger-400">
          @foreach(json_decode($loan_statuses) as $key)
          <a href="{{$key->link}}" class="list-group-item">
            <span class="pull-right"><strong>{{$key->value}}</strong></span>
            <strong>{{$key->label}}</strong>
          </a>
          @endforeach
        </div>
        <center>
          <canvas id="loan_status_pie" height="334"></canvas>
        </center>
      </div>
    </div>
  </div>
  @endif -->


  <!-- <div class="col-md-8">
    @if(Sentinel::hasAccess('dashboard.loans_collected_monthly_graph'))
    <div class="panel panel-flat">
      <div class="panel-heading">
        <center>
          <h2 class="panel-title">Tendencia de Pagos por Mes</h2>
        </center>
        <div class="heading-elements">
        </div>
      </div>

      <div class="panel-body">
        <div id="monthly_actual_expected_data" class="chart" style="height: 320px;">
        </div>
      </div>
    </div>
    @endif

    @if(Sentinel::hasAccess('dashboard.loans_disbursed'))    
    <div class="panel panel-flat">
      <div class="panel-heading">
        <center>
          <h2 class="panel-title">Seguimiento a cobranza</h2>
        </center>
        <div class="heading-elements">
        </div>
      </div>
      <div class="panel-body">
        <?php
            $target = 0;
            foreach (\App\Models\LoanSchedule::where('year', date("Y"))->where('month',
                date("m"))->get() as $key) {
                $target = $target + $key->principal + $key->interest + $key->fees + $key->penalty;
            }
            $paid_this_month = \App\Models\LoanTransaction::where('transaction_type','repayment')->where('reversed', 0)->where('year',date("Y"))->where('month',date("m"))->sum('credit');

            $paid_this_year = \App\Models\LoanTransaction::where('transaction_type','repayment')->where('reversed', 0)->where('year',date("Y"))->sum('credit');
                
            $paid_this_now = \App\Models\LoanTransaction::where('transaction_type','repayment')->where('reversed', 0)->where('date',date("Y-m-d"))->sum('credit');
        
            if ($target > 0) {
                $percent = round(($paid_this_month / $target) * 100);
            } else {
                $percent = 0;
            }

            ?>
        <div class="container-fluid">
          <div class="row text-center">
            <div class="col-md-4">
              <div class="content-group">
                @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                <h3 class="text-semibold no-margin">{{ number_format($paid_this_now,2) }}</h3>
                @else
                <h3 class="text-semibold no-margin">{{ number_format($paid_this_now,2) }}</h3>
                @endif

                <h5 class="text-semibold no-margin">Cobrado hoy</h5>
              </div>
            </div>

            <div class="col-md-4">
              <div class="content-group">
                @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                <h3 class="text-semibold no-margin">{{ number_format($paid_this_month,2) }} </h3>
                @else
                <h3 class="text-semibold no-margin">{{ number_format($paid_this_month,2) }}</h3>
                @endif
                <h5 class="text-semibold no-margin">Cobrado en el mes</h5>
              </div>
            </div>

            <div class="col-md-4">
              <div class="content-group">
                @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                <h3 class="text-semibold no-margin">
                  {{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }} </h3>
                @else
                <h3 class="text-semibold no-margin">
                  {{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }} </h3>
                @endif
                <h5 class="text-semibold no-margin">Cobrado en el año</h5>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="text-center">
                <h6 class="no-margin text-semibold bg-primary">Lo cobrado en este mes equivale al {{$percent}}% de
                  cobranza total del mes.</h6>
              </div>
              <div class="progress" data-toggle="tooltip">

                <div class="progress-bar bg-teal progress-bar-striped active" style="width: {{$percent}}%">
                  <span>{{$percent}}% Completado</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div> -->

</div>



<script>
$(document).ready(function() {
  $("body").addClass('sidebar-xs');
});
</script>

<script src="{{ asset('assets/plugins/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/amcharts/themes/light.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/amcharts/plugins/export/export.min.js') }}" type="text/javascript"></script>

<!-- <script>
AmCharts.makeChart("monthly_actual_expected_data", {
  "type": "serial",
  "theme": "light",
  "autoMargins": true,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "fontFamily": 'Open Sans',
  "color": '#888',

  "dataProvider": JSON.parse(<?php echo json_encode($monthly_actual_expected_data)?>),
  "valueAxes": [{
    "axisAlpha": 0,

  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<span style='font-size:20px;'>[[title]] en el mes [[category]]:<b> $[[value]]</b> [[additional]]</span>",
    "bullet": "round",
    "bulletSize": 10,
    "lineColor": "#0DD102",
    "lineThickness": 3,
    "negativeLineColor": "#0dd102",
    "title": "Pagos Recibidos",
    "type": "smoothedLine",
    "valueField": "actual"
  }, {
    "balloonText": "<span style='font-size:20px;'>[[title]] en el mes [[category]]:<b> $[[value]]</b> [[additional]]</span>",
    "bullet": "round",
    "bulletSize": 10,
    "lineColor": "#ADADAD",
    "lineThickness": 3,
    "negativeLineColor": "#ADADAD",
    "title": "Pagos esperados",
    "type": "smoothedLine",
    "valueField": "expected"
  }],
  "categoryField": "month",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0,
    "labelRotation": 30,

  },
  "export": {
    "enabled": true,
    "libs": {
      "path": "{{asset('assets/plugins/amcharts/plugins/export/libs')}}/"
    }
  },
  "legend": {
    "position": "bottom",
    "marginRight": 100,
    "autoMargins": true
  },
});
</script> -->

<script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>
<script>
// var ctx3 = document.getElementById("loan_status_pie").getContext("2d");
// var data3 = <?php echo $loan_statuses ?>;
// var myBarChart = new Chart(ctx3).Pie(data3, {
//   type: 'pie',
//   segmentShowStroke: true,
//   segmentStrokeColor: "#fff",
//   segmentStrokeWidth: 0,
//   animationSteps: 100,
//   tooltipCornerRadius: 0,
//   animationEasing: "linear",
//   animateRotate: true,
//   animateScale: true,
//   responsive: true,

//   legend: {
//     display: true,
//     labels: {
//       fontColor: 'rgb(255, 99, 132)'
//     }
//   }
// });
console.log(JSON.parse(<?php echo json_encode($monthly_disbursed_loans_data)?>));
AmCharts.makeChart("monthly_disbursed_loans_data", {
  "type": "serial",
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "fontFamily": 'Open Sans',
  "color": '#888',

  "dataProvider": JSON.parse(<?php echo json_encode($monthly_disbursed_loans_data)?>),
  "valueAxes": [{
    "axisAlpha": 0,
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<span style='font-size:20px;'>[[title]] en el mes de [[category]]: $<b>[[value]]</b> [[additional]]</span>",
    "lineColor": "#05a8f559",
    "fillAlphas": 1,
    "borderColor": "#000000",
    "negativeLineColor": "#000000",
    "title": "{{trans_choice('general.principal',1)}}",
    "type": "column",
    "valueField": "value",
  }],
  "categoryField": "month",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0,
    "labelRotation": 30,
  },
  "export": {
    "enabled": true,
    "libs": {
      "path": "{{asset('assets/plugins/amcharts/plugins/export/libs')}}/"
    }
  }
});
</script>


<script>
$(function() {
  /* ChartJS
   * -------
   * Data and config for chartjs
   */
  'use strict';
  
  var data = {
    labels: <?php echo json_encode($barChartLabels)?>,
    datasets: [{
      label: '# of Votes',
      data: <?php echo json_encode($barChartValues)?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };
  var multiLineData = {
    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    datasets: [{
        label: 'Dataset 1',
        data: [12, 19, 3, 5, 2, 3],
        borderColor: [
          '#587ce4'
        ],
        borderWidth: 2,
        fill: false
      },
      {
        label: 'Dataset 2',
        data: [5, 23, 7, 12, 42, 23],
        borderColor: [
          '#ede190'
        ],
        borderWidth: 2,
        fill: false
      },
      {
        label: 'Dataset 3',
        data: [15, 10, 21, 32, 12, 33],
        borderColor: [
          '#f44252'
        ],
        borderWidth: 2,
        fill: false
      }
    ]
  };
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };
  
  var doughnutPieData = {
    datasets: [{
      data: <?php echo json_encode($cobrar)?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
      'Capital',
      'Interes',
      'Cargos',
      'Mora'
    ]
  };
  var doughnutData = {
    datasets: [{
      data: <?php echo json_encode($prestamo)?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',
        '#d800ff3b'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        '#d800fffa'
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs $labels
    labels: <?php echo json_encode($labels)?>
  };
  var doughnutPieOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };
  
  var areaData = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    datasets: [{
      label: 'Ingresos Por Mes',
      data: <?php echo json_encode($areaChartValues)?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(155, 139, 14, 0.2)',
        'rgba(115, 19, 64, 0.2)',
        'rgba(205, 159, 84, 0.2)',
        'rgba(55, 129, 104, 0.2)',
        'rgba(175, 111, 24, 0.2)',
        'rgba(25, 199, 154, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(155, 139, 14, 1)',
        'rgba(115, 19, 64, 1)',
        'rgba(205, 159, 84, 1)',
        'rgba(55, 129, 104, 1)',
        'rgba(175, 111, 24, 1)',
        'rgba(25, 199, 154, 1)'
      ],
      borderWidth: 1,
      fill: true, // 3: no fill
    }]
  };

  var areaOptions = {
    plugins: {
      filler: {
        propagate: true
      }
    }
  }

  var multiAreaData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: 'Facebook',
        data: [8, 11, 13, 15, 12, 13, 16, 15, 13, 19, 11, 14],
        borderColor: ['rgba(255, 99, 132, 0.5)'],
        backgroundColor: ['rgba(255, 99, 132, 0.5)'],
        borderWidth: 1,
        fill: true
      },
      {
        label: 'Twitter',
        data: [7, 17, 12, 16, 14, 18, 16, 12, 15, 11, 13, 9],
        borderColor: ['rgba(54, 162, 235, 0.5)'],
        backgroundColor: ['rgba(54, 162, 235, 0.5)'],
        borderWidth: 1,
        fill: true
      },
      {
        label: 'Linkedin',
        data: [6, 14, 16, 20, 12, 18, 15, 12, 17, 19, 15, 11],
        borderColor: ['rgba(255, 206, 86, 0.5)'],
        backgroundColor: ['rgba(255, 206, 86, 0.5)'],
        borderWidth: 1,
        fill: true
      }
    ]
  };

  var multiAreaOptions = {
    plugins: {
      filler: {
        propagate: true
      }
    },
    elements: {
      point: {
        radius: 0
      }
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        }
      }]
    }
  }

  var scatterChartData = {
    datasets: [{
        label: 'First Dataset',
        data: [{
            x: -10,
            y: 0
          },
          {
            x: 0,
            y: 3
          },
          {
            x: -25,
            y: 5
          },
          {
            x: 40,
            y: 5
          }
        ],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)'
        ],
        borderWidth: 1
      },
      {
        label: 'Second Dataset',
        data: [{
            x: 10,
            y: 5
          },
          {
            x: 20,
            y: -30
          },
          {
            x: -25,
            y: 15
          },
          {
            x: -10,
            y: 5
          }
        ],
        backgroundColor: [
          'rgba(54, 162, 235, 0.2)',
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
        ],
        borderWidth: 1
      }
    ]
  }

  var scatterChartOptions = {
    scales: {
      xAxes: [{
        type: 'linear',
        position: 'bottom'
      }]
    }
  }
  // Get context with jQuery - using jQuery's .get() method.
  if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
  }

//   if ($("#lineChart").length) {
//     var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
//     var lineChart = new Chart(lineChartCanvas, {
//       type: 'line',
//       data: data,
//       options: options
//     });
//   }

//   if ($("#linechart-multi").length) {
//     var multiLineCanvas = $("#linechart-multi").get(0).getContext("2d");
//     var lineChart = new Chart(multiLineCanvas, {
//       type: 'line',
//       data: multiLineData,
//       options: options
//     });
//   }

//   if ($("#areachart-multi").length) {
//     var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");
//     var multiAreaChart = new Chart(multiAreaCanvas, {
//       type: 'line',
//       data: multiAreaData,
//       options: multiAreaOptions
//     });
//   }

  if ($("#doughnutChart").length) {
    var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: doughnutData,
      options: doughnutPieOptions
    });
  }

  if ($("#pieChart").length) {
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }

  if ($("#areaChart").length) {
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    var areaChart = new Chart(areaChartCanvas, {
      type: 'line',
      data: areaData,
      options: areaOptions
    });
  }

//   if ($("#scatterChart").length) {
//     var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
//     var scatterChart = new Chart(scatterChartCanvas, {
//       type: 'scatter',
//       data: scatterChartData,
//       options: scatterChartOptions
//     });
//   }

//   if ($("#browserTrafficChart").length) {
//     var doughnutChartCanvas = $("#browserTrafficChart").get(0).getContext("2d");
//     var doughnutChart = new Chart(doughnutChartCanvas, {
//       type: 'doughnut',
//       data: browserTrafficData,
//       options: doughnutPieOptions
//     });
//   }
});
</script>



<script src="{{ asset('assets/new_theme/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/new_theme/js/chart.js') }}"></script>

@endsection