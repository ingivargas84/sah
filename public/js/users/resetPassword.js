var validator = $("#ResetPasswordTerceroForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		password: {
			required: true
        },
        password_confirmation: {
            required: true
        }

	},
	messages: {
		password: {
			required: "Por favor, ingrese contraseña"
        },
        password_confirmation: {
            required: "Por favor, confirme contraseña"
        }
	}
});

$('#modalResetPasswordTercero').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
    var id = button.data('id');
    	
    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);

    var nueva = $("input[name='id']").val();
    console.log(nueva);
 });
 
function BorrarFormularioReset() {
    $("#ResetPasswordTerceroForm :input").each(function () {
        $(this).val('');
	});
};

$("#btnResetPasswordTercero").click(function(event) {
	event.preventDefault();
	if ($('#ResetPasswordTerceroForm').valid()) {
		
		resetModalT();
	} else {
		validator.focusInvalid();
	}
});



function resetModalT(button) {	
    var formData = $("#ResetPasswordTerceroForm").serialize();
	var id = $("#resetId").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenResetTercero').val()},
		url: urlActual+"/reset/tercero/"+id,
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioReset();
			$('#modalResetPasswordTercero').modal("hide");
			users_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('La contraseña se cambio Correctamente!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
            var errors = JSON.parse(errors.responseText);

			if (errors.password != null) {
				for (i = 0; i < errors.password.length; i++) {
					$("#ResetPasswordTerceroForm input[name='password'] ").after("<label class='error' id='ErrorPassword'>"+errors.password[i]+"<br></label>");
				  }
			}
			else{
				$("#ErrorPassword").remove();
			}
		}
		
	});
}

if(window.location.hash === '#resetT')
	{
		$('#modalResetPasswordTercero').modal('show');
	}

		$('#modalResetPasswordTercero').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$(".error").remove();
		BorrarFormularioReset();
	});

		$('#modalResetPasswordTercero').on('shown.bs.modal', function(){
		window.location.hash = '#resetT';

	}); 




