@extends('layouts.master')
@section('title')
T-Cobro Web| Crear usuario
@endsection
@section('content')

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">

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

        <h4>Nuevo usuario</h4>
        <br>
        {!! Form::open(array('url' => url('super_admin/saveadmin'), 'method' => 'post', 'name' => 'form','class'=>'form-sample')) !!}
          <p class="card-description">
            <h5 style="color:#46b979;">Informacion Personal</h5>
          </p>
          <br>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Nombre *</strong></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="first_name" id="first_name" required="true" placeholder="Jose"/>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Apellido *</strong></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Perez" required="true"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Email *</strong></label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" name="email" id="email" placeholder="example@hotmail.com" required="true"/>
                </div>
              </div>
            </div>
            

            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Pais *</strong></label>
                <div class="col-sm-8">
                  <select class="form-control" name="country_id" id="country_id" required="true">
                    <option disabled selected>Seleccione</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->id == 61) selected @endif>{{$country->name}}</option>
                    @endforeach                    
                  </select>
                </div>
              </div>
            </div>                      
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Telefono *</strong></label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="+(999) 999-9999" required="true"/>
                    
                </div>
              </div>
            </div>
            

            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Planes *</strong></label>
                <div class="col-sm-8">
                  <select class="form-control" class="form-control" name="plan_id" id="plan_id">
                    @foreach($plans as $plan)
                    <option value="{{$plan->id}}">{{$plan->name}} - ${{$plan->amount}}</option>
                    @endforeach                    
                  </select>
                </div>
              </div>
            </div>                      
          </div>              

          <p class="card-description">
            <h5 style="color:#46b979;">Informacion de acceso</h5>
          </p>
          <br>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Usuario *</strong></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="user_name" id="user_name" placeholder="" required="true"/>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Password *</strong></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="password" id="password" placeholder="******" required="true"/>
                </div>
              </div>
            </div>
          </div>

          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a style="width:115px;" class="btn btn-light" href="{{ url('super_admin/admin') }}">Cancelar</a>

        {!! Form::close() !!}

      </div>
    </div>
  </div>

@endsection

@section('footer-scripts') 
@endsection
