@extends('layouts.master')
@section('title')
T-Cobro Web| Crear plan
@endsection
@section('content')

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h5>Crear Plan</h5>
        
        {!! Form::open(array('url' => url('super_admin/makeplan'), 'method' => 'post', 'name' => 'form','class'=>'pt-3 formss-sample')) !!}
          <p class="card-description">
          </p>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Nombre: *</strong></label>
                <div class="col-sm-8">
                <input type="text" name="plan_name" id="plan_name" class="form-control" placeholder="Plan 1" required="true"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Rutas: *</strong></label>
                <div class="col-sm-8">
                <input type="number" name="limited_routes" id="limited_routes" class="form-control" placeholder="Rutas permitidas" required="true"/>
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Precio: *</strong></label>
                <div class="col-sm-8">
                  <input name="plan_amount" id="plan_amount" class="form-control" data-inputmask="'alias': 'currency'" required="true"/>

                </div>
              </div>       
            </div>            

            <div class="col-md-4">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Duracion: *</strong></label>
                <div class="col-sm-8">
                <input type="number" name="plan_duration" id="plan_duration" class="form-control" placeholder="Dias" required="true"/>
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><strong>Usuarios: *</strong></label>
                <div class="col-sm-8">
                <input type="number" name="limited_users" id="limited_users" class="form-control" placeholder="Cobradores permitidos" required="true"/>
                </div>
              </div>
              
            </div>
          </div>

         <!--- <div class="row">
            <div class="col-md-4">

            </div>          

            <div class="col-md-4">

            </div>
          </div>

          <div class="row">
            <div class="col-md-4">

            </div>
          </div>--->
          <button style="width:110px;" type="submit" class="btn btn-primary mr-2">Crear</button>
          <a style="width:110px;" class="btn btn-light" href="{{ url('super_admin/plans') }}">Cancelar</a>

        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
  
@endsection
