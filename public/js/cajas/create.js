var validator = $("#CajaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});
function BorrarFormularioCaja() {
    $("#CajaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonCajaModal").click(function(event) {
	$('.loader').addClass('is-active');	
	event.preventDefault();
	if ($('#CajaForm').valid()) {
		saveModal();
	} else {
		$('.loader').removeClass('is-active');	
		validator.focusInvalid();
	}
});


if(window.location.hash === '#create')
	{
		$('#modalCaja').modal('show');
	}

	$('#modalCaja').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioCaja();
	});

	$('#modalCaja').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 