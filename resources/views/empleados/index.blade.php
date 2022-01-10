@extends('layouts.app')

@section('content')
@include('empleados.asignaUserModal')
<div class="loader loader-double is-active"></div>
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
      <h3 class="box-title">Listado de Empleados</h3>

      <a class="btn btn-primary pull-right" href="{{route('empleados.new')}}">
        <i class="fa fa-plus"></i>Agregar Empleado</a>

        <table id="empleados-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('scripts')
  
  <script src="{{asset('js/empleados/index.js')}}"></script>
  <script src="{{asset('js/empleados/asignarUser.js')}}"></script>
@endpush