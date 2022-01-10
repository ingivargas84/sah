@extends('layouts.app')

@section('content')
@include('tipos_documentos.createModal')
@include('tipos_documentos.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado De Tipos de Documentos de Identificación</h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalTipoDocumento">
        <i class="fa fa-plus"></i>Agregar tipo de Documento
      </button>

        <table id="tipos_documentos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('scripts')
  <script src="{{asset('js/tipos_documentos/index.js')}}"></script>
  <script src="{{asset('js/tipos_documentos/create.js')}}"></script>
  <script src="{{asset('js/tipos_documentos/edit.js')}}"></script>

@endpush