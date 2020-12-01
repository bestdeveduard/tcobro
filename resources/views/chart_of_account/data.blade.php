@extends('layouts.master')
@section('title')
{{trans_choice('general.chart_of_account',2)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2> {{trans_choice('general.chart_of_account',2)}}</h2>

      <div class="heading-elements">
        @if(Sentinel::hasAccess('capital.create'))
        <a href="{{ url('chart_of_account/create') }}" class="btn btn-info btn-sm">
          <!---{{trans_choice('general.add',1)}} {{trans_choice('general.chart_of_account',1)}}--->Agregar cuenta
          contable
        </a>
        @endif
      </div>
    </div>
    <div class="panel-body ">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th>{{trans_choice('general.gl_code',1)}}</th>
              <th>{{trans_choice('general.name',1)}}</th>
              <th>{{trans_choice('general.type',1)}}</th>
              <th>{{trans_choice('general.note',2)}}</th>
              <th>{{ trans_choice('general.action',1) }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td>{{ $key->gl_code }}</td>
              <td>{{ $key->name }}</td>
              <td>
                @if($key->account_type=="expense")
                {{trans_choice('general.expense',1)}}
                @endif
                @if($key->account_type=="asset")
                {{trans_choice('general.asset',1)}}
                @endif
                @if($key->account_type=="equity")
                {{trans_choice('general.equity',1)}}
                @endif
                @if($key->account_type=="liability")
                {{trans_choice('general.liability',1)}}
                @endif
                @if($key->account_type=="income")
                {{trans_choice('general.income',1)}}
                @endif
              </td>
              <td>{!! $key->notes !!}</td>
              <td>
                <a href="{{ url('chart_of_account/'.$key->id.'/edit') }}"><img
                    src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
                <a href="{{ url('chart_of_account/'.$key->id.'/delete') }}"><img
                    src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" /></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.panel-body -->
  </div>
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')
<script>
$('#data-table').DataTable({
  "order": [
    [0, "asc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [4]
  }],
  "language": {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  },
  responsive: false
});
</script>
@endsection