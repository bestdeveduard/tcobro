@extends('layouts.master')
@section('title')
Tcobro Web | Base
@endsection
@section('content')
<div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <h5>Editar base</h5>
      
      {!! Form::open(array('url' => url('baseuser/update'), 'method' => 'post', 'name' => 'form','class'=>'form-sample')) !!}

        <p class="card-description">
          <input type="hidden" name="base_id" id="base_id" value="{{$base->id}}"></input>
        </p>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Ruta *</strong></label>
              <div class="col-sm-8">
                <select class="form-control" name="route_id" id="route_id" required="true">
                <option value="" selected disabled>Seleccionar ruta</option>
                @foreach($routes as $route)
                <option value="{{$route->id}}" @if($base->route_id == $route->id) selected @endif>{{$route->name}}</option>
                @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Usuario *</strong></label>
              <div class="col-sm-8">
                <select class="form-control" name="user_id" id="user_id" required="true">
                <option value="" selected disabled>Seleccionar usuario</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" @if($base->user_id == $user->id) selected @endif>{{$user->first_name}} {{$user->last_name}}</option>
                @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Monto *</strong></label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="amount" id="amount" placeholder="$0.00" value="{{$base->amount}}" required="true" />
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Nota</strong></label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="amount" id="amount" placeholder=" " value="{{$base->note}}"/>
              </div>
            </div>
          </div>          
        </div>

          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a style="width:115px;" class="btn btn-light" href="{{ url('baseuser/data') }}">Cancelar</a>        
      
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection

@section('footer-scripts')
@endsection