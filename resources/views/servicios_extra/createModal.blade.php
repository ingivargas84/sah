<!-- Modal -->
<div class="modal fade" id="modalServicioExtra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'ServicioExtraForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Servicio Extra</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-sm-12">
                  {!! Form::label("nombre_servicio","Nombre de Servicio:") !!}
                  <input type="text" name="nombre_servicio" id="nombre_servicio" placeholder="Ingrese Nombre de Servicio" class="form-control" value="{{old('nombre_servicio')}}">
                </div>
              </div>
              <br>
                <div class="row">
                <div class="col-sm-6">
                  {!! Form::label("tipo_id","Tipo de Servicio:") !!}
                  <select class="form-control" name="tipo_id" id="tipo_id">
                    <option value="">Selecciona tipo Servicio</option>
                      @foreach ($tipos as $tipo)
                      <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-sm-6">
                  {!! Form::label("precio","Precio:") !!}
                  {!! Form::number( "precio" , null , ['class' => 'form-control' , 'placeholder' => 'Precio']) !!}
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-12">
                  {!! Form::label("descripcion","Descripción:") !!}
                  {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'placeholder' => 'Ingrese la descripción']) !!}
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenServicioExtra" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonServicioExtraModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>