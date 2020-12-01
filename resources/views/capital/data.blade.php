@extends('layouts.master')
@section('title')
{{trans_choice('general.capital',2)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">{{trans_choice('general.capital',2)}} {{trans_choice('general.transaction',2)}}</h2>

      <div class="heading-elements">
        @if(Sentinel::hasAccess('capital.create'))
        <a href="{{ url('capital/create') }}" class="btn btn-info btn-sm">{{trans_choice('general.add',1)}}
          {{trans_choice('general.capital',1)}}</a>
        @endif
      </div>
    </div>
    <div class="panel-body ">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th>{{trans_choice('general.account',1)}}</th>
              <th>{{trans_choice('general.amount',1)}}</th>
              <th>{{trans_choice('general.date',1)}}</th>
              <th>{{trans_choice('general.description',1)}}</th>
              <th>{{ trans_choice('general.action',1) }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td>
                @if(!empty($key->debit_chart))
                {{$key->debit_chart->name}}
                @endif
              </td>
              <td>
                {{ $key->amount }}
              </td>
              <td>{{ $key->date }}</td>
              <td>{{ $key->notes }}</td>
              <td>
                <a href="{{ url('capital/'.$key->id.'/edit') }}"><img
                    src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
                <a href="{{ url('capital/'.$key->id.'/delete') }}"><img
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
  "paging": true,
  "lengthChange": true,
  "displayLength": 15,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "order": [
    [2, "desc"]
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