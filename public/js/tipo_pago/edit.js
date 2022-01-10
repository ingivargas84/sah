$.validator.addMethod("nombreUnicoedit", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/tipo_pago/nombreDisponibleEdit",
		data: {"tipo_pago" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El Tipo de Pago ya está registrado en el sistema");

var validator = $("#tipo_pagoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		tipo_pago:{
			required: true,
			nombreUnicoedit : true
		}

	},
	messages: {
		tipo_pago: {
			required: "Por favor, Ingrese El Tipo de Pago"
		}
	}
});

$('#modalUpdatetipo_pago').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var tipo_pago = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='tipo_pago']").val(tipo_pago);

 }); 

function BorrarFormularioUpdate() {
    $("#tipo_pagoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtontipopagoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#tipo_pagoUpdateForm').valid()) {
		
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').addClass('is-active');
	var formData = $("#tipo_pagoUpdateForm").serialize();
	var id = $("input[name='id']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokentipo_pagoEdit').val()},
		url: APP_URL+"/tipo_pago/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioUpdate();
			$('#modalUpdatetipo_pago').modal("hide");
			tipo_pago_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('tipo_pago Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#tipo_pagoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdatetipo_pago').modal('show');
       }
    
       $('#modalUpdatetipo_pago').on('hide.bs.modal', function(){
          window.location.hash = '#';
		  $("label.error").remove();
		  BorrarFormularioUpdate();
       });
    
       $('#modalUpdatetipo_pago').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   




