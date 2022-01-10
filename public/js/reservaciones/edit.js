$.validator.addMethod("fecha_inicio_disponibleedit", function(value, element) {
    var formData =  new Object();
            formData["fecha_inicio"]=$('#fecha_inicioe').val();
            formData["fecha_fin"]=$('#fecha_fine').val();
            formData["habitacion_id"]=$('#habitacion_ide').val();
            formData["id"]=$('#id').val();
    var valid = false;
    $.ajax({
            type: "GET",
            async: false,
            url: APP_URL+"/reservaciones/fecha_inicioedit",
            data: formData,
            dataType: "json",
            success: function(msg) {
                    valid = !msg;
            }
    });
    return valid;
    }, "La fecha seleccionada no está disponible.");
    
$.validator.addMethod("fecha_mayoredit", function(value, element) {
    var valid = false;
    var inicio=($('#fecha_inicioe').val()).split('-').reverse().join('/');;
    var fin=($('#fecha_fine').val()).split('-').reverse().join('/');;
    if( new Date(fin).getTime() > new Date(inicio).getTime())
    {
        valid=true;
    }
    return valid;
}, "La fecha de salida debe ser mayor a la fecha de entrada.");
        
$.validator.addMethod("fecha_fin_disponibleedit", function(value, element) {
    var formData =  new Object();
    formData["fecha_inicio"]=$('#fecha_inicioe').val();
    formData["fecha_fin"]=$('#fecha_fine').val();
    formData["habitacion_id"]=$('#habitacion_ide').val();
    formData["id"]=$('#id').val();
    var valid = false;
    $.ajax({
            type: "GET",
            async: false,
            url: APP_URL+"/reservaciones/fecha_finedit",
            data: formData,
            dataType: "json",
            success: function(msg) {
                    valid = !msg;
            }
    });
    return valid;
}, "La fecha seleccionada no está disponible.");

var validator = $("#editReservacionForm").validate({
    ignore: [],
    onkeyup:false,
    rules: {
    nombres:{
            required: true,
        },
        telefono:{
            required:true,
        },
        fecha_inicio:{
            required:true,
            fecha_inicio_disponibleedit:true,
        },
        fecha_fin:{
            required:true,
            fecha_fin_disponibleedit:true,
            fecha_mayoredit:true
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




$('#modaleditReservacion').on('shown.bs.modal', function(event){
    cargarSelectEstado();
    cargarSelectpago();
 }); 

function BorrarFormularioedit() {
    $("#ReservacioneditForm :input").each(function () {
        $(this).val('');
	});
};
function cargarSelectEstado(){
    
    $('#estado2_id').empty();
    var id=$('#estado_ide').val();
    $.ajax({
        type: "GET",
        url: APP_URL+'/reservacion/cargar', 
        dataType: "json",
        success: function(data){
            $.each(data,function(key, registro) {
                if(registro.id == id){
                $("#estado2_id").append('<option value='+registro.id+' selected>'+registro.estado+'</option>');
                
                }else{
                $("#estado2_id").append('<option value='+registro.id+'>'+registro.estado+'</option>');
                }		
            });
    
        },
        });

}

function cargarSelectpago(){
    $('#pago').empty();
    var id=$('#pago2').val();
    for (let index = 0; index < 101; index=index+50) {
        if(index == id){
        $("#pago").append('<option value='+index+' selected>'+index+'%</option>');
        
        }else{
        $("#pago").append('<option value='+index+'>'+index+'%</option>');
        }    
    }
    
}
$("#ButtoneditReservacionModal").click(function(event) {
    event.preventDefault();
    if ($('#editReservacionForm').valid()) {
		
    editModal();
	} else {
		validator.focusInvalid();
	}
    
    
});

function editModal(button) {
    $('.loader').addClass('is-active');
	var formData = $("#editReservacionForm").serialize();
    var id=$('#id').val();
    var hid=$('#habitacion_id').val();
    formData["habitacion_id"]=hid;
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokeneditReservacion').val()},
		url: APP_URL+"/reservaciones/"+id+"/edit",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
			BorrarFormularioedit();
			$('#modaleditReservacion').modal("hide");
			alertify.set('notifier','position', 'top-center');
            alertify.success('Reservación Editada con Éxito!!');
            $('#calendar').fullCalendar ('refetchEvents')
		},		
    });
    
}

$('#fecha_inicioe').datepicker({
	autoclose: true,
	dateFormat: 'dd-mm-yy'
});
	
$('#fecha_fine').datepicker({
    autoclose: true,
    dateFormat: 'dd-mm-yy'
}) 