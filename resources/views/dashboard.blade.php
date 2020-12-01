@extends('layouts.master')
@section('title')
   Tablero Principal
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
                    <center><h5>Clientes activos</h5></center>
                    <center><h5 class="mb-0">{{ \App\Models\Borrower::count() }} de {{ \App\Models\Borrower::count() }}</h5></center>
                </div>
                </div>
            </div>
            </div>
        </div>
        @endif

        @if(Sentinel::hasAccess('dashboard.total_loans_released'))
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-around align-items-center">
                    <div class="icon-rounded-primary">
                      <i class="fab fa-leanpub"></i>
                    </div>
                    <div>
                        <center><h5>Capital total prestado</h5></center>
                        @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                            <center><h5 class="mb-0">${{ number_format(\App\Helpers\GeneralHelper::loans_total_principal(),2) }}</h5></center>
                        @else                            
                            <center><h5 class="mb-0">${{ number_format(\App\Helpers\GeneralHelper::loans_total_principal(),2) }}</h5></center>
                        @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>            
        @endif

        @if(Sentinel::hasAccess('dashboard.total_collections'))
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-around align-items-center">
                    <div class="icon-rounded-primary">
                      <i class="fas fa-landmark"></i>
                    </div>
                    <div>                        
                        <center><h5>Pagos Recibidos</h5></center>
                        @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                            <center><h5 class="mb-0">${{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }}</h5></center>
                        @else
                            <center><h5 class="mb-0">$0.00</h5></center>                            
                        @endif                        
                    </div>
                  </div>
                </div>
              </div>
            </div>            
        @endif
        <?php
        $principal_interest = \App\Helpers\GeneralHelper::loans_total_due();
        $pagos_total = \App\Helpers\GeneralHelper::loans_total_paid();
        $deuda_total = abs($principal_interest - $pagos_total);
        ?>
        @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-around align-items-center">
                    <div class="icon-rounded-primary">
                      <i class="fas fa-money-bill"></i>
                    </div>
                    <div>                        
                        <center><h5>Deuda Total</h5></center>
                        @if(\App\Models\Setting::where('setting_key', 'currency_position')->first()->setting_value=='left')
                            <center><h5 class="mb-0">${{ number_format($deuda_total,2) }}</h5></center>
                        @else
                            <center><h5 class="mb-0">${{ number_format($deuda_total,2) }}</h5></center>
                        @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>            
        @endif
    </div>
    
    <!-- GRAFICA PIE -->
    <div class="row">
        @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
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
            @endif
            
            
        <div class="col-md-8">

            @if(Sentinel::hasAccess('dashboard.loans_collected_monthly_graph'))
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <center><h2 class="panel-title">Tendencia de Pagos por Mes</h2></center>
                        <div class="heading-elements">
                            <!---<ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                            </ul>--->
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="monthly_actual_expected_data" class="chart" style="height: 320px;">
                        </div>
                    </div>
                </div>
            @endif
            
        @if(Sentinel::hasAccess('dashboard.loans_disbursed'))
            <!-- Sales stats -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <center>
                        <h2 class="panel-title">Seguimiento a cobranza</h2></center>
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
                                            <h3 class="text-semibold no-margin">{{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }} </h3>
                                        @else
                                            <h3 class="text-semibold no-margin">{{ number_format(\App\Helpers\GeneralHelper::loans_total_paid(),2) }} </h3>
                                        @endif
                                        <h5 class="text-semibold no-margin">Cobrado en el año</h5>
                                    </div>
                                </div>



                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <h6 class="no-margin text-semibold bg-primary">Lo cobrado en este mes equivale al {{$percent}}% de cobranza total del mes.</h6>
                                    </div>
                                    <div class="progress" data-toggle="tooltip">

                                        <div class="progress-bar bg-teal progress-bar-striped active"
                                             style="width: {{$percent}}%">
                                            <span>{{$percent}}% Completado</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif            
 </div>
 
 </div>
 @if(Sentinel::hasAccess('dashboard.loans_collected_monthly_graph'))
  <div class="panel panel-white">
                <div class="panel-heading">
                    <h2 class="panel-title">Capital Desembolsado por Mes</h2>

                    <div class="heading-elements">

                    </div>
                </div>
                <div class="panel-body  no-padding">
                    <div id="monthly_disbursed_loans_data" class="chart" style="height: 420px;">
                    </div>
                </div>
            </div>
@endif            


<script>
        $(document).ready(function () {
            $("body").addClass('sidebar-xs');
        });
    </script>

    <script src="{{ asset('assets/plugins/amcharts/amcharts.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/serial.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/pie.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/themes/light.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/amcharts/plugins/export/export.min.js') }}"
            type="text/javascript"></script>
            
    <script>   
    
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

            "dataProvider": {!! $monthly_actual_expected_data !!},
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

            }, "export": {
                "enabled": true,
                "libs": {
                    "path": "{{asset('assets/plugins/amcharts/plugins/export/libs')}}/"
                }
            }, "legend": {
                "position": "bottom",
                "marginRight": 100,
                "autoMargins": true
            },


        });
  
    </script>
     
         <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"
            type="text/javascript"></script>
    <script>
        var ctx3 = document.getElementById("loan_status_pie").getContext("2d");
        var data3 ={!! $loan_statuses !!};
        var myBarChart = new Chart(ctx3).Pie(data3, {
            type: 'pie',
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 0,
            animationSteps: 100,
            tooltipCornerRadius: 0,
            animationEasing: "linear",
            animateRotate: true,
            animateScale: true,
            responsive: true,

            legend: {
                display: true,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }
            }
        });
        
        AmCharts.makeChart("monthly_disbursed_loans_data", {
            "type": "serial",
//            "theme": "light",
//            "autoMargins": true,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "fontFamily": 'Open Sans',
            "color": '#888',

            "dataProvider": {!! $monthly_disbursed_loans_data !!},
            "valueAxes": [{
                "axisAlpha": 0,

            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<span style='font-size:20px;'>[[title]] en el mes de [[category]]: $<b>[[value]]</b> [[additional]]</span>",
                "lineColor": "#1d81cf",
                "fillAlphas": 1,
                "negativeLineColor": "#1d81cf",
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

            }, "export": {
                "enabled": true,
                "libs": {
                    "path": "{{asset('assets/plugins/amcharts/plugins/export/libs')}}/"
                }
            }


        });
        
    </script>
   
    
@endsection
