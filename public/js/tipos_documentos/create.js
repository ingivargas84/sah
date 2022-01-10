$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponible",
		data: "tipo_documento=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Documento de identificación ya está registrado en el sistema");

var validator = $("#TipoDocumentoForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		tipo_documento:{
			required: true,
			nombreUnico: true
		},
		

	},
	messages: {
		tipo_documento: {
			required: "Por favor, ingrese el tipo de Documento de identificación"
		},
		
	}
});
function BorrarFormularioTipoDocumento() {
    $("#TipoDocumentoForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonTipoDocumentoModal").click(function(event) {
	event.preventDefault();
	if ($('#TipoDocumentoForm').valid()) {
		
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').addClass('is-active');	
	var formData = $("#TipoDocumentoForm").serialize();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoDocumento').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioTipoDocumento();
			$('#modalTipoDocumento').modal("hide");
			tipos_documentos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Documento de identificación Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#TipoDocumentoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalTipoDocumento').modal('show');
	}

	$('#modalTipoDocumento').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioTipoDocumento();
	});

	$('#modalTipoDocumento').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 