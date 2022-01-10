$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponible",
		data: "nombre_servicio=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre de Servicio Extra ya está registrado en el sistema");

var validator = $("#ServicioExtraForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre_servicio:{
			required: true,
			nombreUnico: true
		},
		tipo_id:{
			required:true
		},
		precio:{
			required:true
		},
		descripcion:{
			required:true
		},

	},
	messages: {
		nombre_servicio: {
			required: "Por favor, ingrese nombre del Servicio Extra "
		},
		tipo_id:{
			required:"Por favor, seleccione un tipo de Servicio Extra"
		},
		precio:{
			required:"Por favor, ingrese el precio"
		},
		descripcion:{
			required:"Por favor, una descripción"
		},
	}
});
function BorrarFormularioServicioExtra() {
    $("#ServicioExtraForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonServicioExtraModal").click(function(event) {
	event.preventDefault();
	if ($('#ServicioExtraForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#ServicioExtraForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenServicioExtra').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioServicioExtra();
			$('#modalServicioExtra').modal("hide");
			servicios_extra_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Servicio Extra Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#ServicioExtraForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalServicioExtra').modal('show');
	}

	$('#modalServicioExtra').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioServicioExtra();
	});

	$('#modalServicioExtra').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 