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

              <center>                     
                <h4>Crear cuenta nueva</h4>
                <h6 class="font-weight-light">Registrese en breves pasos</h6>
              </center>              
              
              {!! Form::open(array('url' => url('register'), 'method' => 'post', 'name' => 'form','class'=>'pt-3')) !!}
                <label class="form-check-label text-muted">Datos personales</label>
                <br>
                <br>

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

                <div class="form-group">
                {!! Form::email('email', null, array('class' => 'form-control', 'placeholder'=>'E-mail *','required'=>'required', 'id'=>'email')) !!}
                </div>
                <div class="form-group">
                {!! Form::number('phone', null, array('class' => 'form-control', 'placeholder'=>'Telefono *','required'=>'required', 'id'=>'phone')) !!}
                </div>  

                <div class="form-group">
                  <select class="form-control form-control-lg" id="country_id" name="country_id" placeholder="Pais *">
                    <option value="" disabled selected>Pais *</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->id == 61) selected @endif>{{$country->name}}</option>
                    @endforeach
                  </select>
                </div>

                <label class="form-check-label text-muted">Datos para iniciar seccion</label>
                <br>
                <br>

                <div class="form-group">
                {!! Form::text('user_name', null, array('class' => 'form-control', 'placeholder'=>'Usuario *','required'=>'required', 'id' => 'user_name')) !!}
                </div>                

                <div class="form-group">                
                  <input type="password" class="form-control form-control-lg" id="password" name='password' placeholder="Contraseña *">
                </div>

                <div class="form-group">                
                  <input type="password" class="form-control form-control-lg" id="rpassword" name='rpassword' placeholder="Confirmar contraseña *">
                </div>

                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="styled" id="accept_ploicy" name="accept_ploicy">
                      Acepto todos los Términos y condiciones
                    </label>
                  </div>
                </div>

                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="submit_btn" name="submit_btn" disabled="true" type="submit">Registrarme</button>
                </div>

                <div class="mt-3">
                  <a class="btn btn-block btn-secondary btn-lg font-weight-medium auth-form-btn" href="{{ asset('admin') }}" type="submit">Cancelar</a>
                </div>

                <div class="text-center mt-4 font-weight-light">
                  Ya tienes una cuenta? <a href="{{ asset('admin') }}" class="text-primary">Iniciar seccion</a>
                </div>
              
              {!! Form::close() !!}

            </div>
          </div>
        </div>
      </div>      
    </div>    
  </div>    
@endsection

@section('footer-scripts')
    <script>
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
    </script>
@endsection