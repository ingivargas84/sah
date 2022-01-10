@extends('layouts.app')

@section('content')
@include('cajas.createModal')
@include('cajas.editModal')
@include('users.confirmarAccionModal')
@include('aperturas_cajas.aperturaModal')
@include('aperturas_cajas.cierreModal')
  <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">

  <h3 class="box-title">Listado de Cajas</h3>
  <div class="loader loader-double is-active"></div>

  <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalCaja">
      <i class="fa fa-plus"></i>Agregar Caja
    </button>

    <table id="cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="98%">            
      </table>



@endsection


@push('scripts')
<script>
  


  function confirmarAccion(button) {
	
$('.loader').addClass('is-active');
    var formData = $("#ConfirmarAccionForm").serialize();
    //var id = $("#idConfirmacion").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
    //url: "/cajas/" + id + "/delete",
    url: "{{route('cajas.delete')}}",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
            BorrarFormularioConfirmar();
			$('#modalConfirmarAccion').modal("hide");
			cajas_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('La Caja se Desactivó Correctamente!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
      if(errors.responseText !=""){
          var errors = JSON.parse(errors.responseText);
          if (errors.password_actual != null) {
              $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>"+errors.password_actual+"</label>");
          }
          else{
              $("#ErrorPassword_actual").remove();
          }
      }
            
		}
		
	});
}

</script>

  <script src="{{asset('js/cajas/index.js')}}"></script>
  <script src="{{asset('js/cajas/create.js')}}"></script>
  <script src="{{asset('js/cajas/edit.js')}}"></script>
  <script src="{{asset('js/aperturas_cajas/apertura.js')}}"></script>
  <script src="{{asset('js/aperturas_cajas/cierre.js')}}"></script>
@endpush