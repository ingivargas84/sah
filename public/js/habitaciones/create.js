var validator = $("#HabitacionForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre_habitacion:{
			required: true,
			nombreUnico: true
		},
		nivel_id:{
			required:true
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
		nombre_habitacion: {
			required: "Por favor, ingrese nombre/número de habitación "
		},
		nivel_id:{
			required:"Por favor, seleccione un nivel"
		},
		tipo_id:{
			required:"Por favor, seleccione un tipo de habitación"
		},
		precio:{
			required:"Por favor, ingrese el precio"
		},
		descripcion:{
			required:"Por favor, una descripción"
		},
	}
});
function BorrarFormularioHabitacion() {
    $("#HabitacionForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonHabitacionModal").click(function(event) {
	event.preventDefault();
	if ($('#HabitacionForm').valid()) {

		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#HabitacionForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenHabitacion').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioHabitacion();
			$('#modalHabitacion').modal("hide");
			habitaciones_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Habitación Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#HabitacionForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalHabitacion').modal('show');
	}

	$('#modalHabitacion').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioHabitacion();
	});

	$('#modalHabitacion').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 