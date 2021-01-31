@extends('layouts.master')
@section('title')
Tcobro web | Crear Gastos
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h5>Crear gasto</h5>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('expense/store'), 'method' => 'post','class'=>'', 'name' =>
    'form',"enctype"=>"multipart/form-data")) !!}
    <div class="panel-body">
     
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Gasto *</strong></label>
            <div class="col-sm-8">
        {!! Form::select('expense_type_id',$types,null, array('class' => 'form-control','required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Monto *</strong></label>
            <div class="col-sm-8">
        {!! Form::number('amount',null, array('class' => 'form-control touchspin',
        'placeholder'=>"0.00",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Origen *</strong></label>
            <div class="col-sm-8">
              {!! Form::select('account_id',$chart_assets,null, array('class' => 'form-control
                    select2','placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Fecha *</strong></label>
            <div class="col-sm-8">
                   {!! Form::date('date',null, array('class' => 'form-control date-picker',
                      'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Frecuente</strong></label>
            <div class="col-sm-8">
        {!! Form::select('recurring', array('1'=>trans_choice('general.yes',1),'0'=>trans_choice('general.no',1)),0,
        array('class' => 'form-control','id'=>'recurring')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Notas</strong></label>
            <div class="col-sm-8">
        {!! Form::text('notes',null, array('class' => 'form-control','rows'=>'3')) !!}
            </div>
          </div>
        </div>
      </div>
      
      
<div id="recur">
    <div class="row">      
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Duracion *</strong></label>
            <div class="col-sm-8">
                {!! Form::number('recur_frequency',1, array('class' => 'form-control','id'=>'recurF')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Tipo *</strong></label>
            <div class="col-sm-8">
                {!! Form::select('recur_type',
                array('day'=>trans_choice('general.day',1).'(s)','week'=>trans_choice('general.week',1).'(s)','month'=>trans_choice('general.month',1).'(s)','year'=>trans_choice('general.year',1).'(s)'),'month',
                array('class' => 'form-control','id'=>'recurT')) !!}
            </div>
          </div>
        </div>
    </div>
    
    <div class="row">      
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Inicio *</strong></label>
            <div class="col-sm-8">
                {!! Form::date('recur_start_date',date("Y-m-d"), array('class' => 'form-control
                date-picker','id'=>'recur_start_date')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Final *</strong></label>
            <div class="col-sm-8">
                {!! Form::date('recur_end_date',null, array('class' => 'form-control
                date-picker','id'=>'recur_end_date')) !!}
            </div>
          </div>
        </div>
    </div>
</div>

      <div style="display: none;" class="form-group">
        {!!
        Form::label('files',trans_choice('general.file',2).'('.trans_choice('general.borrower_file_types',1).')',array('class'=>''))
        !!}
        {!! Form::file('files[]', array('class' => 'form-control', 'multiple'=>"",'rows'=>'3')) !!}

      </div>

      <p style="display: none;" class="bg-navy disabled color-palette">{{trans_choice('general.custom_field',2)}}</p>
      @foreach($custom_fields as $key)

      <div class="form-group">
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

          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a style="width:115px;" class="btn btn-light" href="{{ url('expense/data') }}">Cancelar</a>    
    {!! Form::close() !!}
    <!-- /.panel-body -->
  </div>
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')
<script>
$(document).ready(function(e) {
  if ($('#recurring').val() == '1') {
    $('#recur').show();
    $('#recurT').attr('required', 'required');
    $('#recur_start_date').attr('required', 'required');
    $('#recurF').attr('required', 'required');
  } else {
    $('#recur').hide();
    $('#recurT').removeAttr('required');
    $('#recur_start_date').removeAttr('required');
    $('#recurF').removeAttr('required');
  }
  $('#recurring').change(function() {
    if ($('#recurring').val() == '1') {
      $('#recur').show();
      $('#recurT').attr('required', 'required');
      $('#recurF').attr('required', 'required');
      $('#recur_start_date').attr('required', 'required');
    } else {
      $('#recur').hide();
      $('#recurT').removeAttr('required');
      $('#recur_start_date').removeAttr('required');
      $('#recurF').removeAttr('required');
    }
  })
})
</script>
@endsection