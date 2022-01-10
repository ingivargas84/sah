@extends('layouts.app')

@section('content')
@include('tipos_clientes.createModal')
@include('tipos_clientes.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado De Tipos de Clientes</h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalTipoCliente">
        <i class="fa fa-plus"></i>Agregar tipo de cliente
      </button>

        <table id="tipos_clientes-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('scripts')
  <script src="{{asset('js/tipos_clientes/index.js')}}"></script>
  <script src="{{asset('js/tipos_clientes/create.js')}}"></script>
  <script src="{{asset('js/tipos_clientes/edit.js')}}"></script>
@endpush