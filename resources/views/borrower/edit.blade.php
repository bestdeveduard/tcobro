@extends('layouts.master')
@section('title')
{{trans_choice('general.edit',1)}} {{trans_choice('general.borrower',1)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title ">{{trans_choice('general.edit',1)}} {{trans_choice('general.borrower',1)}}</h3>
      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('borrower/'.$borrower->id.'/update'), 'method' => 'post', 'name' =>
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
                {!! Form::text('first_name',$borrower->first_name, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.first_name',1),'required'=>'required')) !!}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" align="right">{{trans_choice('general.last_name',1)}} *</label>
              <div class="col-sm-9">
                {!! Form::text('last_name',$borrower->last_name, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.last_name',1),'required'=>'required')) !!}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label" align="right">ID/Pasaporte</label>
              <div class="col-sm-8">
                {!! Form::text('unique_number',$borrower->unique_number, array('class' =>'form-control',
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
                {!! Form::text('address',$borrower->address, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">{{trans_choice('general.country',1)}}</label>
              <div class="col-sm-9">
                {!!
                Form::select('country_id',$countries,$borrower->country_id,array('class'=>'form-control
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
                {!! Form::text('mobile',$borrower->mobile, array('class' => 'form-control',
                'placeholder'=>trans_choice('general.numbers_only',1))) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Telefono fijo</label>
              <div class="col-sm-9">
                {!! Form::text('phone',$borrower->phone, array('class' => 'form-control', 'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-8">
                {!! Form::text('email',$borrower->email, array('class' => 'form-control',
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
                {!! Form::text('business_name',$borrower->business_name, array('class' => 'form-control',
                'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">{{trans_choice('Telefono Empresa',1)}}</label>
              <div class="col-sm-9">
                {!! Form::text('phone_business',$borrower->phone_business, array('class' => 'form-control',
                'placeholder'=>"")) !!}
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
                Worker',1),'Pensioner'=>trans_choice('general.Pensioner',1),'Unemployed'=>trans_choice('general.Unemployed',1)),$borrower->working_status,
                array('class' => 'form-control',)) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tiempo laborando</label>
              <div class="col-sm-9">
                {!! Form::text('working_time',$borrower->working_time, array('class' => 'form-control',
                'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Ingresos $</label>
              <div class="col-sm-8">
                {!! Form::number('ingresos',$borrower->ingresos, array('class' => 'form-control', 'placeholder'=>""))
                !!}
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
                {!! Form::text('referencia_1',$borrower->referencia_1, array('class' => 'form-control',
                'placeholder'=>"")) !!}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Telefono</label>
              <div class="col-sm-9">
                {!! Form::text('company_phone',$borrower->company_phone, array('class' => 'form-control',
                'placeholder'=>"")) !!}
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
          @if(!empty($borrower->photo))
          <a class="fancybox" rel="group" href="{{ url(asset('uploads/'.$borrower->photo)) }}"> <img
              src="{{ url(asset('uploads/'.$borrower->photo)) }}" width="120" /></a>
          @else
          <input type="text" class="form-control file-upload-info" style="border-bottom-style: solid;" disabled
            placeholder="Cargar documento">
          @endif

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
          @foreach(unserialize($borrower->files) as $key=>$value)
          <span id="file_{{$key}}_span">

            <a href="{!!asset('uploads/'.$value)!!}" target="_blank">
              <!---{!!  $value!!}--->Visualizar
            </a>
            <button value="{{$key}}" id="{{$key}}" onclick="delete_file(this)" type="button"
              class="btn btn-danger btn-xs">
              <i class="fa fa-trash"></i></button>
          </span><br>
          @endforeach
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
        {!! Form::textarea('notes',$borrower->notes, array('class' => 'form-control', 'placeholder'=>"",'rows'=>'3'))
        !!}
      </div>

      <div class="form-group" style="display: none;">
        <div class="row">
          <div class="col-md-4">
            {!! Form::label('whatsapp_enabled',trans('Envio mensajes Whatsapp'),array('class'=>'control-label')) !!}
            {!! Form::select('whatsapp_enabled',array('0'=>trans('general.no'), '1'=>trans('general.yes')),
            $borrower->whatsapp_enabled, array('class'=>'form-control','required'=>'required')) !!}
          </div>
        </div>
      </div>

      <p style="display: none;" class="bg-navy disabled color-palette">{{trans_choice('general.login',1)}}
        {{trans_choice('general.detail',2)}}</p>
      <div style="display: none;" class="form-group">
        <div class="row">
          <div class="col-md-4">
            {!! Form::label('username',trans_choice('general.username',1),array('class'=>'')) !!}
            {!! Form::text('username',$borrower->username, array('class' => 'form-control', 'placeholder'=>"")) !!}
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

      <div class="form-group">
        {!! Form::label($key->id,$key->name,array('class'=>'')) !!}
        @if($key->field_type=="number")
        <input type="number" class="form-control" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first()->name}}
        @endif">
        @endif
        @if($key->field_type=="textfield")
        <input type="text" class="form-control" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first()->name}}
        @endif">
        @endif
        @if($key->field_type=="date")
        <input type="text" class="form-control date-picker" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first()->name}}
        @endif">
        @endif
        @if($key->field_type=="textarea")
        <textarea class="form-control" name="{{$key->id}}"
          @if($key->required==1) required @endif>@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first()->name}} @endif</textarea>
        @endif
        @if($key->field_type=="decimal")
        <input type="text" class="form-control touchspin" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$borrower->id)->where('category','borrowers')->first()->name}}
        @endif">
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
<!-- /.box -->
@endsection

@section('footer-scripts')
<script>
function delete_file(e) {
  var id = e.id;
  swal({
    title: 'Are you sure?',
    text: '',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ok',
    cancelButtonText: 'Cancel'
  }).then(function() {
    $.ajax({
      type: 'GET',
      url: "{!!  url('borrower/'.$borrower->id) !!}/delete_file?id=" + id,
      success: function(data) {
        $("#file_" + id + "_span").remove();
        swal({
          title: 'Deleted',
          text: 'File successfully deleted',
          type: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ok',
          timer: 2000
        })
      }
    });
  })

}
</script>
<script src="{{ asset('assets/themes/limitless/js/borrower_map.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var geolocation = "<?php echo $borrower->geolocation; ?>";
    var latlng = geolocation.split(",");
    $('#map-canvas').attr("data-lat", latlng[0]);
	  $('#map-canvas').attr("data-lng", latlng[1]);
  });

  function showMap() {
    $('#map-canvas').css('display', 'block');
  }
</script>
@endsection