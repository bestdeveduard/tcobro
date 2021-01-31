@extends('layouts.master')
@section('title')
Tcobro Web | Editar gasto
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h5>Editar gasto</h5>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('expense/'.$expense->id.'/update'), 'method' => 'post','class'=>'', 'name' =>
    'form',"enctype"=>"multipart/form-data")) !!}
    <div class="panel-body">
        
        
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Gasto *</strong></label>
            <div class="col-sm-8">
        {!! Form::select('expense_type_id',$types,$expense->expense_type_id, array('class' =>
        'form-control','required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Monto *</strong></label>
            <div class="col-sm-8">
        {!! Form::text('amount',number_format($expense->amount, 2), array('class' => 'form-control touchspin',
        'placeholder'=>"",'required'=>'required')) !!}
        
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Origen *</strong></label>
            <div class="col-sm-8">
        {!! Form::select('account_id',$chart_assets,$expense->account_id, array('class' => 'form-control
        select2','placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Fecha *</strong></label>
            <div class="col-sm-8">
        {!! Form::date('date',$expense->date, array('class' => 'form-control date-picker',
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
        {!! Form::select('recurring',
        array('1'=>trans_choice('general.yes',1),'0'=>trans_choice('general.no',1)),$expense->recurring, array('class'
        => 'form-control','id'=>'recurring')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Notas</strong></label>
            <div class="col-sm-8">
        {!! Form::text('notes',$expense->notes, array('class' => 'form-control','rows'=>'3')) !!}
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
                {!! Form::number('recur_frequency',$expense->recur_frequency, array('class' =>
                'form-control','id'=>'recurF')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Tipo *</strong></label>
            <div class="col-sm-8">
                {!! Form::select('recur_type',
                array('day'=>'Diario','week'=>'Semanal','month'=>'Mensual','year'=>'Anual'),$expense->recur_type,
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
                {!! Form::date('recur_start_date',$expense->recur_start_date, array('class' => 'form-control
                date-picker','id'=>'recur_start_date')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Final *</strong></label>
            <div class="col-sm-8">
                {!! Form::date('recur_end_date',$expense->recur_end_date, array('class' => 'form-control
                date-picker','id'=>'recur_end_date')) !!}
            </div>
          </div>
        </div>
    </div>
      </div>

      <div  style="display: none;" class="form-group">
        {!!
        Form::label('files',trans_choice('general.file',2).'('.trans_choice('general.borrower_file_types',1).')',array('class'=>''))
        !!}
        {!! Form::file('files[]', array('class' => 'form-control', 'multiple'=>"",'rows'=>'3')) !!}
        <div class="col-sm-12">
          @foreach(unserialize($expense->files) as $key=>$value)
          <span id="file_{{$key}}_span"><a href="{!!asset('uploads/'.$value)!!}" target="_blank">{!! $value!!}</a>
            <button value="{{$key}}" id="{{$key}}" onclick="delete_file(this)" type="button"
              class="btn btn-danger btn-xs">
              <i class="fa fa-trash"></i></button> </span><br>
          @endforeach
        </div>
      </div>
      <p  style="display: none;" class="bg-navy disabled color-palette clearfix">{{trans_choice('general.custom_field',2)}}</p>
      @foreach($custom_fields as $key)

      <div class="form-group">
        {!! Form::label($key->id,$key->name,array('class'=>'')) !!}
        @if($key->field_type=="number")
        <input type="number" class="form-control" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first()->name}}
        @endif">
        @endif
        @if($key->field_type=="textfield")
        <input type="text" class="form-control" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first()->name}}
        @endif">
        @endif
        @if($key->field_type=="date")
        <input type="text" class="form-control date-picker" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first()->name}}
        @endif">
        @endif
        @if($key->field_type=="textarea")
        <textarea class="form-control" name="{{$key->id}}"
          @if($key->required==1) required @endif>@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first()->name}} @endif</textarea>
        @endif
        @if($key->field_type=="decimal")
        <input type="text" class="form-control touchspin" name="{{$key->id}}" @if($key->required==1) required
        @endif
        value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$expense->id)->where('category','expenses')->first()->name}}
        @endif">
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

function delete_file(e) {
  var id = e.id;
  swal({
    title: '{{trans_choice('
    general.are_you_sure ',1)}}',
    text: '',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '{{trans_choice('
    general.ok ',1)}}',
    cancelButtonText: '{{trans_choice('
    general.cancel ',1)}}'
  }).then(function() {
    $.ajax({
      type: 'GET',
      url: "{!!  url('expense/'.$expense->id) !!}/delete_file?id=" + id,
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
@endsection