@extends('layouts.master')
@section('title')
Tcobro web | Crear Capital
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h5>Crear capital</h5>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('capital/store'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
    <div class="panel-body">

      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Monto *</strong></label>
            <div class="col-sm-8">
          {!! Form::number('amount',null, array('class' => 'form-control touchspin', 'placeholder'=>"0.00",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Fecha *</strong></label>
            <div class="col-sm-8">
          {!! Form::date('date',date("Y-m-d"), array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

      <div  style="display: none;" class="form-group">
        {!! Form::label('credit_account_id',trans_choice('Origen',1),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-5">
          {!! Form::select('credit_account_id',$chart,null, array('class' => 'form-control select2',
          'placeholder'=>"")) !!}
        </div>
      </div>
      <div  style="display: none;" class="form-group">
        {!! Form::label('debit_account_id',trans_choice('Destino',1),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-5">
          {!! Form::select('debit_account_id',$chart,null, array('class' => 'form-control select2',
          'placeholder'=>"")) !!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Notas *</strong></label>
            <div class="col-sm-8">
          {!! Form::text('notes',null, array('class' => 'form-control', 'rows'=>"4")) !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.panel-body -->

          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a style="width:115px;" class="btn btn-light" href="{{ url('capital/data') }}">Cancelar</a>     
    {!! Form::close() !!}
  </div>
</div>
<!-- /.box -->
@endsection