@extends('layouts.auth')
@section('title')
    T-Cobro Web
@endsection

@section('content')

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div style="width: 55%;" class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <center><img src="{{ asset('assets/new_theme/images/logo-mini-largue3.png') }}" alt="logo"></center>
              </div>
              <h4> Bienvenido!</h4>
              <h6 class="font-weight-light">Encantado de verte de nuevo!</h6/>
 {!! Form::open(array('url' => url('login'), 'method' => 'post', 'name' => 'form','class'=>'pt-3'))!!}              
                <div class="form-group">
                  <label for="exampleInputEmail" style="color:#22ae60;"><strong>Usuario</strong></label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-user text-primary"></i>
                      </span>
                    </div>
 {!! Form::email('email', null, array('class' => 'form-control form-control-lg border-left-0', 'placeholder'=>trans_choice("Usuario",1),'required'=>'required')) !!}                    
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword" style="color:#22ae60;"><strong>Password</strong></label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fas fa-lock text-primary"></i>
                      </span>
                    </div>
                    {!! Form::password('password', array('class' => 'form-control form-control-lg border-left-0', 'placeholder'=>trans('general.password'),'required'=>'required')) !!}                                           
                  </div>
                </div>


       
                  <div style="display: none;" class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" name="remember" class="styled">
                       {{ trans('general.remember') }}
                    </label>
                  </div><!---
                  <a href="javascript:;" id="forget-password" class="auth-link text-black">{{ trans('general.forgot_password') }}</a>--->                  
            


                <!---<div class="my-3">
                  <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">LOGIN</a>
                </div>--->

                                 
                  <center>
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">Iniciar Sesión</button>
                  </center>
               
            <div class="text-center mt-4 font-weight-light">
                ¿Aún no tienes una cuenta? <a href="{{ asset('admin_register') }}" class="text-primary">Registrarme</a>
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
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright&copy; Tcobro 2020. Todos los derechos reservados.</p>
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
