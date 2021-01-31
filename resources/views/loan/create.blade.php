@extends('layouts.master')
@section('title')
Tcobro web | Crear prestamo
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h4>Crear prestamo</h4>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('loan/store'), 'method' => 'post', 'class' =>
    'form-horizontal',"enctype"=>"multipart/form-data",'id'=>'loan_form')) !!}
    <div class="panel-body">
     
      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center" style="color:#22ae60;"><strong>Ruta</strong></label>
            <div class="col-sm-8">
              {!! Form::select('loan_product_id',$loan_products,$loan_product->id, array('class' => ' select2
              form-control','required'=>'required','id'=>'loanProduct')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center"  style="color:#22ae60;"><strong>Cliente</strong></label>
            <div class="col-sm-8">
              {!! Form::select('borrower_id',$borrowers,$borrower_id, array('class' => 'js-example-basic-single w-100 form-control',
              'placeholder'=>"Seleccione",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>



      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center" style="color:#22ae60;"><strong>Capital</strong></label>
            <div class="col-sm-8">
              {!! Form::text('principal',number_format($loan_product->default_principal,2), array('class' => 'form-control touchspin',
              'placeholder'=>"Monto aprobado",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center"  style="color:#22ae60;"><strong>Interes %</strong></label>
            <div class="col-sm-8">
              {!! Form::text('interest_rate',number_format($loan_product->default_interest_rate,2), array('class' => 'form-control
              touchspin', 'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

     <div class="row">        
        <div class="col-md-6">
          <div class="form-group row">            
            <div style="display: none;" class="col-sm-3">
              {!! Form::select('interest_period',array('month'=>trans_choice("Distribucion
              mensual",1)),$loan_product->interest_period, array('class' => 'form-control',
              "id"=>"inputDefaultInterestPeriod",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>

      <div style="display: none;" class="form-group">
        {!! Form::label('loan_officer_id',trans_choice("Responsable del prestamo",1)." *",array('class'=>'col-sm-3
        col-form-label')) !!}
        <div class="col-sm-5">
          {!! Form::select('loan_officer_id',$users,null, array('class' => ' select2 form-control',
          'placeholder'=>"Seleccione")) !!}
        </div>
      </div>
            <div style="display: none;" class="col-sm-3">
              {!!
              Form::select('loan_duration_type',array('month'=>trans_choice('general.month',1).'(s)'),$loan_product->default_loan_duration_type,
              array('class' => 'form-control',"id"=>"loan_duration_type",'required'=>'required')) !!}
            </div>
      <div style="display: none;" class="form-group">
        {!! Form::label('override_interest',trans_choice('general.override',1).'
        '.trans_choice('general.interest',1),array('class'=>'col-sm-3 col-form-label')) !!}
        <div class="col-sm-5">
          {!!
          Form::select('override_interest',array('0'=>trans_choice('general.no',1),'1'=>trans_choice('general.yes',1)),0,
          array('class' => 'form-control','id'=>'override_interest')) !!}
        </div>
        <div class="col-sm-4">
          <i class="icon-info3" data-toggle="tooltip" title="{{trans_choice('general.override_msg',1)}}"></i>
        </div>
      </div>            

      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center" style="color:#22ae60;"><strong>Cuotas</strong></label>
            <div class="col-sm-8">
              {!! Form::text('loan_duration',$loan_product->default_loan_duration, array('class' => 'form-control
              touchspin', 'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center"  style="color:#22ae60;"><strong>Modalidad</strong></label>
            <div class="col-sm-8">
              {!! Form::select('repayment_cycle',array('daily'=>trans_choice('general.daily',1),'weekly'=>trans_choice('general.weekly',1),'bi_monthly'=>trans_choice('general.bi_monthly',1),'monthly'=>trans_choice('general.monthly',1)),$loan_product->repayment_cycle,
              array('class' => 'form-control',"id"=>"repayment_cycle",'required'=>'required')) !!}
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center" style="color:#22ae60;"><strong>Dia de pago</strong></label>
            <div class="col-sm-8">
              {!! Form::select('day_payment',array('1'=>trans_choice('Lunes',1),'2'=>trans_choice('Martes',1),'3'=>trans_choice('Miercoles',1),'4'=>trans_choice('Jueves',1),'5'=>trans_choice('Viernes',1),'6'=>trans_choice('Sabado',1),'7'=>trans_choice('Domingo',1),'8'=>'Quincenal','9'=>'Mensual','10'=>trans_choice('Diario',1)),$loan_product->day_payment,
              array('class' => 'form-control',"id"=>"day_payment",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center"  style="color:#22ae60;"><strong>Desembolso</strong></label>
            <div class="col-sm-8">
              {!! Form::date('release_date',date("Y-m-d"), array('class' => 'form-control date-picker',
              'placeholder'=>"yyyy-mm-dd",'required'=>'required','id'=>'release_date')) !!}
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center" style="color:#22ae60;"><strong>1er pago</strong></label>
            <div class="col-sm-8">
              {!! Form::date('first_payment_date',date("Y-m-d"), array('class' => 'form-control date-picker',
              'placeholder'=>"yyyy-mm-dd",'id'=>'first_payment_date')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center"  style="color:#22ae60;"><strong>Amortizacion</strong></label>
            <div class="col-sm-8">
              {!! Form::select('interest_method',array('flat_rate'=>trans_choice("Interes
              fijo",1),'declining_balance_equal_installments'=>trans_choice("Interes
              amortizable",1)),$loan_product->interest_method, array('class' => 'form-control','required'=>'required'))
              !!}
            </div>
          </div>
        </div>
      </div>              




      <div class="row">
        <div class="col-md-6">
          <div class="form-group row" id="overrideDiv">
            {!! Form::label('override_interest_amount',trans_choice('general.override',1).'
            '.trans_choice('general.interest',1).' %',array('class'=>'col-sm-3 col-form-label')) !!}
            <div class="col-sm-9">
              {!! Form::text('override_interest_amount',0, array('class' => 'form-control
              touchspin','id'=>'override_interest_amount')) !!}
            </div>
          </div>
        </div>
      </div>

      <div style="display: none;" class="form-group">
        {!! Form::label('grace_on_interest_charged',trans_choice('general.grace_on_interest',1),array('class'=>'col-sm-3
        col-form-label')) !!}
        <div class="col-sm-5">
          {!! Form::number('grace_on_interest_charged',$loan_product->grace_on_interest_charged, array('class' =>
          'form-control', 'placeholder'=>"2")) !!}
        </div>
      </div>
      <div style="display: none;" class="form-group">
        {!! Form::label('decimal_places',trans_choice('general.decimal_place',1),array('class'=>'col-sm-3
        col-form-label')) !!}
        <div class="col-sm-5">
          {!!
          Form::select('decimal_places',array('round_off_to_two_decimal'=>trans_choice('general.round_off_to_two_decimal',1),'round_off_to_integer'=>trans_choice('general.round_off_to_integer',1)),$loan_product->decimal_places,
          array('class' => 'form-control',"id"=>"",'required'=>'required')) !!}
        </div>
      </div>
      <div class="form-group" style="display: none;">
        {!! Form::label('description',trans_choice('general.description',2),array('class'=>'col-sm-3 col-form-label'))
        !!}
        <div class="col-sm-5">
          {!! Form::textarea('description',null, array('class' => 'form-control', 'rows'=>"3")) !!}
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center" style="color:#22ae60;"><strong>Penalidad</strong></label>
            <div class="col-sm-8">
              {!! Form::select('penalty_status',array('1'=>trans_choice('Si',1),'0'=>trans_choice('No',1)),$loan_product->penalty_status,
              array('class' => 'form-control',"id"=>"day_payment",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" align="center"  style="color:#22ae60;"><strong>Contrato</strong></label>
            <div style="width: 10px;">
              {!! Form::file('files[]', array('class' => 'form-control file-styled', 'multiple'=>"multiple")) !!}
            </div>
          </div>
        </div>
</div>


      <div class="row">
        <div  style="display: none;" class="col-md-6">
          <div class="form-group row">
            {!! Form::label('sunday', 'Calendario de pagos incluye Domingos?', array('class'=>'col-sm-6
            col-form-label')) !!}
            <div class="col-sm-6">
              <input type="checkbox" name="includes_sun" value="yes" class="form-control" style="width: 20px;">
            </div>
          </div>
        </div>
        <div  style="display: none;"  class="col-md-6">
          <div class="form-group row">
            {!! Form::label('saturday', 'Calendario de pagos incluye sabados?', array('class'=>'col-sm-6
            col-form-label'))
            !!}
            <div class="col-sm-6">
              <input type="checkbox" name="includes_sat" value="1" class="form-control" style="width: 20px;">
            </div>
          </div>
        </div>
      </div>

      <p style="display: none;" class="bg-navy color-palette">{{trans_choice('general.charge',2)}}</p>

      
      <div style="display: none;" class="form-group" id="chargesDiv">
        <div style="display: none;" id="saved_charges">
          @foreach($loan_product->charges as $key)
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
            @foreach($loan_product->charges as $key)
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
                @if($key->charge->override==1)
                <input type="text" class="form-control" name="charge_amount_{{$key->charge->id}}"
                  value="{{$key->charge->amount}}" required>
                @else
                <input type="hidden" class="form-control" name="charge_amount_{{$key->charge->id}}"
                  value="{{$key->charge->amount}}">
                {{$key->charge->amount}}
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
                <input type="text" class="form-control date-picker" name="charge_date_{{$key->charge->id}}" value=""
                  required>
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
        {!! Form::label($key->id,$key->name,array('class'=>'col-form-label col-sm-3')) !!}
        <div class="col-sm-5">
          @if($key->field_type=="number")
          <input type="number" class="form-control" name="{{$key->id}}" @if($key->required==1) required @endif>
          @endif
          @if($key->field_type=="textfield")
          <input type="text" class="form-control" name="{{$key->id}}" @if($key->required==1) required @endif>
          @endif
          @if($key->field_type=="date")
          <input type="text" class="form-control date-picker" name="{{$key->id}}" @if($key->required==1) required
          @endif>
          @endif
          @if($key->field_type=="textarea")
          <textarea class="form-control" name="{{$key->id}}" @if($key->required==1) required @endif></textarea>
          @endif
          @if($key->field_type=="decimal")
          <input type="text" class="form-control touchspin" name="{{$key->id}}" @if($key->required==1) required @endif>
          @endif
        </div>
      </div>
      @endforeach
    </div>

          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Confirmar</button>
          <a style="width:115px;" class="btn btn-light" href="{{ url('loan/data') }}">Cancelar</a>     
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
  $('#loanProduct').change(function(e) {
    window.location = "{!! url('loan/create?product_id=') !!}" + $("#loanProduct").val();
  })
  /*$('#release_date').focusout(function(e){
   var releaseDate=$('#release_date').val();
   var duration=$('#loan_duration').val();
   var durationType=$('#loan_duration_type').val();
   var repaymentCycle=$('#repayment_cycle').val();
   var repaymentDate=moment(releaseDate, 'YYYY-MM-DD');
   if(repaymentCycle=='daily'){

   repaymentDate.add(1, 'days').format('YYYY-MM-DD');
   alert(repaymentDate);
   $('#first_payment_date').val(repaymentDate);

   }
   })*/
});
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