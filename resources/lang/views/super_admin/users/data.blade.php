@extends('layouts.master')
@section('title')
T-Cobro Web | Reporte de control
@endsection
@section('content')
  <p align="right"><a href="{{ url('super_admin/addadmin') }}" type="button" class="btn btn-primary mr-2">Crear Admin</a></p>
  <?php
    $active = 0;
    $inactive = 0;
    foreach($data as $key) {
      if ($key->active_status == 1) {
        $active++;
      } else if ($key->active_status == 2) {
        $inactive++;
      }
    }
  ?>
  <div class="row">
    <div class="col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-around align-items-center">
            <div class="icon-rounded-primary">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <center><h5>Usuarios activos</h5></center>
              <center><h5 class="mb-0">{{$active}}</h5></center>  
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-around align-items-center">
            <div class="icon-rounded-primary">
              <i class="fas fa-users"></i>
            </div>
            <div>
              <center><h5>Usuarios inactivos</h5></center>
              <center><h5 class="mb-0">{{$inactive}}</h5></center>            
            </div>
          </div>
        </div>
      </div>
    </div>  
    <!-- <div class="col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-around align-items-center">
            <div class="icon-rounded-primary">
              <i class="fas fa-users"></i>
            </div>
            <div>                
              <center><h5>Usuarios vencidos</h5></center>
              <center><h5 class="mb-0">0</h5></center>           
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>

  <div class="card">
    <div class="card-body">
      <h4>Reporte de control</h4>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                  <th><center>#</center></th>
                  <th><center>ID Membresia</center></th>
                  <th><center>Cliente</center></th>
                  <th><center>Email</center></th>
                  <th><center>Telefono</center></th>
                  <th><center>Pais</center></th>
                  <!---<th>Condicion</th>--->
                  <th><center>Plan</center></th>
                  <th><center>Expiracion</center></th>
                  <th><center>Estatus</center></th>
                  <th style="width:12px";><center>Acciones</center></th>
                </tr>
              </thead>
              <tbody>                
                @php
                  $num = 1;
                @endphp
                @foreach($data as $key)
                <tr>
                  <td><center>{{ $num }}</center></td>
                  <td><center>{{ $key->id }}</center></td>
                  <td><center>{{ $key->first_name }} {{ $key->last_name }}</center></td>
                  <td><center>{{ $key->email }}</center></td>
                  <td><center>{{ $key->phone }}</center></td>
                  <td><center>{{ $key->country_name }}</center></td>
                  <!---<td>
                    @if (Sentinel::inRole('2'))
                    Primary
                    @elseif (Sentinel::inRole('3'))
                    Secondary
                    @endif
                  </td>--->
                  <td><center>{{ $key->plan_id }}</center></td>
                  <td><center>{{ $key->plan_expired_date }}</center></td>
                  <td>
                    @if ($key->active_status == 1)
                      <button style="width:110px; height: 28px; background-color:#00df95; border-color:#00df95;"  type="button" class="btn btn-success btn-icon-text">
                        Activo
                      </button>       
                    @elseif ($key->active_status == 2)
                      <button style="width:110px; height: 28px; background-color:" type="button" class="btn btn-warning">
                        Inactivo
                      </button>                      
                    @else
                      <button style="width:110px; height: 28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-success btn-icon-text">
                        Vencido
                      </button>                      
                    @endif
                  </td>
                  <td>
                    @if ($key->active_status == 1)
                      <a href="{{ url('super_admin/'.$key->id.'/deactive') }}">
                        <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                            Desactivar
                        </button>    
                       </a>
                    @elseif ($key->active_status == 2)
                      <a href="{{ url('super_admin/'.$key->id.'/active') }}">
                        <button style="width:110px; height: 28px; background-color:#4c82c3; border-color:#4c82c3;" type="button" class="btn btn-info btn-icon-text">
                          Activar
                        </button>                        
                      </a>
                    @else
                      <a href="{{ url('super_admin/'.$key->id.'/active') }}" class="btn btn-outline-success">Renovar</a>
                    @endif
                    
                    <a href="{{ url('super_admin/'.$key->id.'/delete') }}">
                      <button style="width:110px; height: 28px; background-color:#de3501; border-color:#de3501;"  type="button" class="btn btn-danger btn-icon-text">
                        Eliminar
                      </button>
                    </a>                      
                  </td>                  
                </tr>
                @php
                  $num++;
                @endphp
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>    
@endsection

@section('footer-scripts')
@endsection
