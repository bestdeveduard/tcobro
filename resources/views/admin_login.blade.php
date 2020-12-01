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

            {!! Form::open(array('url' => url('login'), 'method' => 'post', 'name' => 'form','class'=>'f-login-form')) !!}
                <div class="brand-logo">
                    <center>
                        <img src="{{ asset('logo.png') }}" alt="logo">
                    </center>
                </div>

                <center>
                    <h4>Gestionamos tus prestamos</h4>
                    <h6 class="font-weight-light">Inicie seccion para continuar.</h6>
                </center>

                <div class="form-group has-feedback has-feedback-left">
                    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder'=>trans_choice("Usuario",1),'required'=>'required')) !!}
                </div>
                <div class="form-group has-feedback has-feedback-left">
                    {!! Form::password('password', array('class' => 'form-control', 'placeholder'=>trans('general.password'),'required'=>'required')) !!}                    
                </div>                
                
                <div class="mt-3">                  
                  <center>
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">INICIAR</button>
                  </center>
                </div>                

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" name="remember" class="styled">
                       {{ trans('general.remember') }}
                    </label>
                  </div>
                  <a href="javascript:;" id="forget-password" class="auth-link text-black">{{ trans('general.forgot_password') }}</a>                  
                </div>
            {!! Form::close() !!}

            {!! Form::open(array('url' => url('reset'), 'method' => 'post', 'name' => 'form','class'=>'f-forget-form ')) !!}
                <!-- <p class="login-box-msg">{{ trans('general.forgot_password_msg') }}</p> -->
                <div class="brand-logo">
                    <center>
                        <img src="{{ asset('logo.png') }}" alt="logo">
                    </center>
                </div>

                <center>
                    <h4>Recuperar Contraseña</h4>
                    <h6 class="font-weight-light">Ingrese su usuario para restablecerlo.</h6>
                </center>

                <div class="form-group has-feedback has-feedback-left">
                    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder'=>trans_choice('general.email',1),'required'=>'required')) !!}
                </div>
                <div class="mt-3">
                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="otp.html">INICIAR</a> -->
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">{{ trans('general.reset') }}</button>
                </div>

                <!-- <div class="row">
                    <div class="col-xs-8">
                        <div class="">
                            <a style="background-color:#39b4fc;" href="javascript:;" class="btn bg-pink-400" id="back-btn"><i
                                        class="fa fa-backward"></i> {{ trans('general.back') }}</a>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button style="background-color:#39b4fc;" type="submit"
                                class="btn bg-pink-400">{{ trans('general.reset') }}</button>
                    </div>                    
                </div> -->
                
            {!! Form::close() !!}

                
            <div class="text-center mt-4 font-weight-light">
                ¿Aún no tienes una cuenta? <a href="{{ asset('admin_register') }}" class="text-primary">Registrarme</a>
            </div>

            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  

    <script>
        $(document).ready(function () {
            jQuery('.f-register-form').hide();
            jQuery('.f-forget-form').hide();
            jQuery('#forget-password').click(function () {
                jQuery('.f-login-form').hide();
                jQuery('.f-forget-form').show();
            });
            jQuery('#register-btn').click(function () {
                jQuery('.f-login-form').hide();
                jQuery('.f-register-form').show();
            });
            jQuery('#back-btn').click(function () {
                jQuery('.f-login-form').show();
                jQuery('.f-forget-form').hide();
            });
            jQuery('#register-back-btn').click(function () {
                jQuery('.f-login-form').show();
                jQuery('.f-register-form').hide();
            });

        });
    </script>
@endsection
