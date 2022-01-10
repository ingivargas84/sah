@extends('layouts.app')
@section('content')
@include('reservaciones.createModal')
@include('reservaciones.editModal')
@include('users.confirmarAccionModal')
<div id="content">
    <div class="loader loader-double is-active"></div>
  <div class="container-custom">
    <div class="panel panel-default">
      <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Reservaciones</h3>
      <div class="col-sm-3">
        <label for="tipo_habitacion_id">Tipo de Habitación:</label>
        <select class="form-control" name="tipo_habitacion_id" id="tipo_habitacion_id">
          <option value="0">todas</option>
           @foreach ($tiposhabitaciones as $tipo)
             <option value="{{$tipo->id}}">{{$tipo->tipo_habitacion}}</option>
           @endforeach
        </select>
      </div>
      <div id="calendar" class="panel panel-body" >
      </div>
    </div>
  </div>
</div>

@endsection


@push('scripts')
<script src="{{asset('js/reservaciones/create.js')}}"></script>
<script src="{{asset('js/reservaciones/edit.js')}}"></script>
@endpush