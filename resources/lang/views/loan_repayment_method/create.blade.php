@extends('layouts.master')
@section('title')
T-Cobro Web | Añadir método de pago
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">Método de pago</h2>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('loan/loan_repayment_method/store'), 'method' => 'post', 'class' =>
    'form-horizontal')) !!}
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Nombre *</strong></label>
                <div class="col-sm-8">
          {!! Form::text('name',null, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Clasificacion *</strong></label>
                <div class="col-sm-8">
              {!!Form::select('type_order',array('1'=>trans_choice('Pagos en efectivo',1),'0'=>trans_choice('Otros pagos',1)),null, array('class' => 'form-control',"id"=>"type_order",'required'=>'required')) !!}          
                  </div>
              </div>
            </div>            
          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Procesar</button>
          <a style="width:115px;" class="btn btn-light" href="{{url('loan/loan_repayment_method/data')}}">Cancelar</a>      
    <!-- /.panel-body -->
    <div class="panel-footer">
      <!---<div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
        <a class="btn btn-secondary" style="margin-right: 11px;"
          href="{{url('loan/loan_repayment_method/data')}}">Cancelar</a>
      </div>--->
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- /.box -->
@endsection