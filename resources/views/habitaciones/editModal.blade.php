<!-- Modal -->
<div class="modal fade" id="modalUpdateHabitacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="HabitacionUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Nivel</h4>
                </div>
                <div class="modal-body">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      {!! Form::label("nombre_habitacion","Nombre de Habitación:") !!}
                      <input type="text" name="nombre_habitacion" placeholder="Nombre Habitación" class="form-control" value="{{old('nombre_habitacion')}}">
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label("nivel_id","Nivel:") !!}
                      <select class="form-control select" name="nivel_id" id="nivel2_id">
                      </select>
                    </div>
                  </div>
                  <br>
                    <div class="row">
                    <div class="col-sm-6">
                      {!! Form::label("tipo_id","Tipo de Habitación:") !!}
                      <select class="form-control" name="tipo_id" id="tipo2_id">
                      </select>
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label("precio","Precio:") !!}
                      <input type="text" name="precio" placeholder="Precio" class="form-control" value="{{old('precio')}}">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-12">
                      <label for="descripcion">Descripción:</label>
                      <input type="text" name="descripcion" placeholder="Ingrese Descripción" class="form-control" value="{{old('descripcion')}}">
                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenHabitacionEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonHabitacionModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
          </div>
      </form>
  </div>

  @push('scripts')
    <script>
      $.validator.addMethod("nombreUnico", function(value, element) {
        var valid = false;
        var id = $("input[name='id']").val();
        $.ajax({
          type: "GET",
          async: false,
          url: "{{route('habitaciones.nombreDisponibleEdit')}}",
          data: {"nombre_habitacion" : value, "id" : id},
          dataType: "json",
          success: function(msg) {
            valid = !msg;
          }
        });
        return valid;
      }, "El nombre de Habitación ya está registrado en el sistema");


      function cargarSelectTipoHabitacion(s_tipo_id){
      $('#tipo2_id').empty();
      $("#tipo2_id").append('<option value="" selected>Seleccione Tipo de Habitación</option>');
      var tipo_id = s_tipo_id;
      $.ajax({
        type: "GET",
        url: "{{route('tipos_habitacion.cargar')}}", 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            if(registro.id == tipo_id){
            $("#tipo2_id").append('<option value='+registro.id+' selected>'+registro.tipo_habitacion+'</option>');
            
            }else{
            $("#tipo2_id").append('<option value='+registro.id+'>'+registro.tipo_habitacion+'</option>');
            }	
            
          });
      
        },
        error: function(data) {
          alert('error');
        }
        });
      }


      function cargarSelectNiveles(s_nivel_id){
			$('#nivel2_id').empty();
			$("#nivel2_id").append('<option value="" selected>Seleccione Nivel</option>');
			var nivel_id = s_nivel_id;
			$.ajax({
				type: "GET",
				url: "{{route('niveles.cargar')}}", 
				dataType: "json",
				success: function(data){
					$.each(data,function(key, registro) {
						if(registro.id == nivel_id){
						$("#nivel2_id").append('<option value='+registro.id+' selected>'+registro.nivel_nombre+'</option>');
						
						}else{
						$("#nivel2_id").append('<option value='+registro.id+'>'+registro.nivel_nombre+'</option>');
						}		
					});
			
				},
				error: function(data) {
					alert('error');
				}
				});
			}
    </script>    
  @endpush