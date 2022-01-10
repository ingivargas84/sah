@extends('layouts.app')

@section('content')
@include('users.confirmarAccionModal')
<div class="loader loader-double is-active"></div>
<div id="content">
  <div class="container-custom">
    <div class="panel panel-default">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <h3 class="box-title">Listado de Clientes</h3>
        <a class="btn btn-primary pull-right" href="{{route('clientes.new')}}">
        <i class="fa fa-plus"></i>Agregar cliente</a>
        <div class="panel panel-body" >
          <table id="clientes-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
          </table>
          <input type="hidden" name="urlActual" value="{{url()->current()}}">
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script src="{{asset('js/clientes/index.js')}}"></script>
 @endpush
