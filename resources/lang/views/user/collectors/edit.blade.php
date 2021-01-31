@extends('layouts.master')
@section('title')
T-Cobro Web | Editar cobrador
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <h5>Edit Collector</h5>
    {!! Form::open(array('url' => url('user/collector/'.$user->id.'/update'), 'method' => 'post', 'name' => 'form','class'=>'pt-3
    form-sample')) !!}
    <p class="card-description">
    <h5 style="color:#46b979;">Personal information</h5>
    <br>
    </p>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Name *</label>
          <div class="col-sm-9">
            <input type="text" name="first_name" id="first_name" value="{{$user->first_name}}" class="form-control" placeholder="Anton" required="true" />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Last name *</label>
          <div class="col-sm-9">
            <input type="text" name="last_name" id="last_name" value="{{$user->last_name}}" class="form-control" placeholder="Jerker" required="true" />
          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Genero *</label>
          <div class="col-sm-9">
            <select class="form-control" name="gender" id="gender">
              <option value="" selected disabled>Seleccione</option>
              <option value="Male">Masculino</option>
              <option value="Female">Femenino</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Phone *</label>
          <div class="col-sm-9">
            <input type="tel" name="phone" id="phone" value="{{$user->phone}}" class="form-control" placeholder="+18099950460" required="true" />
          </div>
        </div>
      </div>
    </div>

    <br>
    <h5 style="color:#46b979;">Login information</h5>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Email </label>
          <div class="col-sm-9">
            <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control" required="true" placeholder="Example@gmail.com" />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Password</label>
          <div class="col-sm-9">
            <input type="password" name="password" id="password" class="form-control" placeholder="******" />
          </div>
        </div>
      </div>
    </div>

    <h5 style="color:#46b979;">Operation time</h5>
    <div class="col-md-6">
      <div class="form-group">
        <div class="form-check">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="0"
              @if($user->operation_type == 0) checked @endif>
            Automatico
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="1" @if($user->operation_type == 1) checked @endif>
            Manual
          </label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Time star manual</label>
          <div class="col-sm-6">
            <input type="time" name="start_time" id="start_time" class="form-control" required="true" placeholder=" " value="{{$user->start_time}}"/>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Time end manual</label>
          <div class="col-sm-6">
            <input type="time" name="end_time" id="end_time" class="form-control" placeholder=" " value="{{$user->end_time}}"/>
          </div>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary mr-2">Update</button>
    <a href="{{ url('user/collector/data') }}" class="btn btn-light">Cancel</a>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@section('footer-scripts')

@endsection