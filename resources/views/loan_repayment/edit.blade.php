@extends('layouts.master')
@section('title')
Tcobro Web | Editar pago
@endsection
@section('content')
<div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <h5>Editar pago</h5>      

        {!! Form::open(array('url' => url('loan/repayment/'.$loan_transaction->id.'/update'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
      <p class="card-description">
      </p>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Monto *</strong></label>
            <div class="col-sm-8">
{!! Form::text('amount',number_format($loan_transaction->credit,2), array('class' => 'form-control touchspin', 'placeholder'=>"Ingrese el monto del pago sin comas",'required'=>'required')) !!}
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Forma *</strong></label>
            <div class="col-sm-8">
 {!! Form::select('repayment_method_id',$repayment_methods,$loan_transaction->repayment_method_id, array('class' => ' form-control','required'=>'required','id'=>'loanProduct')) !!}
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Fecha *</strong></label>
            <div class="col-sm-8">
 {!! Form::date('collection_date',$loan_transaction->date, array('class' => 'form-control date-picker', 'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" style="color:#22ae60;"><strong>Notas</strong></label>
            <div class="col-sm-8">
{!! Form::text('notes',$loan_transaction->notes, array('class' => 'form-control', 'rows'=>"4")) !!}
            </div>
          </div>
        </div>
      </div>


            @foreach($custom_fields as $key)

                <div class="form-group">
                    {!! Form::label($key->id,$key->name,array('class'=>'')) !!}
                    @if($key->field_type=="number")
                        <input type="number" class="form-control" name="{{$key->id}}"
                               @if($key->required==1) required
                               @endif value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first()->name}} @endif">
                    @endif
                    @if($key->field_type=="textfield")
                        <input type="text" class="form-control" name="{{$key->id}}"
                               @if($key->required==1) required
                               @endif value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first()->name}} @endif">
                    @endif
                    @if($key->field_type=="date")
                        <input type="text" class="form-control date-picker" name="{{$key->id}}"
                               @if($key->required==1) required
                               @endif value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first()->name}} @endif">
                    @endif
                    @if($key->field_type=="textarea")
                        <textarea class="form-control" name="{{$key->id}}"
                                  @if($key->required==1) required @endif>@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first()->name}} @endif</textarea>
                    @endif
                    @if($key->field_type=="decimal")
                        <input type="text" class="form-control touchspin" name="{{$key->id}}"
                               @if($key->required==1) required
                               @endif value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan_transaction->id)->where('category','repayments')->first()->name}} @endif">
                    @endif
                </div>
            @endforeach
      <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a style="width:115px;" class="btn btn-light" href="{{ url('repayment/data') }}">Cancelar</a>    
      {!! Form::close() !!}

    </div>
  </div>
</div>
@endsection
