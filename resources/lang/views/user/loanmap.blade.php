@extends('layouts.master')
@section('title')
T-Cobro Web | GPS
@endsection
@section('content')
<div class="card panel panel-white" style="background: white;">
  <div class="card-body">
    <div class="panel-body hidden-print">
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-2">
          {!! Form::label('end_date', trans_choice('general.search',1).'
          '.trans_choice('general.date',1),array('class'=>'')) !!}
          {!! Form::date('end_date', $end_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>

        <div class="col-md-2">
          <label for="name">Usuario:</label>
          <div>
            @if(count($users_list) > 0)
            <select name="user_id" id="user_id" class="form-control">
              @foreach($users_list as $kkey => $k_user )
              <option value="{{ $k_user->id }}" @if($k_user->id == $user_id) selected @endif >{{ $k_user->first_name }}
                {{ $k_user->last_name }}</option>
              @endforeach
            </select>
            @endif
          </div>
        </div>

        <div class="col-md-2">
         <label for="name">.</label>
            <div>
          <button type="submit" class="btn btn-success">Actualizar
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    <br>
    <div class="top-baner map-baner">
      <div id="map-canvas" data-lat="{{$user->lat}}" data-lng="{{$user->lng}}" data-zoom="16" data-style="6"></div>

      @if(count($locations) > 0)
      @foreach($locations as $key => $data)
      <div class="addresses-block">
        <a data-lat="{{$data['lat']}}" data-lng="{{$data['long']}}" data-name="{{$data['customer']}}"
          data-id="{{$data['loan_id']}}" data-amount="{{$data['amount']}}"></a>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</div>

<script src="{{ asset('assets/themes/limitless/js/map.js') }}"></script>
@endsection