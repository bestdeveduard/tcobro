@extends('layouts.auth')
@section('title')
    T-Cobro Web
@endsection

@section('content')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper" style="padding-top: 5px;">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="col-lg-10 mx-auto">
          <div class="card-body">
            <div class="container text-center pt-5">
              
              @if(Session::has('flash_notification.message'))
                  <script>toastr.{{ Session::get('flash_notification.level') }}('{{ Session::get("flash_notification.message") }}', 'Response Status')</script>
              @endif
              @if (isset($msg))
                  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ $msg }}
                  </div>
              @endif
              @if (isset($error))
                  <div class="alert alert-error">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      {{ $error }}
                  </div>
              @endif
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif


              <h1 class="mb-3">Inicie su negocios de prestamos hoy</h1>
              <p class="w-75 mx-auto mb-5">Elija un plan que se adapte mejor a sus necesidades. Si no está completamente satisfecho, ofrecemos una garantía de devolución de dinero de 30 días sin hacer preguntas.!!</p>
              <div class="row pricing-table">
                
                @foreach($plans as $plan)
                {!! Form::open(array('url' => url('payplan'), 'method' => 'post', 'name' => 'form','class'=>'col-md-6 col-xl-4 grid-margin stretch-card pricing-card')) !!}
                <div style="width: 100%;">
                  <div class="card border-primary border pricing-card-body">
                    <div class="text-center pricing-card-head">
                      <h3>{{$plan->name}}</h3>
                      <h1 class="font-weight-normal mb-4">${{ number_format($plan->amount,2) }}</h1>
                      <input type="hidden" name="user_id" id="user_id" value="{{\Session::get('user_id')}}">
                      <input type="hidden" name="price" id="price" value="{{$plan->amount}}">
                      <input type="hidden" name="plan_id" id="plan_id" value="{{$plan->id}}">
                      <input type="hidden" name="plan_duration" id="plan_duration" value="{{$plan->duration}}">
                    </div>
                    <ul class="list-unstyled plan-features">
                      <li>Prestamos unlimited</li>
                      <li>Clientes unlimited</li>
                      <li>Rutas {{$plan->delimited_route}}</li>
                      <li>Cobradores {{$plan->delimited_user}}</li>
                    </ul>
                    <div class="wrapper">
                      <button type="submit" class="btn @if($plan->id == 4) btn-success @else btn-outline-primary @endif btn-block">Comprar</button>
                    </div>
                  </div>
                </div>
                {!! Form::close() !!}
                @endforeach
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
@endsection
