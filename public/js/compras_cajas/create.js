$.validator.addMethod("valido", function(value, element) {
	var valid = false;

	if(value>=0){
		valid=true;
	}
	return valid;
}, "El Monto ingresado no puede ser negativo");

var validator = $("#CompraCajaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	////onfocusout: true,
	
	rules: {
		caja_id:{
			required: true,
		},
		documento_id:{
			required: true,
		},
		numero_doc:{
			required: true,
		},
		descripcion:{
			required: true,
		},
		total:{
			required: true,
			valido: true
		}

	},
	messages: {
		caja_id: {
			required: "Por favor, seleccione caja"
		},
		documento_id: {
			required: "Por favor, seleccione un documento"
		},
		numero_doc: {
			required: "Por favor, ingrese número de documento"
		},
		descripcion: {
			required: "Por favor, ingrese descripción"
		},
		total: {
			required: "Por favor, ingrese total",
			min: "El valor ingresado debe ser mayor o igual a 0"
		}
	}
});
function BorrarFormularioCompraCaja() {
    $("#CompraCajaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonCompraCajaModal").click(function(event) {
	event.preventDefault();
	if ($('#CompraCajaForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');
	$('.loader').addClass('is-active');	
	var formData = $("#CompraCajaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCompraCaja').val()},
		url: APP_URL+"/compras_cajas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			$('#modalCompraCaja').modal("hide");
			compras_cajas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Compra registrada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			/*var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#CompraCajaForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}*/
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalCompraCaja').modal('show');
	}

	$('#modalCompraCaja').on('hide.bs.modal', function(){
		$("#CompraCajaForm").validate().resetForm();
		document.getElementById("CompraCajaForm").reset();
		window.location.hash = '#';
	});

	$('#modalCompraCaja').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 