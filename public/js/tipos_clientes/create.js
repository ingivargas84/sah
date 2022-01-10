$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponible",
		data: "tipo_cliente=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Cliente ya está registrado en el sistema");

var validator = $("#TipoClienteForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		tipo_cliente:{
			required: true,
			nombreUnico: true
		},
		descuento:{
			required:true
		}

	},
	messages: {
		tipo_cliente: {
			required: "Por favor, ingrese el tipo de cliente"
		},
		descuento:{
			required: "Por favor, ingrese el porcentaje de descuento"
		}
	}
});
function BorrarFormularioTipoCliente() {
    $("#TipoClienteForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonTipoClienteModal").click(function(event) {
	event.preventDefault();
	if ($('#TipoClienteForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#TipoClienteForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoCliente').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioTipoCliente();
			$('#modalTipoCliente').modal("hide");
			tipos_clientes_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Cliente Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#TipoClienteForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalTipoCliente').modal('show');
	}

	$('#modalTipoCliente').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioTipoCliente();
	});

	$('#modalTipoCliente').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 