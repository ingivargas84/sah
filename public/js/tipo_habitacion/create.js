$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponible",
		data: "nombre=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Habitación ya está registrado en el sistema");

var validator = $("#tipo_habitacionForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese el tipo de habitación"
		}
	}
});
function BorrarFormulariotipo_habitacion() {
    $("#tipo_habitacionForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtontipohabitacionModal").click(function(event) {
	event.preventDefault();
	if ($('#tipo_habitacionForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#tipo_habitacionForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokentipo_habitacion').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormulariotipo_habitacion();
			$('#modaltipo_habitacion').modal("hide");
			tipo_habitacion_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Habitación Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#tipo_habitacionForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modaltipo_habitacion').modal('show');
	}

	$('#modaltipo_habitacion').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormulariotipo_habitacion();
	});

	$('#modaltipo_habitacion').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 