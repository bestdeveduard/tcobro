@extends('layouts.master')
@section('title')
Tcobro | Cobradores
@endsection
@section('content')
<p align="right"><a href="{{ url('user/collector/create') }}" type="button" class="btn btn-primary mr-2">Crear cobrador</a></p>
<div class="card">
  <div class="card-body">

    @if(Session::has('flash_notification.message'))
    <script>
    toastr. {
      {
        Session::get('flash_notification.level')
      }
    }('{{ Session::get("flash_notification.message") }}', 'Response Status')
    </script>
    @endif
    @if (isset($msg))
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{ $msg }}
    </div>
    @endif
    @if (isset($error))
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{ $error }}
    </div>
    @endif
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="panel-heading">
      <h2 class="panel-title">Cobradores</h2>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre cobrador</th>
                <th>Email</th>
                <th>Telefono</th>
                <!---<th>Condicion</th>--->
                <th style="width:12px" ;>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @php
              $num = 1;
              @endphp

              @foreach($data as $key)
              <tr>
                <td>{{$num}}</td>
                <td>{{ $key->first_name }} {{ $key->last_name }}</td>
                <td>{{ $key->email }}</td>
                <td>{{ $key->phone }}</td>
                <!---<td>Secondary</td>--->
                <td>

                      
                  <a href="{{url('user/collector/'.$key->id.'/edit')}}">
                <button style="width:110px; height:28px; background-color:#4c82c3; border-color:#4c82c3;" type="button"
                  class="btn btn-info btn-icon-text">
                  Editar
                </button>                      
                  </a>
                  <a href="{{url('user/collector/'.$key->id.'/role')}}">
                  <button
                    style="width:110px; height:28px; color: white; background-color:#008080; border-color:#008080;"
                    type="button" class="btn btn-white btn-icon-text">
                    Roles
                  </button>                  
                   </a>                  
                  <a href="{{url('user/collector/'.$key->id.'/delete')}}" class="delete">
                <button style="width:110px; height:28px; background-color:#de3501; border-color:#de3501;" type="button"
                  class="btn btn-danger btn-icon-text">
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