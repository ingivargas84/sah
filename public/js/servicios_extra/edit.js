$.validator.addMethod("nombreUnicoEdit", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponibleEdit",
		data: {"nombre_servicio" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre de Habitación ya está registrado en el sistema");

var validator = $("#ServicioExtraUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre_servicio:{
			required: true,
			nombreUnicoEdit: true
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

$('#modalUpdateServicioExtra').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre_servicio = button.data('nombre_servicio');
	var tipo_id = button.data('tipo_id');
	var descripcion = button.data('descripcion');
	var precio = button.data('precio');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre_servicio']").val(nombre_servicio);
	modal.find(".modal-body input[name='tipo_id']").val(tipo_id);
	modal.find(".modal-body input[name='descripcion']").val(descripcion);
	modal.find(".modal-body input[name='precio']").val(precio);

	cargarSelectTipoServicioExtra(tipo_id);
 }); 

function BorrarFormularioUpdate() {
    $("#ServicioExtraUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonServicioExtraModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#ServicioExtraUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#ServicioExtraUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenServicioExtraEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdateServicioExtra').modal("hide");
			servicios_extra_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Servicio Extra Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#ServicioExtraUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateServicioExtra').modal('show');
       }
    
       $('#modalUpdateServicioExtra').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdateServicioExtra').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   
	  
	
