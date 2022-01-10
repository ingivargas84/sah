<!-- Modal -->
<div class="modal fade" id="modalUpdateServicioExtra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="ServicioExtraUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Nivel</h4>
                </div>
                <div class="modal-body">
                  
                  <div class="row">
                    <div class="col-sm-12">
                      {!! Form::label("nombre_servicio","Nombre de Servicio:") !!}
                      <input type="text" name="nombre_servicio" placeholder="Nombre Servicio" class="form-control" value="{{old('nombre_servicio')}}">
                    </div>
                  </div>
                  <br>
                    <div class="row">
                    <div class="col-sm-6">
                      {!! Form::label("tipo_id","Tipo de Servicio:") !!}
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
    
                  <input type="hidden" name="_token" id="tokenServicioExtraEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonServicioExtraModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
          </div>
      </form>
  </div>
@push('scripts')
  <script>
    function cargarSelectTipoServicioExtra(s_tipo_id){
		$('#tipo2_id').empty();
		$("#tipo2_id").append('<option value="" selected>Seleccione Tipo de Habitación</option>');
		var tipo_id = s_tipo_id;
		$.ajax({
			type: "GET",
			url: "{{route('tipos_servicio_extra.cargar')}}", 
			dataType: "json",
			success: function(data){
				$.each(data,function(key, registro) {
					if(registro.id == tipo_id){
					$("#tipo2_id").append('<option value='+registro.id+' selected>'+registro.nombre+'</option>');
					
					}else{
					$("#tipo2_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
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