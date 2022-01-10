@extends('layouts.app')


@section('content')
<div class="loader loader-double is-active"></div>
@include('compras_cajas.createModal')
  <div id="content">
    <div class="container-custom">
      <div class="panel panel-default">
  <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
  
  <h3 class="box-title">Listado de Compras por Caja</h3>
  
  <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalCompraCaja">
    <i class="fa fa-plus"></i>Agregar Compra
  </button>
        <div class="panel panel-body">
  
          <table id="compras_cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">            
          </table>
        </div>
        </div>
      </div>
    </div>

@endsection

@push('scripts')
  <script src="{{asset('js/compras_cajas/index.js')}}"></script>
  <script src="{{asset('js/compras_cajas/create.js')}}"></script>
@endpush