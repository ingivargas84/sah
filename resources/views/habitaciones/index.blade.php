@extends('layouts.app')
@section('content')
@include('habitaciones.createModal')
@include('habitaciones.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado Habitaciones</h3>
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalHabitacion">
        <i class="fa fa-plus"></i>Agregar Habitación
      </button>

        <table id="habitaciones-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('scripts')
  <script src="{{asset('js/habitaciones/index.js')}}"></script>
  <script src="{{asset('js/habitaciones/create.js')}}"></script>
  <script src="{{asset('js/habitaciones/edit.js')}}"></script>
@endpush