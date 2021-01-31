@extends('layouts.master')
@section('title'){{trans_choice('general.report',2)}} de {{trans_choice('general.loan',1)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">
        Libreria de reportes de prestamos
      </h2>

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
          <!---<tr>
                    <td>
                        <a href="{{url('report/loan_report/collection_sheet')}}">Reporte de pagos pendientes</a>
                    </td>
                    <td>
                        {{trans_choice('general.collection_sheet_report_description',1)}}
                    </td>
                    <td><a href="{{url('report/loan_report/collection_sheet')}}"><i class="icon-search4"></i> </a>
                    </td>
                </tr>--->
          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/loan_report/repayments_report')}}">RP001</a>
            </td>
            <td>
              Reporte detalle de pagos recibidos
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/loan_report/repayments_report')}}">Abrir <i
                  class="icon-search4"></i> </a>
            </td>
          </tr>

          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/loan_report/expected_repayments')}}">RP002</a>
            </td>
            <td>
              Reporte resumen de pagos por usuario y rutas
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/loan_report/expected_repayments')}}">Abrir
                <i class="icon-search4"></i> </a>
            </td>
          </tr>
          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/loan_report/arrears_report')}}">RP003</a>
            </td>
            <td>
              Reporte detalle de prestamos en atraso
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/loan_report/arrears_report')}}">Abrir <i
                  class="icon-search4"></i> </a>
            </td>
          </tr>
          <tr>
            <td>
              <a class="btn btn-info btn-lg btn-block" role="button"
                href="{{url('report/loan_report/disbursed_loans')}}">RP004</a>
            </td>
            <td>
              Reporte detalle de prestamos desembolsados
            </td>
            <td><a class="btn btn-success" role="button" href="{{url('report/loan_report/disbursed_loans')}}">Abrir <i
                  class="icon-search4"></i> </a>
            </td>
          </tr>
          <!---<tr>
                    <td>
                        <a href="{{url('report/loan_report/written_off_loans')}}">Reporte de prestamos castigados</a>
                    </td>
                    <td>
                       Detalle de todos los prestamos castigados {{trans_choice('general.written_off_loans_report_description',1)}}
                    </td>
                    <td><a href="{{url('report/loan_report/written_off_loans')}}"><i class="icon-search4"></i> </a>
                    </td>
                </tr>--->
        </tbody>
      </table>
    </div>
    <!-- /.panel-body -->
  </div>
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')

@endsection