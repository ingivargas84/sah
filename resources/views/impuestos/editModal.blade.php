<!-- Modal -->
<div class="modal fade" id="modalUpdateTipoImpuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="TipoImpuestoUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Tipo de Impuesto</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre_impuesto">Tipo de Impuesto:</label>
                      <input type="text" name="nombre_impuesto" placeholder="Ingrese Tipo de Impuesto" class="form-control">
    
                    </div>
                    <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="porcentaje">Porcentaje:</label>
                      <input type="number" name="porcentaje" placeholder="Ingrese Porcentaje de impuesto" class="form-control" id="porcentajee">
    
                    </div>
                  </div>
                  <br>
                  <input type="hidden" name="_token" id="tokenTipoImpuesto" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonTipoImpuestoModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
          </div>