@extends('layouts.master')
@section('title')
{{trans_choice('general.borrower',1)}} {{trans_choice('general.number',2)}}
@endsection
@section('content')
<div class="card panel panel-white">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">
        Reporte resumen de clientes
        <!---{{trans_choice('general.borrower',1)}} {{trans_choice('general.number',2)}}--->
        @if(!empty($end_date))
        as at: <b> {{$end_date}}</b>
        @endif
      </h2>

      <div class="heading-elements">

      </div>
    </div>
    <div class="panel-body hidden-print">
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('start_date',trans_choice('general.start',1).'
          '.trans_choice('general.date',1),array('class'=>'')) !!}
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('end_date',trans_choice('general.end',1).'
          '.trans_choice('general.date',1),array('class'=>'')) !!}
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
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
                  <a href="{{url('report/borrower_report/borrower_numbers/pdf?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-pdf"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}</span>
                  </a>
                </li>
                <li>
                  <a href="{{url('report/borrower_report/borrower_numbers/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-excel"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}</span>
                  </a>
                </li>
                <li>
                  <a href="{{url('report/borrower_report/borrower_numbers/csv?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-download"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.csv',1)}}</span>
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
  @if(!empty($end_date))
  <div class="card-body">
    <div class="panel-body table-responsive no-padding">

      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th>{{trans_choice('general.name',1)}}</th>
            <th>{{trans_choice('general.value',1)}}</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total_borrowers = 0;
            $blacklisted_borrowers = 0;
            $dormant_borrowers = 0;
            $active_borrowers = 0;
            $new_borrowers = 0;
            foreach (\App\Models\Borrower::where('branch_id', Sentinel::getUser()->business_id)->get() as $key) {
                $total_borrowers = $total_borrowers + 1;
                if ($key->blacklisted == 1) {
                    $blacklisted_borrowers = $blacklisted_borrowers + 1;
                }
                if ($start_date <=date_format(date_create($key->created_at),"Y-m-d ")  && $end_date >=date_format(date_create($key->created_at),"Y-m-d ") ) {
                    $new_borrowers = $new_borrowers + 1;
                }
                if (count($key->loans) > 0) {
                    $active_borrowers = $active_borrowers + 1;
                } else {
                    $dormant_borrowers = $dormant_borrowers + 1;
                }
            }

            ?>
          <tr>
            <td>
              {{trans_choice('general.dormant',1)}} {{trans_choice('general.borrower',2)}}
            </td>
            <td>
              {{$dormant_borrowers}}
            </td>

          </tr>
          <tr>
            <td>
              {{trans_choice('general.new',1)}} {{trans_choice('general.borrower',2)}}
            </td>
            <td>
              {{$new_borrowers}}
            </td>

          </tr>
          <tr>
            <td>
              {{trans_choice('general.blacklisted',1)}} {{trans_choice('general.borrower',2)}}
            </td>
            <td>
              {{$blacklisted_borrowers}}
            </td>

          </tr>
          <tr>
            <td>
              {{trans_choice('general.total',1)}} {{trans_choice('general.borrower',2)}}
            </td>
            <td>
              {{$total_borrowers}}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  //$("body").addClass('sidebar-xs');
});
</script>
@endif
@endsection
@section('footer-scripts')

@endsection