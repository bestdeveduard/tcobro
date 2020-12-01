@extends('layouts.master')
@section('title')
{{trans_choice('general.expense',2)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">{{trans_choice('general.expense',2)}}</h2>

      <div class="heading-elements">
        @if(Sentinel::hasAccess('expenses.create'))
        <a href="{{ url('expense/create') }}" class="btn btn-info btn-sm">{{trans_choice('general.add',1)}}
          {{trans_choice('general.expense',2)}}</a>
        @endif
      </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table id="order-listing" class="table">
          <thead>
            <tr>
              <th>Categoria</th>
              <th>Montos</th>
              <th>Fecha</th>
              <th>Recurrente</th>
              <th>Descripcion</th>
              <th>{{trans_choice('general.file',2)}}</th>
              <th>{{ trans_choice('general.action',1) }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td>
                @if(!empty($key->expense_type))
                {{$key->expense_type->name}}
                @endif
              </td>
              <td>{{ $key->amount }}</td>
              <td>{{ $key->date }}</td>
              <td>
                @if($key->recurring==1)
                {{trans_choice('general.yes',1)}}
                @else
                {{trans_choice('general.no',1)}}
                @endif
              </td>
              <td>{{ $key->notes }}</td>
              <td>
                <ul class="">
                  @foreach(unserialize($key->files) as $k=>$value)
                  <li><a href="{!!asset('uploads/'.$value)!!}" target="_blank">{!! $value!!}</a></li>
                  @endforeach
                </ul>
              </td>
              <td>
                <a href="{{ url('expense/'.$key->id.'/edit') }}"><img
                    src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
                <a href="{{ url('expense/'.$key->id.'/delete') }}"><img
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
$('#order-listing').DataTable({
  "order": [
    [2, "desc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [6]
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