@extends('layouts.master')
@section('title')
{{trans_choice('general.ledger',1)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title">
        {{trans_choice('general.ledger',1)}}
        @if(!empty($start_date))
        for period: <b>{{$start_date}} to {{$end_date}}</b>
        @endif
      </h3>

      <div class="heading-elements">
      </div>
    </div>
    <div class="panel-body hidden-print">
      <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-2">
          {!! Form::text('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"From
          Date",'required'=>'required')) !!}
        </div>
        <div class="col-md-1  text-center" style="padding-top: 15px;">
          to
        </div>
        <div class="col-md-2">
          {!! Form::text('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"To
          Date",'required'=>'required')) !!}
        </div>
      </div>
      <br>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-info">Buscar
                <!---{{trans_choice('general.search',1)}}!--->
              </button>
            </span>            
            <span class="input-group-btn">
              <button class="btn btn-info" onclick="window.print()">Imprimir</button>
            </span>
            <span class="input-group-btn">
              <a href="{{Request::url()}}" class="btn bg-purple">Resetear                
              </a>
            </span>
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
    <div class="panel-body table-responsive no-padding">
      <table class="table table-bordered table-condensed table-hover">
        <thead>
          <tr style="background-color: #0055AF">
            <th>{{trans_choice('general.gl_code',1)}}</th>
            <th>{{trans_choice('general.account',1)}}</th>
            <th>{{trans_choice('general.debit',1)}}</th>
            <th>{{trans_choice('general.credit',1)}}</th>
            <th>{{trans_choice('general.balance',1)}}</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $credit_total = 0;
            $debit_total = 0;
            ?>
          @foreach(\App\Models\ChartOfAccount::orderBy('gl_code','asc')->get() as $key)
          <?php
            $cr = 0;
            $dr = 0;
            $cr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                [$start_date, $end_date])->sum('credit');
            $dr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                [$start_date, $end_date])->sum('debit');
            $credit_total = $credit_total + $cr;
            $debit_total = $debit_total + $dr;
            ?>
          <tr>
            <td>{{ $key->gl_code }}</td>
            <td>
              {{$key->name}}
            </td>
            <td>{{ number_format($dr,2) }}</td>
            <td>{{ number_format($cr,2) }}</td>
            <td>
              @if($dr>$cr)
              {{number_format($dr-$cr,2)}} Dr
              @elseif($cr>$dr)
              {{number_format($cr-$dr,2)}} Cr
              @else
              0
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"><b>{{trans_choice('general.total',1)}}</b></td>
            <td>{{number_format($debit_total,2)}}</td>
            <td>{{number_format($credit_total,2)}}</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@else
<div class="card">
  <div class="card-body">
    <div class="panel-body table-responsive no-padding">
      <table class="table table-bordered table-condensed table-hover">
        <thead>
          <tr style="background-color: #D1F9FF">
            <th>{{trans_choice('general.gl_code',1)}}</th>
            <th>{{trans_choice('general.account',1)}}</th>
            <th>{{trans_choice('general.debit',1)}}</th>
            <th>{{trans_choice('general.credit',1)}}</th>
            <th>{{trans_choice('general.balance',1)}}</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $credit_total = 0;
            $debit_total = 0;
            ?>
          @foreach(\App\Models\ChartOfAccount::orderBy('gl_code','asc')->get() as $key)
          <?php
            $cr = 0;
            $dr = 0;
            $cr = \App\Models\JournalEntry::where('account_id', $key->id)->sum('credit');
            $dr = \App\Models\JournalEntry::where('account_id', $key->id)->sum('debit');
            $credit_total = $credit_total + $cr;
            $debit_total = $debit_total + $dr;
            ?>
          <tr>
            <td>{{ $key->gl_code }}</td>
            <td>
              {{$key->name}}
            </td>
            <td>{{ number_format($dr,2) }}</td>
            <td>{{ number_format($cr,2) }}</td>
            <td>
              @if($dr>$cr)
              {{number_format($dr-$cr,2)}} Dr
              @elseif($cr>$dr)
              {{number_format($cr-$dr,2)}} Cr
              @else
              0
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"><b>{{trans_choice('general.total',1)}}</b></td>
            <td>{{number_format($debit_total,2)}}</td>
            <td>{{number_format($credit_total,2)}}</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endif
@endsection
@section('footer-scripts')

@endsection