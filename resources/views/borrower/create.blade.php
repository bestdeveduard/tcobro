@extends('layouts.master')
@section('title')
Nuevo Cliente
@endsection
@section('content')
<!---{{trans_choice('general.add',1)}} {{trans_choice('general.borrower',1)}}--->
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title ">Registrar nuevo cliente</h3>
      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('borrower/store'), 'method' => 'post', 'name' =>
    'form',"enctype"=>"multipart/form-data")) !!}
    <div class="panel-body">
      <div class="form-group">
        <p class="card-description">
        <h5 style="color:#46b979;">Datos personales</h5>
        </p>
        <input type="hidden" name="title" id="title" value="Mr"></input>
        <input type="hidden" name="gender" id="gender" value="male"></input>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="right">{{trans_choice('general.first_name',1)}} *</label>
              <div class="col-sm-9">
                {!! Form::text('first_name',null, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.first_name',1),'required'=>'required')) !!}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="right">{{trans_choice('general.last_name',1)}} *</label>
              <div class="col-sm-9">
                {!! Form::text('last_name',null, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.last_name',1),'required'=>'required')) !!}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label" align="right">ID/Pasaporte</label>
              <div class="col-sm-8">
                {!! Form::text('unique_number',null, array('class' =>'form-control',
                'placeholder'=>trans_choice('general.unique_number',1),'required'=>'required')) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
      <p class="card-description">
      <h5 style="color:#46b979;">Datos de contacto</h5>
      </p>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Direccion *</label>
              <div class="col-sm-8">
                {!! Form::text('address',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">{{trans_choice('general.country',1)}}</label>
              <div class="col-sm-9">
                {!!
                Form::select('country_id',$countries,\App\Models\Setting::where('setting_key','company_country')->first()->setting_value,array('class'=>'form-control
                select2','placeholder'=>'','required'=>'required')) !!}
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Telefono movil *</label>
              <div class="col-sm-8">
                {!! Form::text('mobile',null, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.numbers_only',1))) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Telefono fijo</label>
              <div class="col-sm-9">
                {!! Form::text('phone',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {!! Form::text('email',null, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.email',1))) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Geolocalizacion:</label>
              <div class="col-sm-2">
                <a class="btn btn-secondary" onclick="showMap()">Mapa</a>
              </div>
              <div class="col-sm-7">
                <div id="map-canvas" style="display: none; width: 100%; height: 130px;" data-lat="none" data-lng="none" data-zoom="16"
                  data-style="6"></div>
                  <input type="hidden" id="geolocation" name="geolocation"></input>
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="card-description">
      <h5 style="color:#46b979;">Informacion Laboral</h5>
      </p>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">{{trans_choice('general.business',1)}}</label>
              <div class="col-sm-8">
                {!! Form::text('business_name',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">{{trans_choice('Telefono Empresa',1)}}</label>
              <div class="col-sm-9">
                {!! Form::text('phone_business',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">{{trans_choice('general.working_status',1)}}</label>
              <div class="col-sm-8">
                {!!
                Form::select('working_status',array('Employee'=>trans_choice('general.Employee',1),'Owner'=>trans_choice('general.Owner',1),'Student'=>trans_choice('general.Student',1),'Overseas
                Worker'=>trans_choice('general.Overseas
                Worker',1),'Pensioner'=>trans_choice('general.Pensioner',1),'Unemployed'=>trans_choice('general.Unemployed',1)),null,
                array('class' => 'form-control',)) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tiempo laborando</label>
              <div class="col-sm-9">
                {!! Form::text('working_time',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Ingresos $</label>
              <div class="col-sm-8">
                {!! Form::number('ingresos',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="card-description">
      <h5 style="color:#46b979;">Informacion codeudor</h5>
      </p>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Referencias</label>
              <div class="col-sm-8">
                {!! Form::text('referencia_1',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Telefono</label>
              <div class="col-sm-9">
                {!! Form::text('company_phone',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
        </div>
      </div>

      <p class="card-description">
      <h5 style="color:#46b979;">Archivos</h5>
      </p>
      <div class="form-group">
        <label>Adjuntar imagen</label>
        <div class="input-group col-xs-12">
          <input type="text" class="form-control file-upload-info" style="border-bottom-style: solid;" disabled
            placeholder="Cargar documento">
          <span class="input-group-append">
            <button class="file-upload-browse btn btn-primary" type="button">Subir</button>
            <input type="file" name="photo" class="file-upload-default"
              style="visibility: visible; position: absolute; z-index: 2; opacity: 0; height: 45px; width: 90px;">
          </span>
        </div>
      </div>
      <div class="form-group">
        <label>Adjuntar Documentos</label>
        <div class="input-group col-xs-12">
          <input type="text" class="form-control file-upload-info" style="border-bottom-style: solid;" disabled
            placeholder="Cargar documento">
          <span class="input-group-append">
            <button class="file-upload-browse btn btn-primary" type="button">Subir</button>
            <input type="file" name="files[]" class="file-upload-default"
              style="visibility: visible; position: absolute; z-index: 2; opacity: 0; height: 45px; width: 90px;">
          </span>
        </div>
      </div>
      <div class="form-group">
        <label for="exampleTextarea1">Notas</label>
        {!! Form::textarea('notes',null, array('class' => 'form-control', 'placeholder'=>"",'rows'=>'3')) !!}
      </div>

      <div class="form-group" style="display: none;">
        <div class="row">
          <div class="col-md-4">
            {!! Form::label('whatsapp_enabled',trans('Envio mensajes Whatsapp'),array('class'=>'control-label')) !!}
            {!! Form::select('whatsapp_enabled',array('0'=>trans('general.no'), '1'=>trans('general.yes')),
            null, array('class'=>'form-control','required'=>'required')) !!}
          </div>
        </div>
      </div>

      <p style="display: none;" class="bg-navy disabled color-palette">{{trans_choice('general.login',1)}}
        {{trans_choice('general.detail',2)}}</p>
      <div style="display: none;" class="form-group">
        <div class="row">
          <div class="col-md-4">
            {!! Form::label('username',trans_choice('general.username',1),array('class'=>'')) !!}
            {!! Form::text('username',null, array('class' => 'form-control', 'placeholder'=>"")) !!}
          </div>
          <div class="col-md-4">
            {!! Form::label('password',trans_choice('general.password',1),array('class'=>'')) !!}
            {!! Form::password('password', array('class' => 'form-control', 'placeholder'=>"")) !!}
          </div>
          <div class="col-md-4">
            {!! Form::label('repeatpassword',trans_choice('general.repeat_password',1),array('class'=>'')) !!}
            {!! Form::password('repeatpassword', array('class' => 'form-control', 'placeholder'=>"")) !!}
          </div>
        </div>
      </div>
      <div class="form-group" style="display: none;">
        {!! Form::label('loan_officers',trans_choice('general.loan_officer_access',2),array('class'=>'')) !!}
        {!! Form::select('loan_officers[]',$user,null, array('class' => 'form-control select2','multiple'=>'')) !!}
      </div>
      <p style="display: none;" class="bg-navy disabled color-palette">{{trans_choice('general.custom_field',2)}}</p>
      @foreach($custom_fields as $key)

      <div style="display: none;" class="form-group">
        {!! Form::label($key->id,$key->name,array('class'=>'')) !!}
        @if($key->field_type=="number")
        <input type="number" class="form-control" name="{{$key->id}}" @if($key->required==1) required @endif>
        @endif
        @if($key->field_type=="textfield")
        <input type="text" class="form-control" name="{{$key->id}}" @if($key->required==1) required @endif>
        @endif
        @if($key->field_type=="date")
        <input type="text" class="form-control date-picker" name="{{$key->id}}" @if($key->required==1) required @endif>
        @endif
        @if($key->field_type=="textarea")
        <textarea class="form-control" name="{{$key->id}}" @if($key->required==1) required @endif></textarea>
        @endif
        @if($key->field_type=="decimal")
        <input type="text" class="form-control touchspin" name="{{$key->id}}" @if($key->required==1) required @endif>
        @endif
      </div>
      @endforeach
    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
      <div>
        <button type="submit" class="btn btn-info pull-right">{{trans_choice('general.save',1)}}</button>

        <a class="btn btn-secondary" href="{{url('borrower/data')}}">Cancelar</a>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>

<script src="{{ asset('assets/themes/limitless/js/borrower_map.js') }}"></script>
<script type="text/javascript">
  function showMap() {
    $('#map-canvas').css('display', 'block');
  }
</script>
<!-- /.box -->
@endsection