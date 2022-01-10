
$('.loader').removeClass('is-active');

var cajas_table = $('#checkin-table').DataTable({
    "ajax": APP_URL+"/check-in/getJson",
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
        "title": "Habitación",
        "data": "habitacion.nombre_habitacion",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Fecha de Ingreso",
        "data": "fecha_inicio",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    {
        "title": "Usuario que lo creó",
        "data": "user.name",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
          
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {

            var rol_user = $("input[name='rol_user']").val();
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-3'>" + 
                "<a href='#' class='edit-caja' data-toggle='modal' data-target='#modalUpdateCaja' data-id='"+full.id+"' data-nombre='"+full.nombre+"' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Caja'></i>" + 
                "</a>" + "</div>"        
        },
        "responsivePriority": 2
    }]

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
//Desactivar Caja
$(document).on('click', 'a.remove-caja', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    
    alertify.confirm('Desactivar Caja', 'Esta seguro de desactivar el caja', 
        function(){
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                cajas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Caja Desactivado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancel')
        });   
});
