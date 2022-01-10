@extends('layouts.app')

@section('content')
@include('impuestos.createModal')
@include('impuestos.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado De Tipos de Impuestos</h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalTipoImpuesto">
        <i class="fa fa-plus"></i>Agregar tipo de impuesto
      </button>

        <table id="impuestos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">            
        </table>

@endsection


@push('scripts')
  <script src="{{asset('js/impuestos/index.js')}}"></script>
  <script src="{{asset('js/impuestos/create.js')}}"></script>
  <script src="{{asset('js/impuestos/edit.js')}}"></script>
@endpush