<!-- Modal -->
<div class="modal fade" id="modalTipoDocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'TipoDocumentoForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Tipo de Documento</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="tipo_documento">Tipo de Documento:</label>
                  <input type="text" name="tipo_documento" placeholder="Ingrese Tipo de Documento" class="form-control">

                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenTipoDocumento" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonTipoDocumentoModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>