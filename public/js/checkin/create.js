window.onload = function() {
	$('.loader').removeClass('is-active');
	var dias=$('#dias').val();
	var precio=$('#precioh').val();
	var adelanto=parseInt( $('#ad').val());
	var pr=(precio*(-dias)).toFixed(2)
	
	if(!dias){

	}
	else {
		$('#tarifa').val(-dias);
		$('#precio').val(pr);
		$('#adelanto').val(((pr*adelanto)/100).toFixed(2) );
	}
};

$.validator.addMethod("Tvalid", function(value, element) {
	var valid = false;

	if(value>0){
		valid=true;
	}
	return valid;
}, "Debe ingresar una cantida de Días Valida");


$.validator.addMethod("Avalid", function(value, element) {
	var valid = false;

	if(value>=0){
		valid=true;
	}
	return valid;
}, "El Monto ingresado no puede ser negativo");

$.validator.addMethod("Avalid2", function(value, element) {
	var valid = false;
	var precio=parseInt($('#precio').val());
	if(value<=precio){
		valid=true;
	}
	return valid;
}, "El Monto ingresado no puede ser mayor al Precio de Habitación");



var validator = $("#CheckinForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		documento_id:{
			required: true,
		},
		tarifa:{
			Tvalid:true,
			required: true,
		},
		adelanto:{
			Avalid:true,
			Avalid2:true
		}
	},
	messages: {
		documento_id: {
			required: "Por favor, Seleccione un cliente"
		},
		tarifa: {
			required: "Debe ingresar la cantidad de Dias a Hospedar"
		}
	}
});

function changeDocumento() {
	var id = $("#tipo_documento_id").val();
	
	var url = "/check-in/documentos/" + id ;
	if (id != "") {
			$.getJSON( url , function ( result ) {
		
		var selector ='<option value="" disabled selected>Selecciona No. de Documento de Identificación</option>'
		for (let index = 0; index < result.length; index++) {
			selector += '<option value="'+result[index].id+'">'+result[index].no_documento+'</option>';	
		}
		selector += ""
		
		$('#documento_id').html(selector).fadeIn();
			});
	}
}

$('#tipo_documento_id').change(function(){
	changeDocumento();
});

function changeCliente() {
	var id = $("#documento_id").val();
	
	var url = "/check-in/clientes/" + id ;
	if (id != "") {
			$.getJSON( url , function ( result ) {		
			for (let index = 0; index < result.length; index++) {
			$('#nombres').val(result[index].nombres);
			$('#direccion').val(result[index].direccion);
			}
	});
}
}

$('#documento_id').change(function(){
	changeCliente();
});

$('#tarifa').keyup(function(){
	var precio=$('#precioh').val();
	var tarifa=$('#tarifa').val();
$('#precio').val((precio*tarifa).toFixed(2));
	
});
$("#Buttoncheck").click(function(event) {
	event.preventDefault();
	$('.loader').addClass('is-active');
	if ($('#CheckinForm').valid()) {
		saveModal();
	} else {
		$('.loader').removeClass('is-active');
		validator.focusInvalid();
	}
});


function saveModal(button) {
		var precio=$('#precio').val();
		var formData={
			precio: precio ,
			habitacion_id:$('#habitacion_id').val(),
			cliente_id:$('#documento_id').val(),
			adelanto:$('#adelanto').val(),
			fecha:$('#fecha').val(),
			reservacion_id:$('#reservacion_id').val()
		}
    $.ajax({
      type: "POST",
      headers: {'X-CSRF-TOKEN': $('#tokenChek').val()},
      url: APP_URL+"/check-in/save",
      data: formData,
      dataType: "json",
      success: function(data) {
			window.location = "/check-in" 

      },
      error: function(errors) {
			$('.loader').removeClass('is-active');
      
      }
      
    });
  }

