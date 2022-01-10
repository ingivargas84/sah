$('.loader').removeClass('is-active');
$.validator.addMethod("fecha_inicio_disponible", function(value, element) {
		var formData =  new Object();
				formData["fecha_inicio"]=$('#fecha_inicio').val();
				formData["fecha_fin"]=$('#fecha_fin').val();
				formData["habitacion_id"]=$('#habitacion_id').val();
		var valid = false;
				$.ajax({
						type: "GET",
						async: false,
						url: APP_URL+"/reservaciones/fecha_inicio",
						data: formData,
						dataType: "json",
						success: function(msg) {
								valid = !msg;
						}
				});
				return valid;
}, "La fecha seleccionada no está disponible.");

$.validator.addMethod("fecha_mayor", function(value, element) {
		var valid = false;
		var inicio=($('#fecha_inicio').val()).split('-').reverse().join('/');;
		var fin=($('#fecha_fin').val()).split('-').reverse().join('/');;
		if( new Date(fin).getTime() > new Date(inicio).getTime())
		{
			valid=true;
		}
		return valid;
	}, "La fecha de salida debe ser mayor a la fecha de entrada.");
	



$.validator.addMethod("fecha_fin_disponible", function(value, element) {

		var formData =  new Object();
		formData["fecha_inicio"]=$('#fecha_inicio').val();
		formData["fecha_fin"]=$('#fecha_fin').val();
		formData["habitacion_id"]=$('#habitacion_id').val();
		var valid = false;
				$.ajax({
						type: "GET",
						async: false,
						url: APP_URL+"/reservaciones/fecha_fin",
						data: formData,
						dataType: "json",
						success: function(msg) {
								valid = !msg;
						}
				});
				return valid;
	}, "La fecha seleccionada no está disponible.");

var validator = $("#ReservacionForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: true,
	rules: {
		nombres:{
			required: true,
		},
		telefono:{
			required:true,
		},
		fecha_inicio:{
			required:true,
			fecha_inicio_disponible:true,
		},
		fecha_fin:{
			required:true,
			fecha_fin_disponible:true,
			fecha_mayor:true
		},

	},
	messages: {
		nombres: {
			required: "Por favor, ingrese El nombre de quien reserva "
		},
		telefono:{
			required:"Por favor, Ingrese un número de teléfono"
		},
		tipo_id:{
			required:"Por favor, selecione una fecha de ingreso"
		},
		precio:{
			required:"Por favor, seleccione una fecha de salida"
		},
	}
});




function Calendario(datos){
$('#calendar').fullCalendar({
	schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
	selectable: true,
	editable: true,
	nowIndicator: true,
	allDay: false,
	forceEventDuration : true,
	locale: 'es',
	timeFormat: 'hh:mm a',
	themeSystem: 'jquery-ui',
	header: {
		left: 'today prev,next',
		center: 'title',
		right: '',
	},
	eventOverlap :false,
	selectOverlap: false,
	buttonText: {
        today: 'hoy',
        month: 'mes',
        week: 'semana',
        day: 'dia'
      },
	defaultView: 'timelineMonth',
	resourceAreaWidth: '20%',
	resourceColumns: [
	{
		labelText: 'Habitación',
		field: 'nombre_habitacion'
	},
	{
		labelText: 'Estado',
		field: 'estado'
	}
	],
	resources: datos,
	events: { // you can also specify a plain string like 'json/events.json'	
		url: APP_URL+'/reservaciones/get',
        error: function() {
          $('#script-warning').show();
				},
			 textColor:'#000',
      },
	select: function(startDate, endDate,jsEvent, view, resource) {
		$('#fecha_inicio').val(startDate.format('DD-MM-YYYY'));
		$('#fecha_fin').val(endDate.format('DD-MM-YYYY'));
		$('#habitacion_id').val(resource.id);
		$('#modalReservacion').modal();
	},// end select
	eventMouseover:function(event,domEvent,view){ 
    var el=$(this); 
    var layer='<div id="events-layer" class="fc-transparent" style="float: left; "><span id="delbut'+event.id+'" class="btn btn-default trash btn-xs">X</span></div>'; 
    el.prepend(layer); 
    el.find(".fc-bg").css("pointer-events","none"); 

		$("#delbut"+event.id).click(function(){ 
			$('#calendar').fullCalendar('removeEvents', event.id);
			$('#calendar').fullCalendar ('refetchEvents')
			$('#modalConfirmarAccion').modal();	
			$('#idConfirmacion2').val(event.id);
		}); 
	}, //fin mmouseover

	eventMouseout:function(event){ 
				$("#events-layer").remove(); 
	},
	eventClick: function(calEvent, jsEvent, view) {
		$('#fecha_inicioe').val(calEvent.start.format('DD-MM-YYYY'));
		$('#fecha_fine').val(calEvent.end.format('DD-MM-YYYY'));
		$('#habitacion_ide').val(calEvent.resourceId);
		$('#reservacion_id').val(calEvent.id);
		$('#nombrese').val(calEvent.title);
		$('#telefonose').val(calEvent.telefono);
		$('#estado_ide').val(calEvent.estado_id);
		$('#pago2').val(calEvent.pago);
		$('#id').val(calEvent.id);
		$('#modaleditReservacion').modal();
	},
	eventDrop: function(event, delta, revertFunc) {
		ModificarEvento(event,revertFunc);
		
	},//fin eventDrop
	
	eventResize: function(event, delta, revertFunc) {
		ModificarEvento(event,revertFunc);
    

	}//fin resize
	
});//fin fullcalendar
}	//fin funcion




