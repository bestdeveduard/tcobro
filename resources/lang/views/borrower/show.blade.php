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

<!-- Detached sidebar -->
<!-- <div class="theme-setting-wrapper">
  <div id="settings-trigger"><i class="fa fa-cog"></i></div>
  <div id="theme-settings" class="settings-panel">
    <i class="settings-close fas fa-times"></i>
    <p class="settings-heading">SIDEBAR SKINS</p>
    <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
      <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
    </div>
    <div class="sidebar-bg-options" id="sidebar-light-theme">
      <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
    </div>
    <p class="settings-heading mt-2">HEADER SKINS</p>
    <div class="color-tiles mx-0 px-4">
      <div class="tiles success"></div>
      <div class="tiles warning"></div>
      <div class="tiles danger"></div>
      <div class="tiles info"></div>
      <div class="tiles dark"></div>
      <div class="tiles default"></div>
    </div>
  </div>
</div> -->

<!-- partial -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-4">
            <div class="border-bottom text-center pb-4">
              @if(!empty($borrower->photo))
              <img src="{{asset('uploads/'.$borrower->photo)}}" alt="profile" class="img-lg rounded-circle mb-3" />
              @else
              <img src="https://img.icons8.com/cotton/74/000000/name--v2.png"  alt="profile" class="img-lg rounded-circle mb-3" />
              @endif
              <div class="mb-3">
                <h3>{{$borrower->first_name}} {{$borrower->last_name}}</h3>
              </div>

              <div class="d-flex justify-content-center">

                         @if($borrower->active==1)
                          <td>
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/ios/36/000000/star.png" />
                          </td>
                         @elseif($borrower->active==0)
                          <td>
                            <img src="https://img.icons8.com/ios/39/000000/star.png" />
                            <img src="https://img.icons8.com/ios/39/000000/star.png" />
                            <img src="https://img.icons8.com/ios/39/000000/star.png" />
                            <img src="https://img.icons8.com/ios/39/000000/star.png" />
                            <img src="https://img.icons8.com/ios/39/000000/star.png" />
                          </td>                  
                        @endif 
                          
              </div>
            </div>
            <div class="py-4">
              <p class="clearfix">
                    <span class="float-left">
                     <strong>Estatus</strong>
                    </span>
                        <span class="float-right text-muted">
                          @if($borrower->active==0)
                          <label style="width: 100px;" class="badge badge-danger">Lista negra</label> 
                          @elseif(count($borrower->loans)==0)
                          <label style="width: 100px;" class="badge badge-secondary">Inactivo</label>
                          @elseif(count($borrower->loans) > 0)
                          <label style="width: 100px;" class="badge badge-success">Activo</label>
                          @endif
                        </span>
              </p>
            <br>
              <p class="clearfix">
                <span class="float-left">
                 <strong>Telefono fijo</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->phone}}
                </span>
              </p>
              
              <p class="clearfix">
                <span class="float-left">
                 <strong>ID/Pasaporte</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->unique_number}}
                </span>
              </p>              
                          
              <p class="clearfix">
                <span class="float-left">
                  <strong>Telefono movil</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->mobile}}
                </span>
              </p>

              <p class="clearfix">
                <span class="float-left">
                  <strong>Email</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->email}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Direccion</strong>
                </span>
                <span class="float-right text-muted">
                  <a>{{$borrower->address}}</a>
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Pais</strong>
                </span>
                <span class="float-right text-muted">
                  @if($borrower->country)
                  <a>{{$borrower->country->name}}</a>
                  @endif
                </span>
              </p>
            </div>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Empresa</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->business_name}}
                </span>
              </p>

              <p class="clearfix">
                <span class="float-left">
                  <strong>Telefono</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->phone_business}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Ocupacion</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->referencia_1}}
                </span>
              </p>

              <p class="clearfix">
                <span class="float-left">
                  <strong>Tiempo laborando</strong>
                </span>
                <span class="float-right text-muted">
                  {{$borrower->working_time}}
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Ingresos</strong>
                </span>
                <span class="float-right text-muted">
                  <a>${{$borrower->ingresos}}</a>
                </span>
              </p>
              <p class="clearfix">
                <span class="float-left">
                  <strong>Mover a lista negra</strong>
                </span>
                <span class="float-right text-muted">
                  <a>
                      
                    <a href="{{ url('borrower/'.$borrower->id.'/approve') }}">
                        <img src="https://img.icons8.com/cute-clipart/34/000000/checked-radio-button.png"/>
                    </a>
        
                    <a href="{{ url('borrower/'.$borrower->id.'/decline') }}">
                        <img src="https://img.icons8.com/fluent/34/000000/cancel-2.png"/>
                    </a>                      
                              
                  </a>
                </span>
              </p>              
            
            <!---
            <div class="d-flex justify-content-center">
                
            <a href="{{url('borrower/'.$borrower->id.'/edit')}}">
                <img src="https://img.icons8.com/cute-clipart/64/000000/edit.png" />
            </a>
            
            <a href="{{ url('borrower/'.$borrower->id.'/approve') }}">
                <img src="https://img.icons8.com/cute-clipart/64/000000/checked-radio-button.png"/>
            </a>

            <a href="{{ url('borrower/'.$borrower->id.'/decline') }}">
                <img src="https://img.icons8.com/fluent/64/000000/cancel-2.png"/>
            </a>

            <a href="{{ url('borrower/'.$borrower->id.'/delete') }}">
                <img src="https://img.icons8.com/flat_round/64/000000/delete-sign.png" />
            </a>
            
            </div>--->
          </div>


          <div class="col-lg-8">
            <div class="mt-4 py-2 border-top border-bottom">
              <ul class="nav profile-navbar" role="tablist">
                <!---<li class="nav-item">
                  <a class="nav-link" id="home-tab" data-toggle="tab" href="#home-1" role="tab"
                    aria-controls="home-1" aria-selected="true"><i class="fas fa-user-alt"></i> Perfil del
                    cliente</a>
                </li>--->
                <li class="nav-item">
                  <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile-1" role="tab"
                    aria-controls="profile-1" aria-selected="false"><i class="fas fa-gavel"></i> Historial de
                    prestamos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact-1" role="tab"
                    aria-controls="contact-1" aria-selected="false"><i class="fas fa-dollar-sign"></i> Historial
                    de pagos</a>
                </li>
              </ul>
            </div>


            <div class="tab-content">
              <div class="tab-pane fade" id="home-1" role="tabpanel" aria-labelledby="home-tab">
                <div class="media">
                  <div class="row">
                    <div class="col-md-6">
                      <h5><b>
                          Información Basica
                        </b>
                      </h5>
                      <table class="table table-striped table-hover">
                        <tr>
                          <td><b>Numero Identificacion</b></td>
                          <td>{{$borrower->unique_number}}</td>
                        </tr>
                        <tr>
                          <td><b>{{trans_choice('general.working_status',1)}}</b></td>
                          <td>{{$borrower->working_status}}</td>
                        </tr>
                        <tr>
                          <td><b>{{trans_choice('general.dob',1)}}</b></td>
                          <td>{{$borrower->dob}}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <h5>
                        <b>
                          Información de Contacto
                        </b>
                      </h5>
                      <table class="table table-striped table-hover">
                        <tr>
                          <td><b>{{trans_choice('Telefono Fijo',1)}}</b></td>
                          <td>{{$borrower->phone}}</td>
                        </tr>
                        <tr>
                          <td><b>{{trans_choice('Email',1)}}</b></td>
                          <td>
                            <a href="{{url('communication/email/create?borrower_id='.$borrower->id)}}">
                              {{$borrower->email}}
                            </a>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Telefono movil</b></td>
                          <td>
                            <a href="{{url('communication/sms/create?borrower_id='.$borrower->id)}}">
                              {{$borrower->mobile}}
                            </a>
                          </td>
                        </tr>
                      </table>
                      <br>
                      <h5>
                        <b>
                          Score de Credito
                        </b>
                      </h5>
                      <table class="table table-striped table-hover">
                        <?php
                            $credit_sc_credit = 90;
                            $credit_sc_debit = \App\Models\Creditscore::where('borrower_id', ($borrower->id))->sum('value');
                            $check_value = abs($credit_sc_credit - $credit_sc_debit);
                            ?>
                        <tr>
                          <td><b>{{trans_choice('Estatus',1)}}</b></td>
                          <td>
                            <h3>
                              {{number_format($check_value,2)}}%
                              @if($check_value > 90)
                              <span class="label label-success">Excelente</span>

                              @elseif($check_value > 80)
                              <span class="label label-success">Bueno</span>

                              @elseif($check_value > 60)
                              <span class="label label-warning">Regular</span>

                              @else
                              <span class="label label-danger">Malo</span>
                              @endif
                            </h3>
                          </td>
                        </tr>
                        <tr>
                          <td><b>{{trans_choice('Calificacion',1)}}</b></td>
                          <td>
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/fluent/40/000000/star.png" />
                            <img src="https://img.icons8.com/ios/39/000000/star.png" />
                          </td>
                        </tr>
                      </table>
                      
                    </div>
                  </div>
                </div>
              </div>


              <div class="tab-pane fade show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab">
                <div class="media">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr style="">
                          <th>#</th>
                          <th>{{trans_choice('general.principal',1)}}</th>
                          <!---<th>{{trans_choice('general.released',1)}}</th>--->
                          <th>{{trans_choice('Interes',1)}} %</th>
                          <!---<th>{{trans_choice('general.due',1)}}</th>--->
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
                          <!---<td>{{$key->release_date}}</td>--->
                          <td>
                            {{round($key->interest_rate,2)}}%/ {{$key->interest_period}}
                          </td>
                          <!---<td>$ {{number_format(\App\Helpers\GeneralHelper::loan_total_due_amount($key->id),2)}}</td>--->
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
                        
                        
                        
                            @if($key->maturity_date<date("Y-m-d") &&
                              \App\Helpers\GeneralHelper::loan_total_balance($key->
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
                                <img src="https://img.icons8.com/cute-clipart/64/000000/search.png"/>
                            </a>                              
                          </td>
                          <!---
                          <td class="text-center">
                            <ul class="icons-list">
                              <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="icon-menu9"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                  <li><a href="{{ url('loan/'.$key->id.'/show') }}"><i class="fa fa-search"></i>
                                      {{ trans_choice('general.detail',2) }}
                                    </a></li>
                                  <li><a href="{{ url('loan/'.$key->id.'/edit') }}"><i class="fa fa-edit"></i>
                                      {{ trans('general.edit') }}
                                    </a></li>
                                  <li><a href="{{ url('loan/'.$key->id.'/delete') }}" class="delete"><i
                                        class="fa fa-trash"></i> {{ trans('general.delete') }}
                                    </a></li>
                                </ul>
                              </li>
                            </ul>
                          </td>--->
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <div class="tab-pane fade" id="contact-1" role="tabpanel" aria-labelledby="contact-tab">
                <div class="table-responsive">
                  <table id="data-table" class="table">
                    <thead>
                      <tr>
                        <th>
                        ID
                        </th>                          
                        <th>
                          {{trans_choice('general.collection',1)}} {{trans_choice('general.date',1)}}
                        </th>
                        <th>
                          {{trans_choice('general.collected_by',1)}}
                        </th>
                        <th>
                          {{trans_choice('general.method',1)}}
                        </th>
                        <th>
                          {{trans_choice('general.amount',1)}}
                        </th>
                        <th>
                          {{trans_choice('general.action',1)}}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach(\App\Models\LoanTransaction::where('borrower_id',$borrower->id)->where('transaction_type','repayment')->where('reversed',0)->get()
                      as $key)
                      <tr>
                        <td>{{$key->id}}</td>  
                        <td>{{$key->date}}</td>
                        <td>
                          @if(!empty($key->user))
                          {{$key->user->first_name}} {{$key->user->last_name}}
                          @endif
                        </td>
                        <td>
                          @if(!empty($key->loan_repayment_method))
                          {{$key->loan_repayment_method->name}}
                          @endif
                        </td>
                        <td>{{number_format($key->credit,2)}}</td>
                        <td class="text-center">
                          <ul class="icons-list">
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                  <a href="{{url('loan/transaction/'.$key->id.'/show')}}"><i class="fa fa-search"></i>
                                    {{ trans_choice('general.view',1) }}
                                  </a>
                                </li>
                                <li>
                                  @if($key->transaction_type=='repayment' && $key->reversible==1)
                                <li>
                                  <a href="{{url('loan/transaction/'.$key->id.'/print')}}" target="_blank"><i
                                      class="icon-printer"></i> {{ trans_choice('general.print',1) }}
                                    {{trans_choice('general.receipt',1)}}
                                  </a>
                                </li>
                                <li>
                                  <a href="{{url('loan/transaction/'.$key->id.'/pdf')}}" target="_blank"><i
                                      class="icon-file-pdf"></i> {{ trans_choice('general.pdf',1) }}
                                    {{trans_choice('general.receipt',1)}}
                                  </a>
                                </li>
                                <li>
                                  <a href="{{url('loan/repayment/'.$key->id.'/edit')}}"><i class="fa fa-edit"></i>
                                    {{ trans('general.edit') }}
                                  </a>
                                </li>
                                <li>
                                  <a href="{{url('loan/repayment/'.$key->id.'/reverse')}}" class="delete"><i
                                      class="fa fa-minus-circle"></i> {{ trans('general.reverse') }}
                                  </a>
                                </li>
                                @endif
                              </ul>
                            </li>
                          </ul>
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