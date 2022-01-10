$.validator.addMethod("nombreUnicoedit", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponibleEdit",
		data: {"nombre" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Servicio Extra ya está registrado en el sistema");

var validator = $("#tipo_servicios_extraUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre:{
			required: true,
			nombreUnicoedit : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, El Tipo de Servicio Extra"
		}
	}
});

$('#modalUpdatetipo_servicios_extra').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#tipo_servicios_extraUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtontipoServicioModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#tipo_servicios_extraUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#tipo_servicios_extraUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokentipo_servicios_extraEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdatetipo_servicios_extra').modal("hide");
			tipo_servicios_extra_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('tipo_servicios_extra Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#tipo_servicios_extraUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdatetipo_servicios_extra').modal('show');
       }
    
       $('#modalUpdatetipo_servicios_extra').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdatetipo_servicios_extra').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