function cargarHabitaciones(s_tipo_id){
		var id = s_tipo_id;
	$.ajax({
		type: "GET",
		url: APP_URL+'/habitaciones/cargar', 
		data: {"id" : id},
		dataType: "json",
		success: function(data){
			$('#calendar').fullCalendar('destroy');
			Calendario(data);	 
	},	  
		});
	}

	$("#tipo_habitacion_id").change(function () {
		var id=$("#tipo_habitacion_id").val();
		cargarHabitaciones(id);
});
cargarHabitaciones(0);
function BorrarFormularioReservacion() {
	$("#ReservacionForm :input").each(function () {
			$(this).val('');
		});
		$('#nombres').val('');

};

//funcion para guardar la reserva
function saveModal(button) {
	
	var formData = $("#ReservacionForm").serialize();
	var id=$('#habitacion_id').val();
	formData["habitacion_id"]=id;
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReservacion').val()},
		url: APP_URL+"/reservaciones/create",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioReservacion();
			$('#modalReservacion').modal("hide");
			alertify.set('notifier','position', 'top-center');
			alertify.success('Reservación Creada con Éxito!!');
			$('#calendar').fullCalendar ('refetchEvents')
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#ReservacionForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}
$("#ButtonReservacionModal").click(function(event) {
	$('.loader').addClass('is-active');
	event.preventDefault();
	if ($('#ReservacionForm').valid()) {
		saveModal();
	} else {
		$('.loader').removeClass('is-active');
		validator.focusInvalid();
	}
	
});

$("#btnConfirmarAccion").click(function(e) {
	$('.loader').addClass('is-active');
	e.preventDefault();
	if ($('#ConfirmarAccionForm').valid()) {
		confirmarAccion();
	} else {
		$('.loader').removeClass('is-active');
		validator.focusInvalid();
	}
});
	function confirmarAccion(button) {
	
		var formData = $("#ConfirmarAccionForm").serialize();
		var id = $("#idConfirmacion2").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: APP_URL+"/reservacion/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioConfirmar();
			$('#modalConfirmarAccion').modal("hide");
			$('#calendar').fullCalendar('removeEvents',id);
			alertify.set('notifier','position', 'top-center');
			alertify.success('La Reservación se Canceló Correctamente!!');
		},
		error: function(errors) {
			$('.loader').removeClass('is-active');
						if(errors.responseText !=""){
								var errors = JSON.parse(errors.responseText);
								if (errors.password_actual != null) {
										$("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>"+errors.password_actual+"</label>");
								}
								else{
										$("#ErrorPassword_actual").remove();
								}
						}
						
		}
	
});
}

$('#modalReservacion').on('hide.bs.modal', function(){
	window.location.hash = '#';
	$("label.error").remove();
	BorrarFormularioReservacion();
});

function ModificarEvento(event,revertFunc){
	alertify.confirm('¿Desea Modificar esta Reservación?',
	function(){
		$('.loader').addClass('is-active');
		var formData =  new Object();
		var id=event.id;
		formData["fecha_inicio"]=event.start.format('DD-MM-YYYY');
		formData["fecha_fin"]=event.end.format('DD-MM-YYYY');
		formData["habitacion_id"]=event.resourceId;
		$.ajax({
			type: "PUT",
			headers: {'X-CSRF-TOKEN': $('#tokeneditReservacion').val()},
			url: APP_URL+"/reservaciones/"+id+"/update",
			data: formData,
			dataType: "json",
			success: function(data) {
			$('.loader').removeClass('is-active');
				BorrarFormularioedit();
				$('#modaleditReservacion').modal("hide");
				alertify.set('notifier','position', 'top-center');
				alertify.success('La reservación se modifico Correctamente!!');
				$('#calendar').fullCalendar ('refetchEvents')
			},
			}); 
	 }, function(){
		revertFunc();
	});

}

$('#fecha_inicio').datepicker({
	autoclose: true,
	dateFormat: 'dd-mm-yy'
});
	
$('#fecha_fin').datepicker({
		autoclose: true,
		dateFormat: 'dd-mm-yy'
})