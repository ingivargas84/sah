@extends('layouts.app')

@section('content')
<div id="content">
  <div class="container-custom">
    <div class="panel panel-default">
    <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado de Movimientos de Caja</h3>
      <div class="panel panel-body">

        <table id="movimientos_cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
      </div>
      </div>
    </div>
  </div>
<input type="hidden" id="idcaja" value="{{$caja->id}}">
@endsection


@push('scripts')
<script src="{{asset('js/cajas/show.js')}}"></script>

@endpush