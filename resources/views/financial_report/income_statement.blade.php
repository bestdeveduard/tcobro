@extends('layouts.master')
@section('title')
Tcobro | Reprote de utilidad
@endsection
@section('content')

<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title">
        Reporte de utilidad<!---{{trans_choice('general.ledger',1)}}
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
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"From
          Date",'required'=>'required')) !!}
        </div>
        <br><br>
        <div class="col-md-2" style="color:#22ae60;">          
         <h5>Final</h5>   
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"To
          Date",'required'=>'required')) !!}
        </div>
        <br><br>
        <div class="col-md-2" style="color:#22ae60;">          
         <h5>.</h5>   

            <div class="btn-group">
                <button type="button" style="border-color:#f0f0f0; width:180px;" class="btn dropdown-toggle legitRipple"
                data-toggle="dropdown">Descargar
                </button>
              <ul style="width:180px;" class="dropdown-menu dropdown-menu-right">
                <li>
                  <a href="{{url('report/financial_report/income_statement/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
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
    <tr style="background-color:#CDDAFF; padding:1.8rem 0.9375rem; border-top:1px solid #f3f3f3;" >
      <th><center>No. Cuenta Contable</center></th>
      <th>Cuenta</th>
      <th>Balance</th>
    </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="3" style="text-align:left; color:#46b979;"><h5>Ingresos</h5></td>
          </tr>
          <tr>
          </tr>
          <tr>
          </tr>
          <?php
               $total_income = 0;
               $total_expenses = 0;
          ?>
          @foreach(\App\Models\ChartOfAccount::where('account_type','income')->orderBy('gl_code','asc')->get() as $key)
          <?php
                $balance = 0;
                $cr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            Sentinel::getUser()->business_id)->sum('credit');
                $dr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                           [$start_date, $end_date])->where('branch_id',
                            Sentinel::getUser()->business_id)->sum('debit');
                $balance =  $cr-$dr;
                $total_income = $total_income + $balance;
            ?>
          <tr>
            <td><center>{{ $key->gl_code }}</center></td>
            <td>
              {{$key->name}}
            </td>
            <td>{{ number_format($balance,2) }}</td>
          </tr>

          @endforeach
          <tr>          
            <td colspan="2" style="text-align: right">
              <b>Total ingresos</b>
            </td>
            <td><b>{{ number_format($total_income,2) }}</b></td>
          </tr>
          <tr>
          </tr>
          <tr>
          </tr>
          <tr>
            <td colspan="3" style="text-align:left; color:#46b979;"><h5>Gastos</h5></td>
          </tr>
          @foreach(\App\Models\ChartOfAccount::where('account_type','expense')->where('exclude','0')->orderBy('gl_code','asc')->get() as $key)
          <?php
                        $balance = 0;
                        $cr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            Sentinel::getUser()->business_id)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            Sentinel::getUser()->business_id)->sum('debit');
                        $balance =  $dr-$cr;
                        $total_expenses = $total_expenses + $balance;
          ?>
          <tr>
            <td><center>{{ $key->gl_code }}</center></td>
            <td>
              {{$key->name}}
            </td>
            <td>{{ number_format($balance,2) }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="2" style="text-align: right">
              <b>Total Gastos</b>
            </td>
            <td><b>{{ number_format($total_expenses,2) }}</b></td>
          </tr>

        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" style="text-align: right">
              <b>Utilidad</b>
            </td>
            <td><b>{{ number_format($total_income-$total_expenses,2) }}</b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>  
</div>
@endif
@endsection
@section('footer-scripts')
@endsection