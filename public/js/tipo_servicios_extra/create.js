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
}, "El Tipo de Servicio ya está registrado en el sistema");

var validator = $("#tipo_servicios_extraForm").validate({
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
			required: "Por favor, ingrese el tipo de servicio extra"
		}
	}
});
function BorrarFormulariotipo_servicios_extra() {
    $("#tipo_servicios_extraForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtontipohabitacionModal").click(function(event) {
	event.preventDefault();
	if ($('#tipo_servicios_extraForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#tipo_servicios_extraForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokentipo_servicios_extra').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormulariotipo_servicios_extra();
			$('#modaltipo_servicios_extra').modal("hide");
			tipo_servicios_extra_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Servicio Extra Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#tipo_servicios_extraForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modaltipo_servicios_extra').modal('show');
	}

	$('#modaltipo_servicios_extra').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormulariotipo_servicios_extra();
	});

	$('#modaltipo_servicios_extra').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 