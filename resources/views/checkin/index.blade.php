@extends('layouts.app')

@section('content')
@include('users.confirmarAccionModal')
  <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

  <h3 class="box-title">Listado de Check-in Diarios</h3>
  <div class="loader loader-double is-active"></div>

    <table id="checkin-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
      </table>



@endsection


@push('scripts')

  <script src="{{asset('js/checkin/index.js')}}"></script>
@endpush