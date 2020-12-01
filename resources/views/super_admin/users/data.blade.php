@extends('layouts.master')
@section('title')
    {{ trans_choice('general.user',2) }}
@endsection
@section('content')
  <p align="right"><a href="{{ url('super_admin/addadmin') }}" type="button" class="btn btn-primary mr-2">Crear Admin</a></p>
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
              <center><h5 class="mb-0">0</h5></center>  
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
              <center><h5 class="mb-0">0</h5></center>            
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
              <center><h5>Usuarios vencidos</h5></center>
              <center><h5 class="mb-0">0</h5></center>           
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h2>Reporte de control</h2>
      <br>
      <br>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="order-listing" class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Member ID</th>
                  <th>Customer</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Country</th>
                  <th>Condition</th>
                  <th>Plan</th>
                  <th>Expiration</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>                
                @php
                  $num = 1;
                @endphp
                @foreach($data as $key)
                <tr>
                  <td>{{ $num }}</td>
                  <td>{{ $key->id }}</td>
                  <td>{{ $key->first_name }} {{ $key->last_name }}</td>
                  <td>{{ $key->email }}</td>
                  <td>{{ $key->phone }}</td>
                  <td>{{ $key->country_name }}</td>
                  <td>
                    @if (Sentinel::inRole('2'))
                    Primary
                    @elseif (Sentinel::inRole('3'))
                    Secondary
                    @endif
                  </td>
                  <td>{{ $key->plan_id }}</td>
                  <td>{{ $key->plan_expired_date }}</td>
                  <td>
                    @if ($key->active_status == 1)
                      <label style="width: 100px;"  class="badge badge-success">Activado</label>
                    @elseif ($key->active_status == 2)
                      <label style="width: 100px;"  class="badge badge-secondary">Inactivo</label>
                    @else
                      <label style="width: 100px;"  class="badge badge-danger">Vencido</label>
                    @endif
                  </td>
                  <td>
                    @if ($key->active_status == 1)
                      <a href="{{ url('super_admin/'.$key->id.'/deactive') }}" class="btn btn-outline-primary">Desactivar</a>
                    @elseif ($key->active_status == 2)
                      <a href="{{ url('super_admin/'.$key->id.'/active') }}" class="btn btn-outline-success">Activar</a>
                    @else
                      <a href="{{ url('super_admin/'.$key->id.'/active') }}" class="btn btn-outline-success">Renovar</a>
                    @endif
                    
                    <a href="{{ url('super_admin/'.$key->id.'/delete') }}" class="btn btn-outline-danger delete">Delete</a>                      
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
