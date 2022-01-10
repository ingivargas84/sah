<!-- Modal -->
<div class="modal fade" id="modalTipoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'TipoClienteForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Tipo de Cliente</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="tipo_cliente">Tipo de Cliente:</label>
                  <input type="text" name="tipo_cliente" placeholder="Ingrese Tipo de Cliente" class="form-control">

                </div>
                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="descuento">Porcentaje Descuento:</label>
                  <input type="number" name="descuento" placeholder="Ingrese Porcentaje de descuento" class="form-control">

                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenTipoCliente" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonTipoClienteModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>