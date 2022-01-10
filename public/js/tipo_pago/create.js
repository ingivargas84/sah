$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/tipo_pago/nombreDisponible",
		data: "tipo_pago=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Pago ya está registrado en el sistema");

var validator = $("#tipo_pagoForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		tipo_pago:{
			required: true,
			nombreUnico: true
		}

	},
	messages: {
		tokentipo_pago: {
			required: "Por favor, ingrese el tipo de Pago"
		}
	}
});
function BorrarFormulariotipo_pago() {
    $("#tipo_pagoForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtontipopagoModal").click(function(event) {
	event.preventDefault();
	if ($('#tipo_pagoForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#tipo_pagoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokentipo_pago').val()},
		url: APP_URL+"/tipo_pago/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormulariotipo_pago();
			$('#modaltipo_pago').modal("hide");
			tipo_pago_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Pago Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#tipo_pagoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modaltipo_pago').modal('show');
	}

	$('#modaltipo_pago').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormulariotipo_pago();
	});

	$('#modaltipo_pago').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 