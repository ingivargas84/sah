$.validator.addMethod("nombreUnicoEdit", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponibleEdit",
		data: {"tipo_documento" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Documento de identificación ya está registrado en el sistema");

var validator = $("#TipoDocumentoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		tipo_documento:{
			required: true,
			nombreUnicoEdit: true
		}

	},
	messages: {
		tipo_documento: {
			required: "Por favor, ingrese el tipo de Documento de identificación"
		}
	}
});

$('#modalUpdateTipoDocumento').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var tipo_documento = button.data('tipo_documento');
	var descuento = button.data('descuento');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='tipo_documento']").val(tipo_documento);
	modal.find(".modal-body input[name='descuento']").val(descuento);

 }); 

function BorrarFormularioUpdate() {
    $("#TipoDocumentoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonTipoDocumentoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#TipoDocumentoUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#TipoDocumentoUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoDocumentoEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdateTipoDocumento').modal("hide");
			tipos_documentos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Documento de identificación Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#TipoDocumentoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateTipoDocumento').modal('show');
       }
    
       $('#modalUpdateTipoDocumento').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdateTipoDocumento').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




