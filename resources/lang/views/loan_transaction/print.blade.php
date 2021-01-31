<style>
    thead {
        display: table-header-group;
    }

    .table {
        border-collapse: collapse !important;
    }

    .table td,
    .table th {
        background-color: #fff !important;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd !important;
    }

    th {
        text-align: left;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    .table > thead > tr > th,
    .table > tbody > tr > th,
    .table > tfoot > tr > th,
    .table > thead > tr > td,
    .table > tbody > tr > td,
    .table > tfoot > tr > td {
        padding: 0 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        border: none;
    }

    .table > thead > tr > th {
        vertical-align: bottom;
        border-bottom: 2px solid #ddd;
    }

    .table > caption + thead > tr:first-child > th,
    .table > colgroup + thead > tr:first-child > th,
    .table > thead:first-child > tr:first-child > th,
    .table > caption + thead > tr:first-child > td,
    .table > colgroup + thead > tr:first-child > td,
    .table > thead:first-child > tr:first-child > td {
        border-top: 0;
    }

    .table > tbody + tbody {
        border-top: 2px solid #ddd;
    }

    .table .table {
        background-color: #fff;
    }

    .table-condensed > thead > tr > th,
    .table-condensed > tbody > tr > th,
    .table-condensed > tfoot > tr > th,
    .table-condensed > thead > tr > td,
    .table-condensed > tbody > tr > td,
    .table-condensed > tfoot > tr > td {
        padding: 5px;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td {
        border: 1px solid #ddd;
    }

    .table-bordered > thead > tr > th,
    .table-bordered > thead > tr > td {
        border-bottom-width: 2px;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-hover > tbody > tr:hover {
        background-color: #f5f5f5;
    }

    table col[class*="col-"] {
        position: static;
        display: table-column;
        float: none;
    }

    table td[class*="col-"],
    table th[class*="col-"] {
        position: static;
        display: table-cell;
        float: none;
    }

    .table > thead > tr > td.active,
    .table > tbody > tr > td.active,
    .table > tfoot > tr > td.active,
    .table > thead > tr > th.active,
    .table > tbody > tr > th.active,
    .table > tfoot > tr > th.active,
    .table > thead > tr.active > td,
    .table > tbody > tr.active > td,
    .table > tfoot > tr.active > td,
    .table > thead > tr.active > th,
    .table > tbody > tr.active > th,
    .table > tfoot > tr.active > th {
        background-color: #f5f5f5;
    }

    .table-hover > tbody > tr > td.active:hover,
    .table-hover > tbody > tr > th.active:hover,
    .table-hover > tbody > tr.active:hover > td,
    .table-hover > tbody > tr:hover > .active,
    .table-hover > tbody > tr.active:hover > th {
        background-color: #e8e8e8;
    }

    .table > thead > tr > td.success,
    .table > tbody > tr > td.success,
    .table > tfoot > tr > td.success,
    .table > thead > tr > th.success,
    .table > tbody > tr > th.success,
    .table > tfoot > tr > th.success,
    .table > thead > tr.success > td,
    .table > tbody > tr.success > td,
    .table > tfoot > tr.success > td,
    .table > thead > tr.success > th,
    .table > tbody > tr.success > th,
    .table > tfoot > tr.success > th {
        background-color: #dff0d8;
    }

    .table-hover > tbody > tr > td.success:hover,
    .table-hover > tbody > tr > th.success:hover,
    .table-hover > tbody > tr.success:hover > td,
    .table-hover > tbody > tr:hover > .success,
    .table-hover > tbody > tr.success:hover > th {
        background-color: #d0e9c6;
    }

    .table > thead > tr > td.info,
    .table > tbody > tr > td.info,
    .table > tfoot > tr > td.info,
    .table > thead > tr > th.info,
    .table > tbody > tr > th.info,
    .table > tfoot > tr > th.info,
    .table > thead > tr.info > td,
    .table > tbody > tr.info > td,
    .table > tfoot > tr.info > td,
    .table > thead > tr.info > th,
    .table > tbody > tr.info > th,
    .table > tfoot > tr.info > th {
        background-color: #d9edf7;
    }

    .table-hover > tbody > tr > td.info:hover,
    .table-hover > tbody > tr > th.info:hover,
    .table-hover > tbody > tr.info:hover > td,
    .table-hover > tbody > tr:hover > .info,
    .table-hover > tbody > tr.info:hover > th {
        background-color: #c4e3f3;
    }

    .table > thead > tr > td.warning,
    .table > tbody > tr > td.warning,
    .table > tfoot > tr > td.warning,
    .table > thead > tr > th.warning,
    .table > tbody > tr > th.warning,
    .table > tfoot > tr > th.warning,
    .table > thead > tr.warning > td,
    .table > tbody > tr.warning > td,
    .table > tfoot > tr.warning > td,
    .table > thead > tr.warning > th,
    .table > tbody > tr.warning > th,
    .table > tfoot > tr.warning > th {
        background-color: #fcf8e3;
    }

    .table-hover > tbody > tr > td.warning:hover,
    .table-hover > tbody > tr > th.warning:hover,
    .table-hover > tbody > tr.warning:hover > td,
    .table-hover > tbody > tr:hover > .warning,
    .table-hover > tbody > tr.warning:hover > th {
        background-color: #faf2cc;
    }

    .table > thead > tr > td.danger,
    .table > tbody > tr > td.danger,
    .table > tfoot > tr > td.danger,
    .table > thead > tr > th.danger,
    .table > tbody > tr > th.danger,
    .table > tfoot > tr > th.danger,
    .table > thead > tr.danger > td,
    .table > tbody > tr.danger > td,
    .table > tfoot > tr.danger > td,
    .table > thead > tr.danger > th,
    .table > tbody > tr.danger > th,
    .table > tfoot > tr.danger > th {
        background-color: #f2dede;
    }

    .table-hover > tbody > tr > td.danger:hover,
    .table-hover > tbody > tr > th.danger:hover,
    .table-hover > tbody > tr.danger:hover > td,
    .table-hover > tbody > tr:hover > .danger,
    .table-hover > tbody > tr.danger:hover > th {
        background-color: #ebcccc;
    }

    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }

    .row {
        margin-right: -15px;
        margin-left: -15px;
        clear: both;
    }

    .col-md-6 {
        width: 50%;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .well {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
    }

    tbody:before, tbody:after {
        display: none;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .text-justify {
        text-align: justify;
    }

    .pull-right {
        float: right !important;
    }

    h3, h4 {
        margin: 0;
        font-weight: normal;
    }
    h2 {
        margin: 5px 0;
    }
    @media print {
        body {
            width: 390px;
            height: 400px;
        }        
    }
</style>


<div id="print_section">
    <!-- <h3 class="text-center">
        @if(!empty(\App\Models\Setting::where('setting_key','company_logo')->first()->setting_value))
            <img src="{{ url(asset('uploads/'.\App\Models\Setting::where('setting_key','company_logo')->first()->setting_value)) }}" class="img-responsive" width="150"/>

        @endif
    </h3> -->
    <h2 class="text-center"><b>{{\App\Models\Setting::where('setting_key','company_name')->first()->setting_value}}</b></h2>
    <h4 class="text-center">{{\App\Models\Setting::where('setting_key','company_address')->first()->setting_value}}</h4>
    <br>
    <h3 class="text-left"><b>{{$loan_transaction->borrower->title}}. {{$loan_transaction->borrower->first_name}} {{$loan_transaction->borrower->last_name}}</b></h3>
    <h4 class="text-left">ID <b>{{$loan_transaction->loan_id}}</b></h4>

    <div style="margin-top: 20px; margin-left: auto; margin-right: auto; text-transform: capitalize; clear: both; border-top: 2px dashed gray;">
        <table class="table">
            <tr>
                <td style="border-bottom: 2px dashed gray;"><h2>Pago</h2></td>
                <td class="text-right" style="border-bottom: 2px dashed gray;">
                    <h2>
                        @if($loan_transaction->credit>$loan_transaction->debit)
                            ${{number_format($loan_transaction->credit,2)}}
                        @else
                            ${{number_format($loan_transaction->debit,2)}}
                        @endif
                    </h2>
                </td>                
            </tr>
            
            <tr>
                <td><h3><span>Nuevo Saldo</span></h3></td>
                <td class="text-right"><h3>${{number_format(\App\Helpers\GeneralHelper::loan_total_balance($loan_transaction->loan_id),2)}}</h3></td>
            </tr>
            <tr>
                <td style="border-bottom: 2px dashed gray;"><h3><span>Balance de mora</span></h3></td>
                <td class="text-right" style="border-bottom: 2px dashed gray;">
                <h3>
                @php
                    $loan_data = \App\Models\Loan::where('branch_id', session('branch_id'))->where('id', $loan_transaction->loan_id)->first();
                    $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($loan_transaction->loan_id, $loan_data['release_date'], date("Y-m-d"));

                    $original_date = $loan_data['release_date'];            
                    $fecha_de_desembolso = date("d-m-Y", strtotime($original_date));

                    $balance = \App\Helpers\GeneralHelper::loan_total_balance($loan_transaction->loan_id);                    
                    
                    $late_fee_balance = \App\Helpers\GeneralHelper::loan_total_penalty($loan_transaction->loan_id)-$loan_paid_items['penalty'];

                    $loan_sched = \App\Models\LoanSchedule::where('loan_id', $loan_transaction->loan_id)->orderBy('due_date', 'asc')->first();
                    $date1 = new \DateTime($loan_sched->due_date);
                    $date2 = new \DateTime(date('Y-m-d'));
                    $due_days = $date2->diff($date1)->format("%a");


                    $paid_count = 0;
                    $paid_amount = 0;
                    $unpaid_count = 0;
                    $unpaid_amount = 0;

                    $paid_rate = 0;
                    $unpaid_rate = 0;

                    $totalPrincipal = \App\Models\LoanSchedule::where('loan_id', $loan_transaction->loan_id)->sum('principal');
                    $payPrincipal = \App\Models\LoanTransaction::where('loan_id', $loan_transaction->loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'principal')->sum('credit');
                    $balancePrincipal = $totalPrincipal - $payPrincipal;

                    $loan_schedules = \App\Models\LoanSchedule::where('loan_id', $loan_transaction->loan_id)->get();
                    $payments = \App\Models\LoanTransaction::where('loan_id', $loan_transaction->loan_id)->where('transaction_type', 'repayment')->where('reversed', 0)->where('payment_type', 'regular')->sum('credit');

                    foreach ($loan_schedules as $schedule) {
                        $schedule_count = count($loan_schedules);
                        $principal = $balancePrincipal / $schedule_count;            
                        $loanRate = $loan_data['interest_rate'];

                        if ($loan_data['repayment_cycle'] == 'daily') {
                            $interest = (($balancePrincipal * $loanRate) / 100.00) / 30;
                        } elseif ($loan_data['repayment_cycle'] == 'weekly') {
                            $interest = (($balancePrincipal * $loanRate) / 100.00) / 4;
                        } elseif ($loan_data['repayment_cycle'] == 'bi_monthly') {
                            $interest = (($balancePrincipal * $loanRate) / 100.00) / 2;
                        } elseif ($loan_data['repayment_cycle'] == 'monthly') {
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
                ${{number_format($late_fee_balance,2)}}
                </h3>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 2px dashed gray;"><h3><span>Cuota vencida hace</span></h3></td>
                <td class="text-right" style="border-bottom: 2px dashed gray;">
                <h3>                
                {{$due_days}}
                </h3>
                </td>
            </tr>
            <tr>
                <td><h3><span>Cuotas Pendientes</span></h3></td>
                <td class="text-right">
                <h3>                
                {{number_format($unpaid_rate, 2, '.', "")}} de {{number_format($paid_count + $unpaid_count, 2, '.', "")}}
                </h3>
                </td>
            </tr>
            <tr>
                <td><h3><span>Cuotas Pagadas</span></h3></td>
                <td class="text-right">
                <h3>
                {{number_format($paid_rate, 2, '.', "")}} de {{number_format($paid_count + $unpaid_count, 2, '.', "")}}
                </h3>
                </td>
            </tr>
            <tr>
                <td><h3><span>Fecha de desembolso</span></h3></td>
                <td class="text-right">
                <h3>                
                {{$fecha_de_desembolso}}
                </h3>
                </td>
            </tr>
            <tr>
                <td><h3><span>Cuota pagada hoy</span></h3></td>
                <td class="text-right">
                <h3>                
                {{number_format($paid_rate, 2, '.', "")}}
                </h3>
                </td>
            </tr>
            <tr>
                <td><h3><span>{{trans('general.collected_by')}}:</span></h3></td>
                <td class="text-right">
                    @if($loan_transaction->user)
                        <h3>{{$loan_transaction->user->first_name}} {{$loan_transaction->user->last_name}}</h3>
                    @endif
                </td>
            </tr>
        </table>

        <div style="padding: 3px 10px;">
            <h4 class="text-center">Exija este recibo de pago, es el único comprobante de pago, no se aceptan reclamaciones de la empresa sin el recibo, si entregas dinero al cobrador sin recibo es responsabilidad del cliente.</h4>
            <br>
            <h4 class="text-center">{{date("d-m-Y H:i:s")}}</h4>
            <!---<br>
            <h3 class="text-center"><b>CONSERVE ESTE RECIBO DE PAGO</b></h3>
            <h4 class="text-center">RECIBO DE PAGO #{{$loan_transaction->receipt}}</h4>--->
        </div>        
        <p></p>
        <!-- <hr> -->
    </div>
</div>

<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

<script src="{{ asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script>
    window.onload = function () {
        
        // var post_url = "{{url('loan/transaction/sendwhatsapp')}}";
        // var form_data = {to: '+17076309110', msg: 'okk message', _token: "{{csrf_token()}}"};

        // $.post(post_url, form_data, function(response) {
        //     console.log('=========  response data  ======= ' + response);
        // });
        
        window.print();
        
        // window.frames["print_frame"].document.body.innerHTML=document.getElementById("print_section").innerHTML;
        // window.frames["print_frame"].window.focus();
        // window.frames["print_frame"].window.print();

        // CallPrint();        

                
    }
    
</script>
