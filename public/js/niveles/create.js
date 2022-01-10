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
}, "El nombre del Nivel ya está registrado en el sistema");

var validator = $("#NivelForm").validate({
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
			required: "Por favor, ingrese nombre"
		}
	}
});
function BorrarFormularioNivel() {
    $("#NivelForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonNivelModal").click(function(event) {
	event.preventDefault();
	if ($('#NivelForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#NivelForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenNivel').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioNivel();
			$('#modalNivel').modal("hide");
			niveles_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Nivel Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#NivelForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalNivel').modal('show');
	}

	$('#modalNivel').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioNivel();
	});

	$('#modalNivel').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 