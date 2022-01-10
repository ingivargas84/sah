$.validator.addMethod("nombreUnicoEdit", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/impuestos/nombreDisponibleEdit",
		data: {"nombre_impuesto" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Impuesto ya está registrado en el sistema");

$.validator.addMethod("ValidoEdit", function(value, element) {
	var valid = false;
	var pr=parseInt($("#porcentajee").val());
	if(pr>0){
		valid=true;
	}
	return valid;
}, "El Porccentaje de impuesto no puede ser negativo");

var validator = $("#TipoImpuestoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre_impuesto:{
			required: true,
			nombreUnicoEdit: true
		},
		porcentaje:{
			required:true,
			ValidoEdit:true,
		}

	},
	messages: {
		nombre_impuesto: {
			required: "Por favor, ingrese el tipo de Impuesto"
		},
		porcentaje:{
			required: "Por favor, ingrese el porcentaje de Impuesto"
		}
	}
});

$('#modalUpdateTipoImpuesto').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre_impuesto = button.data('nombre_impuesto');
	var porcentaje = button.data('porcentaje');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre_impuesto']").val(nombre_impuesto);
	modal.find(".modal-body input[name='porcentaje']").val(porcentaje);

 }); 

function BorrarFormularioUpdate() {
    $("#TipoImpuestoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonTipoImpuestoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#TipoImpuestoUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#TipoImpuestoUpdateForm").serialize();
	var id = $("input[name='id']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoImpuestoEdit').val()},
		url:  APP_URL+"/impuestos/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdateTipoImpuesto').modal("hide");
			impuestos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Impuesto Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#TipoImpuestoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateTipoImpuesto').modal('show');
       }
    
       $('#modalUpdateTipoImpuesto').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdateTipoImpuesto').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




