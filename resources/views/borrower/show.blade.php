@extends('layouts.master')
@section('title')
T-Cobro Web | Perfil Cliente
@endsection
@section('content')

@if($borrower->blacklisted==1)
<div class="row">
  <div class="col-sm-12">
    <div class="alert bg-danger">
      <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
      {{trans_choice('general.blacklist_notification',1)}}
    </div>
  </div>
</div>
@endif

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3">
            <div class="border-bottom text-center pb-4" style="background-color:#cddaff;">
              <br>
              <br>
              @if(!empty($borrower->photo))
              <img src="{{asset('uploads/'.$borrower->photo)}}" alt="profile" class="img-lg rounded-circle mb-3" />
              @else
              <img src="{{asset('uploads/usericon.png')}}" alt="profile"
                class="img-lg rounded-circle mb-3" />
              @endif
              <div class="mb-3">
                <h3>{{$borrower->first_name}} {{$borrower->last_name}}</h3>
              </div>
            </div>
            <div class="py-4">
              <p class="clearfix">
                <span class="float-left">
                  <strong>Valoracion</strong>
                </span>
                <span class="float-right text-muted">
                  @if($borrower->active==1)
                  <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                  <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                  <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                  <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                  <img src="https://img.icons8.com/ios/36/000000/star.png" />
                  @elseif($borrower->active==0)
                  <img src="https://img.icons8.com/ios/39/000000/star.png" />
                  <img src="https://img.icons8.com/ios/39/000000/star.png" />
                  <img src="https://img.icons8.com/ios/39/000000/star.png" />
                  <img src="https://img.icons8.com/ios/39/000000/star.png" />
                  <img src="https://img.icons8.com/ios/39/000000/star.png" />
                  @endif
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>ID</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->unique_number}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Estatus</strong>
                </span>
                <span class="float-right text-muted">
                  @if($borrower->active==0)
                  Lista negra
                  @elseif(count($borrower->loans)==0)
                  Inactivo
                  @elseif(count($borrower->loans) > 0)
                  Activo
                  @endif
                </span>
              </p>

              <p class="clearfix">
                <span class="float-left">
                  <strong>Creado por</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->first_name}} {{$borrower->last_name}}
                </span>
              </p>

              <p class="clearfix">
                <span class="float-left">
                  <strong>Codeudor</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->first_name}} {{$borrower->last_name}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Telefono</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->mobile}}
                </span>
              </p>

            </div>

            <div class="dropdown">
              <button style="background-color:#FFCB12; color:black;"
                class="btn btn-white btn-block mb-2 dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-edit"></i> Editar
              </button>
              <div class="dropdown-menu btn-block mb-2" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{url('borrower/'.$borrower->id.'/edit')}}">Editar</a>
                <a class="delete dropdown-item" href="{{ url('borrower/'.$borrower->id.'/delete') }}">Eliminar</a>
              </div>
            </div>
            <button style="background-color:#4c82c3; color:white;" class="btn btn-white btn-block mb-2">Lista
              negra</button>
            <a data-toggle="collapse" data-parent="#accordion" href="#viewFiles" style="background-color:#4c82c3; color:white;"
              class="btn btn-white btn-block mb-2">Documento</a>
            <!-- <button style="background-color:#4c82c3; color:white;"
              class="btn btn-white btn-block mb-2">Documento</button> -->

            <div id="viewFiles" class="panel-collapse collapse">
              <div class="panel-body">
                <ul class="list-unstyled">
                  @foreach(unserialize($borrower->files) as $key=>$value)
                  <li>
                    <a href="{!!asset('uploads/'.$value)!!}" target="_blank">{!! $value!!}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>

          <div class="col-lg-9">
            <h4>Datos personales</h4>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Nombres</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->first_name}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">

                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Apellidos</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->last_name}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>ID/pasaporte</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->unique_number}}">
                  </div>
                </div>
              </div>
            </div>
            <br>
            <h4>Datos de contacto</h4>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Dirección</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->address}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Ciudad</strong></label>
                    @if($borrower->country)
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->country->name}}">
                    @else
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="Republica Dominicana">
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Geolocalización</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->geolocation}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Teléfono Fijo</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->phone}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Teléfono Móvil</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->mobile}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Email</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->email}}">
                  </div>
                </div>
              </div>

            </div>
            <br>
            <h4>Información Laboral</h4>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Empresa</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->business_name}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Ocupación</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->referencia_1}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Años laborando</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->working_time}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Ingresos</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="${{$borrower->ingresos}}">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label style="color:#22ae60;"><strong>Telefono</strong></label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" disabled="true"
                      value="{{$borrower->phone_business}}">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<br>

