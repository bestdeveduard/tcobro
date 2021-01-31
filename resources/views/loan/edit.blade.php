@extends('layouts.master')
@section('title')
CrediData | Editar prestamo
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">Formulario Editar prestamo</h2>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('loan/'.$loan->id.'/update'), 'method' => 'post', 'class' =>
    'form-horizontal',"enctype"=>"multipart/form-data",'id'=>'loan_form')) !!}
    <div class="panel-body">

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('loan_product_id',trans_choice("Ruta del prestamo",1),array('class'=>'col-sm-4
            col-form-label'))
            !!}
            <div class="col-sm-8">
              {!! Form::select('loan_product_id',$loan_products,$loan->loan_product_id, array('class' => ' select2
              form-control', 'placeholder'=>"Seleccione",'required'=>'required','id'=>'loanProduct')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('borrower_id',trans_choice("Nombre del cliente",1)." *",array('class'=>'col-sm-4
            col-form-label')) !!}
            <div class="col-sm-8">
              {!! Form::select('borrower_id',$borrowers,$loan->borrower_id, array('class' => ' select2 form-control',
              'placeholder'=>"Seleccione",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('loan_officer_id',trans_choice("Responsable del prestamo",1),array('class'=>'col-sm-4
            col-form-label')) !!}
            <div class="col-sm-8">
              {!! Form::select('loan_officer_id',$users,$loan->loan_officer_id, array('class' => ' select2
              form-control',
              'placeholder'=>"Seleccione",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('principal',trans_choice("Monto del Capital *",1),array('class'=>'col-sm-4 col-form-label'))
            !!}
            <div class="col-sm-8">
              {!! Form::text('principal',$loan->principal, array('class' => 'form-control touchspin',
              'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('loan_duration',trans_choice("Cantidad de cuotas *",1),array('class'=>'col-sm-4
            col-form-label'))
            !!}
            <div class="col-sm-8">
              {!! Form::number('loan_duration',$loan->loan_duration, array('class' => 'form-control',
              'placeholder'=>"5",'required'=>'required')) !!}
            </div>
            <div style="display: none;" class="col-sm-4">
              {!!
              Form::select('loan_duration_type',array('month'=>trans_choice('general.month',1)),$loan->loan_duration_type,
              array('class' => 'form-control', 'placeholder'=>"","id"=>"inputMaxInterestPeriod",'required'=>'required'))
              !!}
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('repayment_cycle',trans_choice("Modalidad de pago *",1),array('class'=>'col-sm-4
            col-form-label')) !!}
            <div class="col-sm-8">
              {!!
              Form::select('repayment_cycle',array('daily'=>trans_choice('general.daily',1),'weekly'=>trans_choice('general.weekly',1),'bi_monthly'=>trans_choice('general.bi_monthly',1),'monthly'=>trans_choice('general.monthly',1)),$loan->repayment_cycle,
              array('class' => 'form-control', 'placeholder'=>"","id"=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('day_payment',trans_choice("Dia de pago *",1),array('class'=>'col-sm-4 col-form-label')) !!}
            <div class="col-sm-8">
              {!!
              Form::select('day_payment',array('1'=>trans_choice('Lunes',1),'2'=>trans_choice('Martes',1),'3'=>trans_choice('Miercoles',1),'4'=>trans_choice('Jueves',1),'5'=>trans_choice('Viernes',1),'6'=>trans_choice('Sabado',1),'7'=>trans_choice('Domingo',1),'8'=>'Quincenal','9'=>'Mensual','10'=>trans_choice('Todos los dias',1)),$loan->day_payment,
              array('class' => 'form-control', 'placeholder'=>"","id"=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('release_date',trans_choice("Fecha de Desembolso *",1),array('class'=>'col-sm-4
            col-form-label'))
            !!}
            <div class="col-sm-8">
              {!! Form::text('release_date',$loan->release_date, array('class' => 'form-control date-picker',
              'placeholder'=>"yyyy-mm-dd",'required'=>'required','id'=>'releaseDate')) !!}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('first_payment_date',trans_choice("Fecha Primer Pago *",1),array('class'=>'col-sm-4
            col-form-label')) !!}
            <div class="col-sm-8">
              {!! Form::text('first_payment_date',$loan->first_payment_date, array('class' => 'form-control
              date-picker',
              'placeholder'=>"yyyy-mm-dd",''=>'','id'=>'firstPayment')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('interest_method',trans_choice("Metodo Intereses *",1),array('class'=>'col-sm-4
            col-form-label'))
            !!}
            <div class="col-sm-8">
              {!! Form::select('interest_method',array('flat_rate'=>trans_choice("Interes
              fijo",1),'declining_balance_equal_installments'=>trans_choice("Interes Amortizable (Base Balance
              General)",1),'declining_balance_equal_principal'=>trans_choice("Interes Amortizable (Base Balance
              Capital)",1),'interest_only'=>trans_choice("Intere Unico",1)),$loan->interest_method, array('class' =>
              'form-control', 'placeholder'=>"Seleccione",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group row">
            {!! Form::label('interest_rate',trans_choice('general.loan',1).' '.trans_choice('general.interest',1).' (%)
            *',array('class'=>'col-sm-2 col-form-label')) !!}
            <div class="col-sm-4">
              {!! Form::text('interest_rate',$loan->interest_rate, array('class' => 'form-control touchspin',
              'placeholder'=>"",'required'=>'required')) !!}
            </div>
            <div class="col-sm-4">
              {!!
              Form::select('interest_period',array('day'=>trans_choice('general.per_day',1),'week'=>trans_choice('general.per_week',1),'month'=>trans_choice('general.per_month',1),'year'=>trans_choice('general.per_year',1)),$loan->interest_period,
              array('class' => 'form-control',
              'placeholder'=>"Seleccione","id"=>"inputDefaultInterestPeriod",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>      

      <div style="display: none;" class="form-group">
        {!! Form::label('override_interest',trans_choice('general.override',1).'
        '.trans_choice('general.interest',1),array('class'=>'col-sm-4 col-form-label')) !!}
        <div class="col-sm-5">
          {!!
          Form::select('override_interest',array('0'=>trans_choice('general.no',1),'1'=>trans_choice('general.yes',1)),$loan->override_interest,
          array('class' => 'form-control','id'=>'override_interest')) !!}
        </div>
      </div>

      <div style="display: none;" class="form-group" id="overrideDiv">
        {!! Form::label('override_interest_amount',trans_choice('general.override',1).'
        '.trans_choice('general.interest',1).' %',array('class'=>'col-sm-4 col-form-label')) !!}
        <div class="col-sm-5">
          {!! Form::text('override_interest_amount',$loan->override_interest_amount, array('class' => 'form-control
          touchspin','id'=>'override_interest_amount')) !!}
        </div>

      </div>

      <div style="display: none;" class="form-group">
        {!! Form::label('grace_on_interest_charged',trans_choice('general.grace_on_interest',1),array('class'=>'col-sm-4
        col-form-label')) !!}
        <div class="col-sm-5">
          {!! Form::number('grace_on_interest_charged',$loan->grace_on_interest_charged, array('class' =>
          'form-control', 'placeholder'=>"2")) !!}
        </div>
      </div>
      <div style="display: none;" class="form-group">
        {!! Form::label('decimal_places',trans_choice('general.decimal_place',1),array('class'=>'col-sm-4
        col-form-label')) !!}
        <div class="col-sm-5">
          {!!
          Form::select('decimal_places',array('round_off_to_two_decimal'=>trans_choice('general.round_off_to_two_decimal',1),'round_off_to_integer'=>trans_choice('general.round_off_to_integer',1)),$loan->decimal_places,
          array('class' => 'form-control', 'placeholder'=>"","id"=>"",'required'=>'required')) !!}
        </div>
      </div>

      <div style="display: none;" class="form-group">
        {!! Form::label('description',trans_choice('general.description',2),array('class'=>'col-sm-4 col-form-label'))
        !!}
        <div class="col-sm-5">
          {!! Form::textarea('description',$loan->description, array('class' => 'form-control', 'rows'=>"3")) !!}
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('penalty_status',trans_choice("Modalidad de pago *",1),array('class'=>'col-sm-4
            col-form-label'))
            !!}
            <div class="col-sm-8">
              {!!
              Form::select('penalty_status',array('1'=>trans_choice('Si',1),'0'=>trans_choice('No',1)),$loan->penalty_status,
              array('class' => 'form-control', 'placeholder'=>"","id"=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('files',trans_choice('general.loan',1).'
            '.trans_choice('general.file',2).'('.trans_choice('general.borrower_file_types',2).')',array('class'=>'col-sm-4
            col-form-label')) !!}
            <div class="col-sm-4">
              {!! Form::file('files[]', array('class' => 'form-control file-styled', 'multiple'=>"multiple")) !!}
            </div>
            <div class="col-sm-4">
              @foreach(unserialize($loan->files) as $key=>$value)
              <span id="file_{{$key}}_span"><a href="{!!asset('uploads/'.$value)!!}" target="_blank">{!! $value!!}</a>
                <button value="{{$key}}" id="{{$key}}" onclick="delete_file(this)" type="button"
                  class="btn btn-danger btn-xs">
                  <i class="fa fa-trash"></i></button> </span><br>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('saturday', 'Calendario de pagos incluye sabados?', array('class'=>'col-sm-4
            col-form-label'))
            !!}
            <div class="col-sm-8">
              <input type="checkbox" @if($loan->includes_sat == 1) checked @endif name="includes_sat" value="yes"
              class="form-control" style="width: 20px;">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            {!! Form::label('sunday', 'Calendario de pagos incluye Domingos?', array('class'=>'col-sm-4
            col-form-label')) !!}
            <div class="col-sm-8">
              <input type="checkbox" @if($loan->includes_sun == 1) checked @endif name="includes_sun" value="yes"
              class="form-control" style="width: 20px;">
            </div>
          </div>
        </div>
      </div>



      <div style="display: none;" class="form-group" id="chargesDiv">
        <div style="display: none;" id="saved_charges">
          @foreach($loan->loan_product->charges as $key)
          <input name="charges[]" id="charge{{$key->charge_id}}" value="{{$key->charge_id}}">
          @endforeach
        </div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>{{trans_choice('general.name',1)}}</th>
              <th>{{trans_choice('general.type',1)}}</th>
              <th>{{trans_choice('general.amount',1)}}</th>
              <th>{{trans_choice('general.collected',1)}} {{trans_choice('general.on',1)}}</th>
              <th>{{trans_choice('general.date',1)}}</th>
            </tr>
          </thead>
          <tbody id="charges_table">
            @foreach($loan->loan_product->charges as $key)
            @if(!empty($key->charge))
            <tr id="row{{$key->charge->id}}">
              <td>{{ $key->charge->name }}</td>
              <td>
                @if($key->charge->charge_option=="fixed")
                {{trans_choice('general.fixed',1)}}
                @endif
                @if($key->charge->charge_option=="principal_due")
                % {{trans_choice('general.principal',1)}} {{trans_choice('general.due',1)}}
                @endif
                @if($key->charge->charge_option=="principal_interest")
                % {{trans_choice('general.principal',1)}}
                + {{trans_choice('general.interest',1)}} {{trans_choice('general.due',1)}}
                @endif
                @if($key->charge->charge_option=="interest_due")
                % {{trans_choice('general.interest',1)}} {{trans_choice('general.due',1)}}
                @endif
                @if($key->charge->charge_option=="total_due")
                % {{trans_choice('general.total',1)}} {{trans_choice('general.due',1)}}
                @endif
                @if($key->charge->charge_option=="original_principal")
                % {{trans_choice('general.original',1)}} {{trans_choice('general.principal',1)}}
                @endif
              </td>
              <td>
                <?php
                  $charge = \App\Models\LoanCharge::where('charge_id',$key->charge->id)->where('loan_id',$loan->id)->first();
                  if(!empty($charge)){
                      $charge_date=$charge->date;
                      $charge_amount=$charge->amount;
                  }else{
                      $charge_date="";
                      $charge_amount=$key->charge->amount;
                  }
                  ?>
                @if($key->charge->override==1)

                <input type="text" class="form-control" name="charge_amount_{{$key->charge->id}}"
                  value="{{$charge_amount}}" required>
                @else
                <input type="hidden" class="form-control" name="charge_amount_{{$key->charge->id}}"
                  value="{{$charge_amount}}">
                {{$charge_amount}}
                @endif
              </td>
              <td>
                @if($key->charge->charge_type=='disbursement')
                {{trans_choice('general.disbursement',1)}}
                @endif
                @if($key->charge->charge_type=='specified_due_date')
                {{trans_choice('general.specified_due_date',2)}}
                @endif
                @if($key->charge->charge_type=='installment_fee')
                {{trans_choice('general.installment_fee',2)}}
                @endif
                @if($key->charge->charge_type=='overdue_installment_fee')
                {{trans_choice('general.overdue_installment_fee',2)}}
                @endif
                @if($key->charge->charge_type=='loan_rescheduling_fee')
                {{trans_choice('general.loan_rescheduling_fee',2)}}
                @endif
                @if($key->charge->charge_type=='overdue_maturity')
                {{trans_choice('general.overdue_maturity',2)}}
                @endif
                @if($key->charge->charge_type=='savings_activation')
                {{trans_choice('general.savings_activation',2)}}
                @endif
                @if($key->charge->charge_type=='withdrawal_fee')
                {{trans_choice('general.withdrawal_fee',2)}}
                @endif
                @if($key->charge->charge_type=='monthly_fee')
                {{trans_choice('general.monthly_fee',2)}}
                @endif
                @if($key->charge->charge_type=='annual_fee')
                {{trans_choice('general.annual_fee',2)}}
                @endif
              </td>
              <td>

                @if($key->charge->charge_type=='specified_due_date')

                <input type="text" class="form-control date-picker" name="charge_date_{{$key->charge->id}}"
                  value="{{$charge_date}}" required>
                @else
                <input type="hidden" class="form-control" name="charge_date_{{$key->charge->id}}" value="">
                @endif
              </td>

            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      <p style="display: none;" class="bg-navy disabled color-palette">{{trans_choice('general.custom_field',2)}}</p>
      @foreach($custom_fields as $key)
      <div class="form-group">
        {!! Form::label($key->id,$key->name,array('class'=>'col-form-label col-sm-4')) !!}
        <div class="col-sm-5">
          @if($key->field_type=="number")
          <input type="number" class="form-control" name="{{$key->id}}" @if($key->required==1) required
          @endif
          value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first()->name}}
          @endif">
          @endif
          @if($key->field_type=="textfield")
          <input type="text" class="form-control" name="{{$key->id}}" @if($key->required==1) required
          @endif
          value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first()->name}}
          @endif">
          @endif
          @if($key->field_type=="date")
          <input type="text" class="form-control date-picker" name="{{$key->id}}" @if($key->required==1) required
          @endif
          value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first()->name}}
          @endif">
          @endif
          @if($key->field_type=="textarea")
          <textarea class="form-control" name="{{$key->id}}"
            @if($key->required==1) required @endif>@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first()->name}} @endif</textarea>
          @endif
          @if($key->field_type=="decimal")
          <input type="text" class="form-control touchspin" name="{{$key->id}}" @if($key->required==1) required
          @endif
          value="@if(!empty(\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first())){{\App\Models\CustomFieldMeta::where('custom_field_id',$key->id)->where('parent_id',$loan->id)->where('category','loans')->first()->name}}
          @endif">
          @endif
        </div>
      </div>
      @endforeach

    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
      <div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
        <a class="btn btn-secondary" style="margin-left: 11px;" href="{{url('loan/data')}}">Cancelar</a>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
  <!-- /.box -->
</div>
@endsection
@section('footer-scripts')
<script>
$(document).ready(function() {
  if ($('#override_interest').val() == 0) {
    $('#overrideDiv').hide();
    $('#override_interest_amount').removeAttr('required');
  }
  if ($('#override_interest').val() == 1) {
    $('#overrideDiv').show();
    $('#override_interest_amount').attr('required', 'required');
  }
  $('#override_interest').change(function(e) {
    if ($('#override_interest').val() == 0) {
      $('#overrideDiv').hide();
      $('#override_interest_amount').removeAttr('required');
    }
    if ($('#override_interest').val() == 1) {
      $('#overrideDiv').show();
      $('#override_interest_amount').attr('required', 'required');
    }
  })
});

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
      url: "{!!  url('loan/'.$loan->id) !!}/delete_file?id=" + id,
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
$("#loan_form").validate({
  rules: {
    field: {
      required: true,
      number: true
    }
  }
});
</script>
@endsection