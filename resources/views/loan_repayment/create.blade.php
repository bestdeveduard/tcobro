@extends('layouts.master')
@section('title')Tcobro | Pagar
@endsection
@section('content')
<!---<link rel="icon" href="http://jgconsultoreslegales.com/favicon.ico" type="image/x-icon" />--->
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">Nuevo Pago
        <!---{{trans_choice('general.add',1)}} {{trans_choice('general.repayment',1)}}--->
      </h2>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('loan/'.$loan->id.'/repayment/store'), 'method' => 'post', 'class' =>
    'form-horizontal')) !!}
    <div class="panel-body">

      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Monto *</strong></label>
            <div class="col-sm-8">
          {!! Form::number('amount',null, array('class' => 'form-control touchspin', 'placeholder'=>"$0.00",'required'=>'required')) !!}
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Forma *</strong></label>
            <div class="col-sm-8">
          {!! Form::select('repayment_method_id',$repayment_methods,null, array('class' => '
          form-control','required'=>'required','id'=>'loanProduct')) !!}
            </div>
          </div>
        </div>
      </div>
      
      <!-- Normal and Capital -->
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Tipo *</strong></label>
            <div class="col-sm-8">
          <select id="repayment_type" name="repayment_type" class="form-control">
            <option value="1">Pagar cuota</option>
            <option value="2">Abono a Capital</option>
            <option value="1">Abono a interes</option>
          </select>
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Fecha *</strong></label>
            <div class="col-sm-8">
          {!! Form::date('collection_date',date("Y-m-d"), array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!} 
            </div>
          </div>
        </div>
      </div>          
          
          
          
      <div style="display: none;" class="form-group">
        {!! Form::label('receipt',trans_choice('general.receipt',1),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-5">
          {!! Form::text('receipt',"CD" . $loan->id . "0" . $loan->loan_product->id . date("Ymd") . date("his"),
          array('class' => 'form-control', 'placeholder'=>"", 'required'=>'required')) !!}
        </div>
      </div>


    <div  style="display: none;" class="row">
     <div class="col-md-4">
      <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Nota *</strong></label>
            <div class="col-sm-8">
          {!! Form::text('notes',null, array('class' => 'form-control', 'rows'=>"4")) !!}
        </div>
      </div>
     </div>
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
      <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Confirmar</button>
      <a style="width:115px;" class="btn btn-light" href="{{ url('repayment/data') }}">Cancelar</a>
    {!! Form::close() !!}
  </div>
</div>
<!-- /.box -->
@endsection