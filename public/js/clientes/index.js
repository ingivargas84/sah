
$('.loader').removeClass('is-active');

var clientes_table = $('#clientes-table').DataTable({
    "ajax": APP_URL+"/clientes/getJson",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [ {
        "title": "No.",
        "data": "id",
        "width" : "3%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "NIT",
        "data": "nit",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    {
        "title": "Nombres ",
        "data": "nombres",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    { 
        "title": "Telefonos",
        "data": "telefonos",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
        return (data);
    }},
    {
        "title": "Correo",
        "data": "correo",
        "width" : "15%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    {
        "title": "Estado",
        "data": "estado",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
    {
        "title": "Fecha Creación",
        "data": "fecha",
        "width" : "15%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    },  
    {
        "title": "Acciones",
        "orderable": false,
        "data": "estado_id",
        "width" : "10%",
        "render": function(data, type, full, meta) {
        var rol_user = $("input[name='rol_user']").val();
        var urlActual = $("input[name='urlActual']").val();
        if(data==1){
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-6'>" + 
            "<a href='"+urlActual+"/edit/"+ full.id +"' class='edit-cliente'>" + 
            "<i class='fa fa-btn fa-edit' title='Editar Tipo Cliente'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-6'>" + 
            "<a href='#' class='remove-cliente'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
            "<i class='fa fa-thumbs-down' title='Desactivar Cliente'></i>" + 
            "</a>" + "</div>";  
        }
        else { 
            if(rol_user == 'super-admin' || rol_user == 'Administrador'){ 
                return "<div class='float-right col-lg-6'>" + 
                "<a href='"+urlActual+"/"+full.id+"/active' class='active-cliente'"+ "data-method='post'>" + 
                "<i class='fa fa-thumbs-up' title='activar Cliente'></i>" + 
                "</a>" + "</div>";
            } else{
            return "<div class='text-center col-lg-12'>" + 
            "<i class='fab fa-expeditedssl' title='Cliente Desactivado'></i>" + "</div>"
        } 
        }
        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 7) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});

//Confirmar Contraseña para borrar
$("#btnConfirmarAccion").click(function(event) {
    event.preventDefault();
	if ($('#ConfirmarAccionForm').valid()) {
		
		confirmarAccion();
	} else {
		validator.focusInvalid();
	}
});

$('body').on('click', 'a.active-cliente', function(e) {
    e.preventDefault(); 
    var $this = $(this); 
    alertify.confirm('¿Desea Reactivar este Cliente?',
    function(){
        $.post({
            type: $this.data('method'),
            url: $this.attr('href')
        }).done(function (data) {
            clientes_table.ajax.reload();
            alertify.set('notifier','position', 'top-center');
            alertify.success('El Cliente se activó Correctamente!!');
        }); 
     }, function(){
        alertify.set('notifier','position', 'top-center'); 
        alertify.error('Cancelar')
    }); 
   
});


function confirmarAccion(button) {
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: urlActual+"/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').removeClass('is-active');
            BorrarFormularioConfirmar();
			$('#modalConfirmarAccion').modal("hide");
			clientes_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('El Cliente se Desactivó Correctamente!!');
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