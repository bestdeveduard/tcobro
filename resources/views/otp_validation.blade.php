@extends('layouts.auth')
@section('title')
    T-Cobro Web
@endsection

@section('content')

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper" style="padding-top: 5px;">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">

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

              <div class="brand-logo">
                <center>
                    <img src="{{ asset('logo.png') }}" alt="logo">
                </center>
              </div>

              <center>
                <h4>Hemos enviado un codigo de confirmacion a su correo electronico</h4>
              </center>
              
              {!! Form::open(array('url' => url('verifyotp'), 'method' => 'post', 'name' => 'form','class'=>'pt-3')) !!}

                <br>
                <br>
                <h6 class="font-weight-light">Ingresar codigo</h6>
                <div class="form-group">
                  {!! Form::number('otp_code', null, array('class' => 'form-control', 'placeholder'=>'Codigo OTP','required'=>'required', 'id'=>'otp_code')) !!}
                  <input type="hidden" name="user_id" id="user_id" value="{{\Session::get('user_id')}}">
                </div>
                <br>

                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">Validar</button>
                </div>

                <div class="mt-3">
                  <a class="btn btn-block btn-dark btn-lg font-weight-medium auth-form-btn" href="{{ asset('admin_register') }}">Reenviar</a>
                </div>              

              {!! Form::close() !!}

            </div>
          </div>
        </div>
      </div>      
    </div>    
  </div>    
@endsection
