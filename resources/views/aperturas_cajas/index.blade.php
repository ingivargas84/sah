@extends('layouts.app')

@section('content')
@include('users.confirmarAccionModal')
  <div id="content">
    <div class="container-custom">
      <div class="panel panel-default">
  <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
  
        <h3 class="box-title">Listado de Cajas Aperturadas/Cerradas</h3>
  
        <div class="panel panel-body">
  
          <table id="aperturas_cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">            
          </table>
        </div>
        </div>
      </div>
    </div>


@endsection



@push('scripts')
  <script src="{{asset('js/aperturas_cajas/index.js')}}"></script>
@endpush