$.validator.addMethod("nombreUnicoEdit", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponibleEdit",
		data: {"tipo_cliente" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de cliente ya está registrado en el sistema");

var validator = $("#TipoClienteUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		tipo_cliente:{
			required: true,
			nombreUnicoEdit: true
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

$('#modalUpdateTipoCliente').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var tipo_cliente = button.data('tipo_cliente');
	var descuento = button.data('descuento');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='tipo_cliente']").val(tipo_cliente);
	modal.find(".modal-body input[name='descuento']").val(descuento);

 }); 

function BorrarFormularioUpdate() {
    $("#TipoClienteUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonTipoClienteModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#TipoClienteUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#TipoClienteUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoClienteEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdateTipoCliente').modal("hide");
			tipos_clientes_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Cliente Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#TipoClienteUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateTipoCliente').modal('show');
       }
    
       $('#modalUpdateTipoCliente').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdateTipoCliente').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




