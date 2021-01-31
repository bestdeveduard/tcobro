@extends('layouts.master')
@section('title')
{{trans_choice('general.income',1)}} {{trans_choice('general.statement',1)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">
        {{trans_choice('general.income',1)}} {{trans_choice('general.statement',1)}}
        @if(!empty($start_date))
        for period: <b>{{$start_date}} to {{$end_date}}</b>
        @endif
      </h2>

      <div class="heading-elements">

      </div>
    </div>

    <div class="panel-body hidden-print">
      <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-2">
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"From
          Date",'required'=>'required')) !!}
        </div>
        <div class="col-md-1  text-center" style="padding-top: 15px;">
          to
        </div>
        <div class="col-md-2">
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"To
          Date",'required'=>'required')) !!}
        </div>
      </div>
      <br>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">

            <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}!
            </button>


            <a href="{{Request::url()}}" class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

            <div class="btn-group">
              <button type="button" class="btn dropdown-toggle legitRipple"
                data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                </button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li>
                  <a href="{{url('report/financial_report/income_statement/pdf?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-pdf"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}}
                    {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}</span>
                  </a>
                </li>
                <li>
                  <a href="{{url('report/financial_report/income_statement/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-excel"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}}
                    {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}</span>
                  </a>
                </li>
                <li>
                  <a href="{{url('report/financial_report/income_statement/csv?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-download"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}}
                    {{trans_choice('general.to',1)}} {{trans_choice('general.csv',1)}}</span>
                  </a>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

    </div>
    <!-- /.panel-body -->

  </div>
  <!-- /.box -->
  @if(!empty($start_date))
  <div class="card-body">
    <div class="panel-body table-responsive no-padding">

      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th>{{trans_choice('general.gl_code',1)}}</th>
            <th>{{trans_choice('general.account',1)}}</th>
            <th>{{trans_choice('general.balance',1)}}</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td colspan="3" style="text-align: center"><b>{{trans_choice('general.income',1)}}</b></td>
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
            <td>{{ $key->gl_code }}</td>
            <td>
              {{$key->name}}
            </td>
            <td>{{ number_format($balance,2) }}</td>
          </tr>
          @endforeach
          <tr>          
            <td colspan="2" style="text-align: right">
              <b>{{trans_choice('general.total',1)}} {{trans_choice('general.income',1)}}</b>
            </td>
            <td><b>{{ number_format($total_income,2) }}</b></td>
          </tr>
          <tr>
          </tr>
          <tr>
          </tr>
          <tr>
            <td colspan="3" style="text-align: center"><b>{{trans_choice('general.expense',2)}}</b></td>
          </tr>
          @foreach(\App\Models\ChartOfAccount::where('account_type','expense')->orderBy('gl_code','asc')->get() as $key)
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
            <td>{{ $key->gl_code }}</td>
            <td>
              {{$key->name}}
            </td>
            <td>{{ number_format($balance,2) }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="2" style="text-align: right">
              <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b>
            </td>
            <td><b>{{ number_format($total_expenses,2) }}</b></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" style="text-align: right">
              <b>{{trans_choice('general.net',1)}} {{trans_choice('general.income',1)}}</b>
            </td>
            <td><b>{{ number_format($total_income-$total_expenses,2) }}</b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  @endif
</div>
@endsection

@section('footer-scripts')

@endsection