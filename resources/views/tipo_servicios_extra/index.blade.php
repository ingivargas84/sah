@extends('layouts.app')

@section('content')
@include('tipo_servicios_extra.createModal')
@include('tipo_servicios_extra.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado Tipos de Servicios Extras </h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modaltipo_servicios_extra">
        <i class="fa fa-plus"></i>Agregar tipo servicio
      </button>

        <table id="tipo_servicios_extra-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('scripts')
  <script src="{{asset('js/tipo_servicios_extra/index.js')}}"></script>
  <script src="{{asset('js/tipo_servicios_extra/create.js')}}"></script>
  <script src="{{asset('js/tipo_servicios_extra/edit.js')}}"></script>
@endpush