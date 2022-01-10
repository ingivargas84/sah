@extends('layouts.app')

@section('content')

@include('users.createModalUser')
@include('users.editModalUser')
@include('users.resetPasswordTercero')


      <h3 class="box-title">Listado de Usuarios</h3>

      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalUser">
        <i class="fa fa-plus"></i>Agregar Usuario</button>

      <input type="hidden" name="rol_user" value="{{$user->roles[0]->name}}">
        <table id="users-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script src="{{asset('js/users/index.js')}}"></script>
  <script src="{{asset('js/users/create.js')}}"></script>
  <script src="{{asset('js/users/edit.js')}}"></script>
  <script src="{{asset('js/users/resetPassword.js')}}"></script>
@endpush