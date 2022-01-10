<!-- Modal -->
<style>
 .asdf:{
   background-color: aqua;
  
 }
</style>
<div class="modal fade" id="modalReservacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'ReservacionForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: blue; color:white ">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Reservación</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-sm-6">
                  {!! Form::label("nombres","Nombres:") !!}
                  <input type="text" name="nombres" id="nombres" placeholder="Ingrese Nombre" class="form-control">
                </div>
                <div class="col-sm-6">
                  {!! Form::label("telefono","Teléfonos:") !!}
                  <input type="number" name="telefono" id="telefonos" placeholder="Ingrese número Teléfono" class="form-control">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                    <label for="fecha_inicio">Fecha de Ingreso</label>
                    <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control">
              </div>
              <div class="col-sm-6">
                  <label for="fecha_fin"> Fecha de Salida</label>
                  <input type="text" name="fecha_fin" id="fecha_fin" class="form-control">
              </div>
            </div>
              <br>
            
              <input type="hidden" name='habitacion_id' id="habitacion_id">
              <input type="hidden" name="_token" id="tokenReservacion" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer" style="background-color: blue; color:white ">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonReservacionModal" >Agregar</button>
          </div>
        </div>
      </div>
    {!! Form::close() !!}
</div>