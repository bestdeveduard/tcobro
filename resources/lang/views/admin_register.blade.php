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
            <div class="auth-form-transparent text-left p-3">

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
                <center><img src="{{ asset('assets/new_theme/images/logo-mini-largue3.png') }}" alt="logo"></center>
              </div>
              <h4>Crear nueva cuenta</h4>

              {!! Form::open(array('url' => url('register'), 'method' => 'post', 'name' => 'form','class'=>'pt-3')) !!}

                <label style="color:#22ae60;"><strong>Datos personales</strong></label>
                <br><br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-sm-12">
                 {!! Form::text('first_name', null, array('class' => 'form-control', 'placeholder'=>'Nombres *','required'=>'required', 'id' => 'first_name')) !!}                     
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-sm-12">
                  {!! Form::text('last_name', null, array('class' => 'form-control', 'placeholder'=>'Apellidos *','required'=>'required', 'id' => 'last_name')) !!}                    
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-sm-12">
                  {!! Form::email('email', null, array('class' => 'form-control', 'placeholder'=>'E-mail *','required'=>'required', 'id'=>'email')) !!}                    
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-sm-12">
                {!! Form::number('phone', null, array('class' => 'form-control', 'placeholder'=>'Telefono *','required'=>'required', 'id'=>'phone')) !!}                 
                      </div>
                    </div>
                  </div>
                </div>
<br>
                <div style="display: none;" class="form-group">
                  <label>Country</label>
                 <select class="form-control form-control-lg" id="country_id" name="country_id" placeholder="Pais *">
                    <option value="" disabled selected>Pais *</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->id == 61) selected @endif>{{$country->name}}</option>
                    @endforeach
                  </select>
                </div>
                <label style="color:#22ae60;"><strong>Datos para iniciar seccion</strong></label>
                <br><br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-sm-12">
                      {!! Form::text('user_name', null, array('class' => 'form-control', 'placeholder'=>'Usuario *','required'=>'required', 'id' => 'user_name')) !!}                      
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="password" class="form-control" id="password" name='password' placeholder="Contraseña" required="true" *>                                          
                      </div>
                    </div>
                  </div>
                </div>   

                <div style="display: none;" class="form-group">
                  <label>RePassword</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fas fa-lock text-primary"></i>
                      </span>
                    </div>   
                  <input type="password" class="form-control form-control-lg border-left-0" id="rpassword" name='rpassword' value="1" placeholder="Confirmar contraseña *">                                     
                  </div>
                </div>                
                <div style="display: none;" class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-" id="accept_ploicy" value="1" name="accept_ploicy">                      
                      I agree to all Terms & Conditions
                    </label>
                  </div>
                </div>
   
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="submit_btn" name="submit_btn" type="submit">Registrar</button>
   
                <div class="text-center mt-4 font-weight-light">
                  Ya tienes una cuenta? <a href="{{ asset('admin') }}" class="text-primary">Iniciar Sesión</a>
                </div>
              {!! Form::close() !!}              
            </div>
          </div>
          <div class="col-lg-6 register-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; Tcobro 2020. Todos los derechos reservados.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection

@section('footer-scripts')
    <!---<script>
        $(document).ready(function (e) {
            $('#accept_ploicy').change(function (e) {
                console.log('checknox == ', document.getElementById("accept_ploicy").checked)
                if (document.getElementById("accept_ploicy").checked) {
                  document.getElementById("submit_btn").removeAttribute('disabled')
                } else {
                  document.getElementById("submit_btn").setAttribute('disabled', true)
                }
            })
        });        
    </script>--->
@endsection