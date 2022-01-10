@extends('layouts.app')

@section('content')
@include('tipo_habitacion.createModal')
@include('tipo_habitacion.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado Tipos de Habitaciones </h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modaltipo_habitacion">
        <i class="fa fa-plus"></i>Agregar tipo
      </button>

        <table id="tipo_habitacion-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('scripts')
  <script src="{{asset('js/tipo_habitacion/index.js')}}"></script>
  <script src="{{asset('js/tipo_habitacion/create.js')}}"></script>
  <script src="{{asset('js/tipo_habitacion/edit.js')}}"></script>
@endpush