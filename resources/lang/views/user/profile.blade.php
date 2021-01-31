@extends('layouts.master')
@section('title')
T-Cobro Web | Perfil
@endsection
@section('content')
<div class="card box box-default">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Perfil</h4>

      <div class="heading-elements">

      </div>
    </div>

    {!! Form::open(array('url' => 'user/profile','class'=>'form-horizontal form-bordered form-label-stripped',"enctype"
    => "multipart/form-data")) !!}

    <div class="panel-body">
        
        
    <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Nombre: *</strong></label>
                <div class="col-sm-8">
                 {!! Form::text('first_name',$user->first_name,array('class'=>'form-control','required'=>'required')) !!}
                </div>
              </div>
            </div>    
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Apellido: *</strong></label>
                <div class="col-sm-8">
                 {!! Form::text('last_name',$user->last_name,array('class'=>'form-control','required'=>'required')) !!}
                </div>
              </div>
            </div>    
    </div>    
    
    <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Teléfono: </strong></label>
                <div class="col-sm-8">
                 {!! Form::text('phone',$user->phone,array('class'=>'form-control')) !!}
                </div>
              </div>
            </div>    
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Email *</strong></label>
                <div class="col-sm-8">
                 {!! Form::email('email',$user->email,array('class'=>'form-control','required'=>'required')) !!}
                </div>
              </div>
            </div>    
    </div> 
    

    <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Contraseña:</strong></label>
                <div class="col-sm-8">
        {!! Form::password('password',array('class'=>'form-control')) !!}
                </div>
              </div>
            </div>    
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Notas:</strong></label>
                <div class="col-sm-8">
        {!! Form::text('notes',$user->notes,array('class'=>'form-control','rows'=>'3')) !!}
        
          <!---Form::select('account_type',['expense'=>trans_choice('general.expense',1),'asset'=>trans_choice('general.asset',1),'equity'=>trans_choice('general.equity',1),'liability'=>trans_choice('general.liability',1),'income'=>trans_choice('general.income',1)],$chart_of_account->account_type,
          array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}--->        
                </div>
              </div>
            </div>    
    </div>     

      <div style="display: none;" class="form-group">
        {!! Form::label(trans('general.gender'),null,array('class'=>' control-label')) !!}
        {!! Form::password('rpassword',array('class'=>'form-control')) !!}
      </div>      
      <div style="display: none;" class="form-group">
        {!! Form::label(trans('general.gender'),null,array('class'=>' control-label')) !!}
        {!! Form::select('gender', array('Male' =>trans('general.male'), 'Female' =>
        trans('general.female')),$user->gender,array('class'=>'form-control')) !!}
      </div>
      <div style="display: none;" class="form-group">
        {!! Form::label(trans('general.address'),null,array('class'=>'control-label')) !!}
        {!! Form::textarea('address',$user->address,array('class'=>'form-control','rows'=>'3')) !!}
      </div>

    </div>
    <!---<div class="panel-footer">
      <div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
      </div>
    </div>--->
          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Aceptar</button>    
    {!! Form::close() !!}
  </div>
</div>
@endsection
@section('footer-scripts')
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
@endsection