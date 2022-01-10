$.validator.addMethod("valido", function(value, element) {
	var valid = false;

	if(value>=0){
		valid=true;
	}
	return valid;
}, "El Monto ingresado no puede ser negativo");

var validator = $("#AperturaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    ////onfocusout: true,
	rules: {
		monto:{
			required: true,
			valido: true
		},
		user_cajero_id:{
			required: true
		},
		descripcion_apertura:{
			required: true
		}

	},
	messages: {
		monto: {
			required: "Por favor, ingrese nombre",
			min: "El valor ingresado debe ser igual o mayor a 0"
		},
		user_cajero_id: {
			required: "Por favor, seleccione cajero"
		},
		descripcion_apertura: {
			required: "Por favor, ingrese una descripción "
		}
	}
});
function BorrarFormularioApertura() {
    $("#AperturaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonAperturaModal").click(function(event) {
	event.preventDefault();
	if ($('#AperturaForm').valid()) {
		saveApertura();
	} else {
		validator.focusInvalid();
	}
});

$('#modalApertura').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	
	var modal = $(this);
	modal.find(".modal-body input[name='caja_id']").val(id);
	

 }); 
 cargarSelectUserApertura();

function saveApertura(button) {	
	$('.loader').addClass('is-active');
	var formData = $("#AperturaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenApertura').val()},
		url: APP_URL+"/aperturas_cajas/apertura",
		data: formData,
		dataType: "json",
		statusCode: {
			403: function (xhr) {
				$('.loader').removeClass('is-active');
				//console.log('403 response');
				alertify.set('notifier','position', 'top-center');
				alertify.error('El usuario no tiene permisos para realizar esta acción');
			}
		},
		success: function(data) {
			$('.loader').removeClass('is-active');
			//BorrarFormularioApertura();
			$('#modalApertura').modal("hide");
			cajas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Caja Aperturada con Éxito!!');
			cargarSelectUserApertura();			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.password_admin != null) {
				$("#AperturaForm input[name='password_admin'] ").after("<label class='error' id='ErrorPasswordAdmin'>"+errors.password_admin+"</label>");
			}
			else{
				$("#ErrorPasswordAdmin").remove();
			}
		},
		always: function() {
			$('.loader').removeClass('is-active');
	},
		
	});
}

if(window.location.hash === '#apertura')
	{
		$('#modalApertura').modal('show');
	}

	$('#modalApertura').on('hide.bs.modal', function(){
		$("#AperturaForm").validate().resetForm();
		document.getElementById("AperturaForm").reset();
		window.location.hash = '#';
	});

	$('#modalApertura').on('shown.bs.modal', function(){
		window.location.hash = '#apertura';

	});
	
	
	function cargarSelectUserApertura(){
		$('#user_cajero_id').empty();
		$("#user_cajero_id").append('<option value="" selected disabled>Seleccione Usuario</option>');
		$.ajax({
		  type: "GET",
		  url: APP_URL+"/users/cargarA", 
		  dataType: "json",
		  success: function(data){
			$.each(data,function(key, registro) {	

			  $("#user_cajero_id").append('<option value='+registro.id+'>'+registro.name+'</option>');
			  
			});
		
		  },
		  error: function(data) {
			alert('error');
		  }
		  });
	}