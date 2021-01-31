@extends('layouts.master')
@section('title')
T-Cobro Web | Base
@endsection
@section('content')
<div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <h5>Crear base</h5>      

      {!! Form::open(array('url' => url('baseuser/store'), 'method' => 'post', 'name' => 'form','class'=>'form-sample'))
      !!}
      <p class="card-description">
      </p>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center">Ruta: *</label>
            <div class="col-sm-9">
              <select class="form-control" name="route_id" id="route_id" required="true">
                <option value="" selected disabled>Seleccionar ruta</option>
                @foreach($routes as $route)
                <option value="{{$route->id}}">{{$route->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center">Usuario: *</label>
            <div class="col-sm-9">
              <select class="form-control" required="true" name="user_id" id="user_id">
                <option value="" selected disabled>Seleccionar usuario</option>
                @foreach($users as $user)
                <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center">Monto base: *</label>
            <div class="col-sm-9">
              <input type="number" name="amount" id="amount" class="form-control" placeholder="$0.00" required="true" required="true" />
            </div>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-success mr-2">Procesar</button>
      <a class="btn btn-secondary" href="{{ url('baseuser/data') }}">Cancelar</a>

      {!! Form::close() !!}

    </div>
  </div>
</div>
@endsection

@section('footer-scripts')
@endsection