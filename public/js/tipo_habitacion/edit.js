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
}, "El Tipo de Habitación ya está registrado en el sistema");

var validator = $("#tipo_habitacionUpdateForm").validate({
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
			required: "Por favor, El Tipo de Habitación"
		}
	}
});

$('#modalUpdatetipo_habitacion').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#tipo_habitacionUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtontipohabitacionModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#tipo_habitacionUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#tipo_habitacionUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokentipo_habitacionEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdatetipo_habitacion').modal("hide");
			tipo_habitacion_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('tipo_habitacion Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#tipo_habitacionUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdatetipo_habitacion').modal('show');
       }
    
       $('#modalUpdatetipo_habitacion').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdatetipo_habitacion').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




