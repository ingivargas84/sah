
$('.loader').removeClass('is-active');

var empleados_table = $('#empleados-table').DataTable({
    "ajax": APP_URL+"/empleados/getJson",
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
        "title": "CUI.",
        "data": "emp_cui",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Nombres",
        "data": "nombres",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Apellidos",
        "data": "apellidos",
        "width" : "15%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Puesto",
        "data": "puesto.nombre",
        "width" : "10%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Celular",
        "data": "celular",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
          
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "15%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();
            if(rol_user == 'super-admin' || rol_user == 'Administrador'){
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-4'>" + 
                "<a href='"+urlActual+"/"+full.id+"/edit' class='edit-empleado' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Empleado'></i>" + 
                "</a>" + "</div>" + 
                "<div class='float-right col-lg-4'>" + 
                "<a href='"+urlActual+"/"+full.id+"' class='remove-empleado'"+ "data-method='delete'"+ ">" + 
                "<i class='fa fa-thumbs-down' title='Desactivar Empleado'></i>" + 
                "</a>" + "</div>"+
                "<div class='float-right col-lg-4'>" + 
                "<a href='#' class='asignar-user' data-toggle='modal' data-target='#modalAsignaUser' data-id='"+full.id+"' data-user_id='"+full.user_id+"'>" + 
                "<i class='fa fa-user-tag' title='Asignar Usuario'></i>" + 
                "</a>" + "</div>";
            }
            else{
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-12'>" + 
                "<a href='"+urlActual+"/"+full.id+"/edit' class='edit-empleado' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Empleado'></i>" + 
                "</a>" + "</div>";    
            }
             
            
        },
        "responsivePriority": 2
    }]

});

//Desactivar Empleado
$(document).on('click', 'a.remove-empleado', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    
    alertify.confirm('Desactivar Empleado', 'Esta seguro de desactivar el empleado', 
        function(){
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                empleados_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Empleado Desactivado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancel')
        });   
});
