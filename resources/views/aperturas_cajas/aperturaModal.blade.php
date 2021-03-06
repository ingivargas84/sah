<!-- Modal -->
<div class="modal fade" id="modalApertura" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'AperturaForm' ) ) !!}

      <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Apertura de Caja</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="monto">Monto</label>
                  <input type="number" name="monto" placeholder="Ingrese Monto de Apertura" class="form-control" value="{{old('monto')}}">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-12">
                  <select class="form-control" name="user_cajero_id" id="user_cajero_id">
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="descripcion_apertura">Descripción</label>
                  <input type="text" name="descripcion_apertura" placeholder="Ingrese  descripción" class="form-control" value="{{old('password_admin')}}">
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenApertura" value="{{ csrf_token() }}">
              <input type="hidden" name="caja_id">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonAperturaModal" >Aperturar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>