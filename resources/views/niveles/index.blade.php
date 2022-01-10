@extends('layouts.app')

@section('content')

@include('niveles.createModal')
@include('niveles.editModal')
@include('users.confirmarAccionModal')
<div id="content">
    <div class="loader loader-double is-active"></div>
  <div class="container-custom">
    <div class="panel panel-default">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

        <h3 class="box-title">Listado De Pisos/Niveles</h3>

        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalNivel">
          <i class="fa fa-plus"></i>Agregar Nivel
        </button>
        <div class="panel panel-body" >
          <table id="niveles-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
          </table>
        </div>
          <input type="hidden" name="urlActual" value="{{url()->current()}}">
      </div>
    </div>
  </div>
 @endsection


@push('scripts')
  <script src="{{asset('js/niveles/index.js')}}"></script>
  <script src="{{asset('js/niveles/create.js')}}"></script>
  <script src="{{asset('js/niveles/edit.js')}}"></script>

@endpush