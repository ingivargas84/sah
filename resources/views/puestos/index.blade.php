@extends('layouts.app')

@section('content')
@include('puestos.createModal')
@include('puestos.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado Puestos de Empleados</h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalPuesto">
        <i class="fa fa-plus"></i>Agregar Puesto
      </button>

        <table id="puestos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">
@endsection


@push('scripts')
  <script src="{{asset('js/puestos/index.js')}}"></script>
  <script src="{{asset('js/puestos/create.js')}}"></script>
  <script src="{{asset('js/puestos/edit.js')}}"></script>
@endpush