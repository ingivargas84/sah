$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/impuestos/nombreDisponible",
		data: "nombre_impuesto=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de impuesto ya está registrado en el sistema");

$.validator.addMethod("Valido", function(value, element) {
	var valid = false;
	var pr=parseInt($("#porcentaje").val());
	if(pr>0){
		valid=true;
	}
	return valid;
}, "El Porccentaje de impuesto no puede ser negativo");

var validator = $("#TipoImpuestoForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre_impuesto:{
			required: true,
			nombreUnico: true
		},
		porcentaje:{
			required:true,
			Valido:true,
		}

	},
	messages: {
		nombre_impuesto: {
			required: "Por favor, ingrese el tipo de Impuesto"
		},
		porcentaje:{
			required: "Por favor, ingrese el porcentaje de impuesto"
		}
	}
});
function BorrarFormularioTipoImpuesto() {
    $("#TipoImpuestoForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonTipoImpuestoModal").click(function(event) {
	event.preventDefault();
	if ($('#TipoImpuestoForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#TipoImpuestoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoImpuesto').val()},
		url:  APP_URL+"/impuestos/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioTipoImpuesto();
			$('#modalTipoImpuesto').modal("hide");
			impuestos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Impuesto Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#TipoImpuestoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalTipoImpuesto').modal('show');
	}

	$('#modalTipoImpuesto').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioTipoImpuesto();
	});

	$('#modalTipoImpuesto').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 