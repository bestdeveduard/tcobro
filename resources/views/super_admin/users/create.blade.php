@extends('layouts.master')
@section('title')
    {{ trans_choice('general.user',2) }}
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

        <h5>New user</h5>
        
        {!! Form::open(array('url' => url('super_admin/saveadmin'), 'method' => 'post', 'name' => 'form','class'=>'form-sample')) !!}
          <p class="card-description">
            <h5 style="color:#46b979;">Personal information</h5>
          </p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">name *</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="first_name" id="first_name" required="true" placeholder="Anton"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Jerker" required="true"/>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Email *</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" name="email" id="email" placeholder="example@hotmail.com" required="true"/>
                </div>
              </div>
            </div>
            

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Country</label>
                <div class="col-sm-9">
                  <select class="form-control" name="country_id" id="country_id" required="true">
                    <option disabled selected>Select</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->id == 61) selected @endif>{{$country->name}}</option>
                    @endforeach                    
                  </select>
                </div>
              </div>
            </div>                      
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Phone number *</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="+(999) 999-9999" required="true"/>
                </div>
              </div>
            </div>
            

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Select plan</label>
                <div class="col-sm-9">
                  <select class="form-control" class="form-control" name="plan_id" id="plan_id">
                    @foreach($plans as $plan)
                    <option value="{{$plan->id}}">{{$plan->name}} - {{$plan->amount}}</option>
                    @endforeach                    
                  </select>
                </div>
              </div>
            </div>                      
          </div>              

          <p class="card-description">
            <h5 style="color:#46b979;">Login information</h5>
          </p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">User</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="user_name" id="user_name" placeholder="" required="true"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="password" id="password" placeholder="******" required="true"/>
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary mr-2">Create</button>
          <a class="btn btn-secondary" href="{{ url('super_admin/admin') }}">Cancel</a>

        {!! Form::close() !!}

      </div>
    </div>
  </div>

@endsection

@section('footer-scripts') 
@endsection
