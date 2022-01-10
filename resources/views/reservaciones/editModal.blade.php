<!-- Modal -->
<div class="modal fade" id="modaleditReservacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="editReservacionForm">
        {{ method_field('put') }}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: red; color:white ">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Actualizar Reservación</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-sm-6">
                  {!! Form::label("nombres","Nombres:") !!}
                  <input type="text" name="nombres" id="nombrese" placeholder="Ingrese Nombre" class="form-control">
                </div>
                <div class="col-sm-6">
                  {!! Form::label("telefono","Teléfonos:") !!}
                  <input type="text" name="telefono" id="telefonose" placeholder="Ingrese número Teléfono" class="form-control">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                    <label for="fecha_inicio">Fecha de Ingreso</label>
                    <input type="text" name="fecha_inicio" id="fecha_inicioe" class="form-control">
              </div>
              <div class="col-sm-6">
                  <label for="fecha_fin"> Fecha de Salida</label>
                  <input type="text" name="fecha_fin" id="fecha_fine" class="form-control">
              </div>
            </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                  {!! Form::label("estado_id","Estado:") !!}
                  <select class="form-control select" name="estado_id" id="estado2_id">
                    </select>
                </div>
                <div class="col-sm-6">
                    {!! Form::label("pago","Pagado:") !!}
                    <select class="form-control select" name="pago" id="pago">
                      </select>
                  </div>
                </div>
              </div>
            
              <input type="hidden" name='habitacion_id' id="habitacion_ide">
              <input type="hidden" id="estado_ide">
              <input type="hidden" id="pago2">
              <input type="hidden" id="id">
              <input type="hidden" name="_token" id="tokeneditReservacion" value="{{ csrf_token() }}">
              <div class="modal-footer" style="background-color: red; color:white">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtoneditReservacionModal" >Actualizar</button>

            </div>
        </div>
      </div>
    </form>
</div>