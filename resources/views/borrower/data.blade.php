@extends('layouts.master')
@section('title')
Reporte Clientes
@endsection
@section('content')
<!---{{trans_choice('general.borrower',2)}}--->
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title">Reporte de Clientes
        <!---{{trans_choice('general.borrower',2)}}--->
      </h3>

      <div class="heading-elements">
        @if(Sentinel::hasAccess('borrowers.create'))
        <a href="{{ url('borrower/create') }}" class="btn btn-info btn-sm">{{trans_choice('general.add',1)}}
          {{trans_choice('general.borrower',1)}}</a>
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre y apellido</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Movil</th>
                <th>Empresa</th>
                <th>Referencia</th>
                <th>Estatus</th>
                <th>Acciones</th>
                <!---<th>Acciones</th>--->
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key)

              <tr>
                <td>{{ $key->id }}</td>
                <td>{{ $key->first_name }} {{ $key->last_name }}</td>
                <td>
                  {{ $key->address }}, {{ $key->country->name }}
                </td>
                <td>{{ $key->phone }}</td>
                <td>{{ $key->mobile }}</td>
                <td>{{ $key->business_name }}</td>
                <td>{{ $key->referencia_1 }}</td>
                <td>
                  @if($key->active==0)
                  <strong>Lista negra</strong>

                  @elseif(count($key->loans)==0)
                  <strong>Inactivo</strong>

                  @elseif(count($key->loans) > 0)
                  <strong>Activo</strong>

                  @endif


                </td>

                <td class="text-center">
                  <ul class="list-group">
                    <li class="dropdown">
                      <a href="#" data-toggle="dropdown">
                        <img src="https://img.icons8.com/pastel-glyph/25/000000/plus.png" />
                      </a>

                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        @if($key->active==0)
                        @if(Sentinel::hasAccess('borrowers.approve'))
                        <li><a href="{{ url('borrower/'.$key->id.'/approve') }}"><i class="fa fa-check"></i>Aprobar
                          </a></li>
                        @endif
                        @endif
                        @if($key->active==1)
                        @if(Sentinel::hasAccess('borrowers.approve'))
                        <li><a href="{{ url('borrower/'.$key->id.'/decline') }}"><i class="fa fa-minus-circle"></i>
                            disminución
                          </a></li>
                        @endif
                        @endif

                        @if(Sentinel::hasAccess('borrowers.view'))
                        <li><a href="{{ url('borrower/'.$key->id.'/show') }}"><i class="fa fa-search"></i>Ver perfil
                          </a></li>
                        @endif
                        @if(Sentinel::hasAccess('borrowers.update'))
                        <li><a href="{{ url('borrower/'.$key->id.'/edit') }}"><i class="fa fa-edit"></i>Editar</a>
                        </li>
                        @endif
                        @if(Sentinel::hasAccess('borrowers.delete'))
                        <li><a href="{{ url('borrower/'.$key->id.'/delete') }}" class="delete"><i
                              class="fa fa-trash"></i>Eliminar
                          </a>
                        </li>
                        @endif
                      </ul>

                    </li>
                  </ul>
                </td>


                <!---   <td>
              <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button>
              <button type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                        </td>--->
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.panel-body -->
</div>
<!-- /.box -->
@endsection
@section('footer-scripts')
<script>
$('#data-table').DataTable({
  "order": [
    [0, "desc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": [5]
  }],
  "language": {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  },
  responsive: false
});
</script>
@endsection