<div class="card">
  <div class="card-body">
    <h4><strong>Historial de préstamos</strong></h4>
    <br>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr style="">
                <th>#</th>
                <th>{{trans_choice('general.principal',1)}}</th>
                <th>{{trans_choice('Interes',1)}} %</th>
                <th>{{trans_choice('general.paid',1)}}</th>
                <th>{{trans_choice('general.balance',1)}}</th>
                <th>{{trans_choice('general.status',1)}}</th>
                <th>{{ trans_choice('general.action',1) }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($borrower->loans as $key)
              <tr>
                <td>{{$key->id}}</td>
                <td>${{number_format($key->principal,2)}}</td>
                <td>
                  {{round($key->interest_rate,2)}}%/ {{$key->interest_period}}
                </td>
                <td>${{number_format(\App\Helpers\GeneralHelper::loan_total_paid($key->id),2)}}</td>
                <td>${{number_format(\App\Helpers\GeneralHelper::loan_total_balance($key->id),2)}}</td>
                <td>
                  <span class="float-right text-muted">
                    @if($borrower->active==0)
                    <label style="width: 100px;" class="badge badge-danger">Lista negra</label>
                    @elseif(count($borrower->loans)==0)
                    <label style="width: 100px;" class="badge badge-secondary">Inactivo</label>
                    @elseif(count($borrower->loans) > 0)
                    <label style="width: 100px;" class="badge badge-success">Activo</label>
                    @endif
                  </span>

                  @if($key->maturity_date<date("Y-m-d") && \App\Helpers\GeneralHelper::loan_total_balance($key->
                    id)>0)
                    <span class="label label-danger">{{trans_choice('general.past_maturity',1)}}</span>
                    @else
                    @if($key->status=='pending')
                    <span class="label label-warning">{{trans_choice('general.pending',1)}}
                      {{trans_choice('general.approval',1)}}</span>
                    @endif
                    @if($key->status=='approved')
                    <span class="label label-info">{{trans_choice('general.awaiting',1)}}
                      {{trans_choice('general.disbursement',1)}}</span>
                    @endif
                    @if($key->status=='disbursed')
                    <label style="width: 100px;" class="badge badge-success">Activo</label>
                    @endif
                    @if($key->status=='declined')
                    <span class="label label-danger">{{trans_choice('general.declined',1)}}</span>
                    @endif
                    @if($key->status=='withdrawn')
                    <span class="label label-danger">{{trans_choice('general.withdrawn',1)}}</span>
                    @endif
                    @if($key->status=='written_off')
                    <label style="width: 100px;" class="badge badge-danger">Perdida</label>
                    @endif
                    @if($key->status=='closed')
                    <label style="width: 100px;" class="badge badge-secondary">Cancelado</label>
                    @endif
                    @if($key->status=='pending_reschedule')
                    <span class="label label-warning">{{trans_choice('general.pending',1)}}
                      {{trans_choice('general.reschedule',1)}}</span>
                    @endif
                    @if($key->status=='rescheduled')
                    <span class="label label-info">{{trans_choice('general.rescheduled',1)}}</span>
                    @endif
                    @endif
                </td>
                <td>
                  <a href="{{ url('loan/'.$key->id.'/show') }}">
                    <img src="https://img.icons8.com/cute-clipart/64/000000/search.png" />
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer-scripts')

<script>
$('#loan-data-table').DataTable({
  dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
  autoWidth: false,
  columnDefs: [{
    orderable: false,
    width: '100px',
    targets: [8]
  }],
  "order": [
    [0, "desc"]
  ],
  language: {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}:",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  }
});
$('#repayments-data-table').DataTable({
  dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
  autoWidth: false,
  columnDefs: [{
    orderable: false,
    width: '100px',
    targets: [4]
  }],
  "order": [
    [0, "desc"]
  ],
  language: {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}:",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  },
});
</script>
<script>
$(document).ready(function() {
  $('body').addClass('has-detached-left');
  $('.deletePayment').on('click', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    swal({
      title: '{{trans_choice('
      general.are_you_sure ',1)}}',
      text: 'If you delete a payment, a fully paid loan may change status to open.',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '{{trans_choice('
      general.ok ',1)}}',
      cancelButtonText: '{{trans_choice('
      general.cancel ',1)}}'
    }).then(function() {
      window.location = href;
    })
  });
});
</script>
@endsection