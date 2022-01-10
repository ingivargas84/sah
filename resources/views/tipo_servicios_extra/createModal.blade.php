<!-- Modal -->
<div class="modal fade" id="modaltipo_servicios_extra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'tipo_servicios_extraForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Tipo de Servicio Extra</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Tipo de Servicio Extra:</label>
                  <input type="text" name="nombre" placeholder="Ingrese tipo de Servicio Extra" class="form-control" >
                  {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokentipo_servicios_extra" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtontipohabitacionModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>