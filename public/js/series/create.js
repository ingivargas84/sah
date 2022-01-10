$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});
$.validator.addMethod("rangoUnico", function(value, element) {
	var valid = false;
	var serie = $("input[name='serie'] ").val();
	var inicio = $("input[name='inicio'] ").val();
	var fin = $("input[name='fin']").val();

	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/series/rangoDisponible",
		data: {"serie" : serie, "inicio" : inicio, "fin" : fin}, 
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El rango ingresado es menor al de la última resolución");


$.validator.addMethod("inicioValido", function(value, element) {
	var valid = false;
	var inicio = $("input[name='inicio'] ").val();
	if(inicio>0){
		valid=true;
	}
	return valid;
}, "El Número ingresado no puede ser negativo");

$.validator.addMethod("finValido", function(value, element) {
	var valid = false;
	var fin = $("input[name='fin'] ").val();
	if(fin>0){
		valid=true;
	}
	return valid;
}, "El Número ingresado no puede ser negativo");


$("#inicio").focusout(function () {
    ComprobarDatosCreate();
});

$("input[name='serie'] ").focusout(function () {
	$("#inicio").attr("disabled", false);
});

$("input[name='inicio'] ").focusout(function () {
	if ($('.error').text() == "")
	{
		$("input[name='fin']").attr("disabled", false);
	}

	
});

$.validator.addMethod("finMayor", function(value, element) {
	var valid = false;
	var inicio = $("input[name='inicio'] ").val();

	if (value > inicio )
	{
		valid = true;
		return valid;
	}

	else{
		return valid;
	}
	
}, "El Número ingresado debe ser mayor al de inicio");

var validator = $("#SerieForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		resolucion:{
			required: true,
		},

		serie: {
			required : true
		},
		inicio:{
			required: true,
			inicioValido: true,
			rangoUnico: true
		},
		fin:{
			required : true,
			finMayor : true,
			finValido: true
		},
		fecha_resolucion:{
			required: true
		},
		fecha_vencimiento:{
			required: true
		}

	},
	messages: {
		resolucion:{
			required: "Debe ingresar El Número de Resolución",
		},

		serie: {
			required : "Debe Ingresar La Serie"
		},
		inicio:{
			required: "Debe Ingresar un número de Inicio"
		},
		fin:{
			required : "Debe Ingresar un número de Fin"
		},
		fecha_resolucion:{
			required: "ingrese La Fecha de Autorizacion de Resolución"
		},
		fecha_vencimiento:{
			required: "Seleccione La Fecha de Vencimiento"
		}
	

	}
});
function BorrarFormularioSerie() {
    $("#SerieForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};


$("#ButtonSerieModal").click(function(event) {
	event.preventDefault();
	if ($('#SerieForm').valid()) {
		
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$('.loader').addClass('is-active');
	var formData = $("#SerieForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenSerie').val()},
		url: "/series/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioSerie();
			$('#modalSerie').modal("hide");
			series_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Serie Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#SerieForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		},

		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalSerie').modal('show');
	}

	$('#modalSerie').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioSerie();
	});

	$('#modalSerie').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 