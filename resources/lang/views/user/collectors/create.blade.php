@extends('layouts.master')
@section('title')
Collectors
@endsection
@section('content')
<div class="card">
  <div class="card-body">

    @if(Session::has('flash_notification.message'))
    <script>
    toastr. {
      {
        Session::get('flash_notification.level')
      }
    }('{{ Session::get("flash_notification.message") }}', 'Response Status')
    </script>
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

    <h5>New User collector</h5>
    {!! Form::open(array('url' => url('user/collector/store'), 'method' => 'post', 'name' => 'form','class'=>'pt-3
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
            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Anton"
              required="true" />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Last name *</label>
          <div class="col-sm-9">
            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Jerker"
              required="true" />
          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Genero *</label>
          <div class="col-sm-9">
            <select class="form-control" name="gender" id="gender" required="true">
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
            <input type="tel" name="phone" id="phone" class="form-control" placeholder="+18099950460" required="true" />
          </div>
        </div>
      </div>
    </div>

    <br>
    <h5 style="color:#46b979;">Login information</h5>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Email *</label>
          <div class="col-sm-9">
            <input type="email" name="email" id="email" class="form-control" required="true"
              placeholder="Example@gmail.com" />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Password *</label>
          <div class="col-sm-9">
            <input type="password" name="password" id="password" class="form-control" placeholder="******"
              required="true" />
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
              checked>
            Automatico
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="1">
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
            <input type="time" name="start_time" id="start_time" class="form-control" required="true" placeholder=" " />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Time end manual</label>
          <div class="col-sm-6">
            <input type="time" name="end_time" id="end_time" class="form-control" placeholder=" " />
          </div>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary mr-2">Create</button>
    <a href="{{ url('user/collector/data') }}" class="btn btn-light">Cancel</a>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@section('footer-scripts')

@endsection