@extends('layouts.master')
@section('title'){{trans_choice('general.loan',1)}} {{trans_choice('general.repayment',1)}}
{{trans_choice('general.method',2)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">{{trans_choice('general.loan',1)}} {{trans_choice('general.repayment',1)}}
        {{trans_choice('general.method',2)}}</h2>

      <div class="heading-elements">
        <a href="{{ url('loan/loan_repayment_method/create') }}"
          class="btn btn-info btn-sm">{{trans_choice('general.add',1)}} {{trans_choice('general.repayment',1)}}
          {{trans_choice('general.method',1)}}</a>
      </div>
    </div>
    <div class="panel-body">
      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>{{ trans_choice('general.name',1) }}</th>
            <th>{{ trans_choice('general.action',1) }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $key)
          <tr>
            <td>{{ $key->id }}</td>
            <td>{{ $key->name }}</td>
            <td>
              <a href="{{ url('loan/loan_repayment_method/'.$key->id.'/edit') }}"><img
                  src="https://img.icons8.com/cute-clipart/64/000000/edit.png" /></a>
              <a href="{{ url('loan/loan_repayment_method/'.$key->id.'/delete') }}"><img
                  src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" /></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.panel-body -->
  </div>
  <!-- /.box -->
</div>
@endsection
@section('footer-scripts')

@endsection