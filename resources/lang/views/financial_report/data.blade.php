@extends('layouts.master')
@section('title'){{trans_choice('general.financial',1)}} {{trans_choice('general.report',2)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">{{trans_choice('general.financial',1)}} {{trans_choice('general.report',2)}}</h2>

      <div class="heading-elements">
      </div>
    </div>
    
    <div class="panel-body">
      <table id="" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Codigo reporte</th>
            <th>Descripcion del reporte</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/financial_report/balance_sheet')}}">RF001</a>
            </td>
            <td>
              Reporte resumen flujo de efectivo (Activo, Pasivos y Capital)
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/financial_report/balance_sheet')}}">Abrir
                <i class="icon-search4"></i> </a>
            </td>
          </tr>
          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/financial_report/trial_balance')}}">RF002</a>
            </td>
            <td>
              {{trans_choice('general.trial_balance',1)}}
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/financial_report/trial_balance')}}">Abrir
                <i class="icon-search4"></i> </a>
            </td>
          </tr>

          <tr class="hidden" style="display: none;">
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/financial_report/cash_flow')}}">RF003</a>
            </td>
            <td>
              {{trans_choice('general.cash_flow',1)}}
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/financial_report/cash_flow')}}">Abrir <i
                  class="icon-search4"></i> </a>
            </td>
          </tr>

          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/financial_report/income_statement')}}">RF003</a>
            </td>
            <td>
              {{trans_choice('general.income_statement_description',1)}}
            </td>
            <td><a class="btn btn-success" role="button"
                href="{{url('report/financial_report/income_statement')}}">Abrir <i class="icon-search4"></i> </a>
            </td>
          </tr>
          <!--<tr>
                    <td>
                        <a class="btn btn-info btn-lg btn-block" role="button" href="{{url('report/financial_report/provisioning')}}">RF005</a>
                    </td>
                    <td>
                        {{trans_choice('general.provisioning_description',1)}}
                    </td>
                    <td><a class="btn btn-success" role="button" href="{{url('report/financial_report/provisioning')}}">Abrir <i class="icon-search4"></i> </a>
                    </td>
                </tr>-->
        </tbody>
      </table>
    </div>
    <!-- /.panel-body -->
  </div>
  <!-- /.box -->
</div>
@endsection
@section('footer-scripts')

@endsection