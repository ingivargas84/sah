@extends('layouts.app')
@section('content')
@include('tipo_pago.createModal')
@include('tipo_pago.editModal')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<div id="content">
  <div class="container-custom">
    <div class="panel panel-default">
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado Tipos de Pago </h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modaltipo_pago">
        <i class="fa fa-plus"></i>Agregar tipo de Pago
      </button>
      <div class="panel panel-body">

        <table id="tipo_pago-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  ellspacing="0" width="98%" >            
        </table>
      </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script src="{{asset('js/tipo_pago/index.js')}}"></script>
  <script src="{{asset('js/tipo_pago/create.js')}}"></script>
  <script src="{{asset('js/tipo_pago/edit.js')}}"></script>
@endpush