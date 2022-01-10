@extends('layouts.app')
@section('content')
@include('series.createModal')
@include('series.editModal')
@include('users.confirmarAccionModal')
@include('series.EstadoModal')
<div class="loader loader-double is-active"></div>
<div id="content">
  <div class="container-custom">
    <div class="panel panel-default">
<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

      <h3 class="box-title">Listado de Series </h3>
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalSerie">
        <i class="fa fa-plus"></i>Agregar Serie
      </button>
      <div class="row">
      <div class="panel panel-body col-sm-12">
        <table id="series-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  ellspacing="0" width="100%" >            
        </table>
      </div>
    </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script src="{{asset('js/series/index.js')}}"></script>
  <script src="{{asset('js/series/create.js')}}"></script>
  <script src="{{asset('js/series/edit.js')}}"></script>
  <script src="{{asset('js/series/estado.js')}}"></script>
@endpush