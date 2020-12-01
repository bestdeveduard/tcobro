@extends('layouts.master')
@section('title')
    {{ trans_choice('general.user',2) }}
@endsection
@section('content')

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h5>Crear Plan</h5>
        
        {!! Form::open(array('url' => url('super_admin/makeplan'), 'method' => 'post', 'name' => 'form','class'=>'pt-3 form-sample')) !!}
          <p class="card-description">
          </p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Plan Name: *</label>
                <div class="col-sm-9">
                <input type="text" name="plan_name" id="plan_name" class="form-control" placeholder="Plan 1" required="true"/>
                </div>
              </div>
            </div>            

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Duration (days): *</label>
                <div class="col-sm-9">
                <input type="number" name="plan_duration" id="plan_duration" class="form-control" placeholder="0" required="true"/>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Quantity User: *</label>
                <div class="col-sm-9">
                <input type="number" name="limited_users" id="limited_users" class="form-control" placeholder="0" required="true"/>
                </div>
              </div>
            </div>            

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Quantity Route: *</label>
                <div class="col-sm-9">
                <input type="number" name="limited_routes" id="limited_routes" class="form-control" placeholder="0" required="true"/>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Amount: *</label>
                <div class="col-sm-9">
                  <input type="tel" name="plan_amount" id="plan_amount" class="form-control" placeholder="$0.00" required="true"/>
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Crear</button>
          <a class="btn btn-secondary" href="{{ url('super_admin/plans') }}">Cancelar</a>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
  
@endsection
