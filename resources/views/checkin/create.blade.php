@extends('layouts.app')

@section('content')

<h3 class="box-title">Procesar Habitación</h3>
<div class="loader loader-double is-active"></div>
<div style="background-color: white; border: 1px solid green; padding: 25px; margin: 25px;">
    <h4> <center> <b> Datos de Habitación </b></center></h4>
    <div class="row">
        <div class="col-sm-8">
            <label for="Nombre">Nombre: &nbsp; &nbsp; &nbsp; &nbsp; </label> <label>{{$habitaciones[0]->nombreh}}</label>
            <br>
            <label for="Nombre">Detalles: &nbsp; &nbsp; &nbsp; &nbsp; </label> <label>{{$habitaciones[0]->descripcion}}</label>
        </div>
        <div class="col-sm-4">
                <label for="Nombre">Tipo: &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; </label> <label>{{$habitaciones[0]->tipo}}</label>
                <br>
                <label for="Nombre">Estado: &nbsp; &nbsp; &nbsp; </label> <button disabled="disabled" class="btn btn-success" value=""> {{$habitaciones[0]->estadoh}}</button>
        </div>
</div>
</div>
{!! Form::open( array( 'id' => 'CheckinForm' ) ) !!}
    @if (empty($reservacion))
    @else
        <h4 style="color:red"> <center>Habitación Con Reservación Para El Día De Hoy</center>   </h4>
        <h4>Datos de la Reservación: </h4>
        <div class="row">
        <div class="col-sm-4">
            <label for="nombre:">Nombres: </label>
            <input type="text" value="{{$reservacion[0]->nombres}}" disabled>
        </div>

        <div class="col-sm-4">
            <label for="nombre:">Telefono: </label>
            <input type="text" value="{{$reservacion[0]->telefono}}" disabled>
        </div>

        <div class="col-sm-4">
            <label for="nombre:">Adelanto: </label>
            <input type="text" id="ad" value="{{$reservacion[0]->pago}} %" disabled>
        </div>

        <hr>
        </div>
        <input type="hidden" name="reservacion_id" id="reservacion_id" value="{{$reservacion[0]->id}}">
        <input type="hidden" name="dias" id="dias" value="{{$reservacion[0]->dias}}">

    @endif
    
   <input type="hidden" name="habitacion_id" id="habitacion_id" value="{{$habitaciones[0]->id}}">
   <input type="hidden" name="precioh" id="precioh" value="{{$habitaciones[0]->precio}}">
    {{csrf_field()}}
    <div class="col-md-12">
      <div class="row">
        <div class="col-sm-6">
            <br>
            <h4><center> Datos del Cliente</center></h4>
            <hr>
            <div class="col-sm-12">
                    {!! Form::label("tipo_documento_id","Tipo de Documento de Identificación:") !!}
                    <select class="form-control" name="tipo_documento_id" id="tipo_documento_id">
                        <option value="" disabled selected>Selecciona Tipo de Documento de Identificación</option>
                        @foreach ($documentos as $tipo_documento)
                        <option value="{{$tipo_documento->id}}">{{$tipo_documento->tipo_documento}}</option>
                        @endforeach
                      </select>
                <br>
            </div>
            <div class="col-sm-12">
                <label for="nombres">Documento:</label>
                <select  class="form-control" id='documento_id' name="documento_id" value="" data-live-search-placeholder="Búsqueda">
                </select>
                <br>
            </div>
            
          <div class="col-sm-12">
              <label for="nombres">Nombres:</label>
              <input type="text" class="form-control" placeholder="Nombres:" name="nombres" id="nombres" disabled>
              <br>
            </div>
          
          <div class="col-sm-12">
              <label for="apellidos">Dirección:</label>
              <input type="text" class="form-control" placeholder="Dirección:" name="direccion" id="direccion" disabled>
          </div>
        </div><!-- end clientes-->
        <div class="col-sm-6">
            <br>
            <h4><center> Datos del Alojamiento</center></h4>
            <hr>
            <div class="col-sm-12">
                <label for="tarifa">Tarifa:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-globe-europe"></i></span>
                        <input type="number" class="form-control" placeholder="Tarifa:" name="tarifa" id="tarifa">
                        <span class="input-group-addon">Dias</span>
                    </div>
                </select>
                <br>
            </div>
            
            <div class="col-sm-12">
                <label for="nombres">Precio:</label>
                <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-money-bill-alt"></i></span>
                        <input type="text" class="form-control" disabled placeholder="Precio:" name="precio" id="precio">
                        <span class="input-group-addon">Adelanto</span>
                        <input type="text" class="form-control" placeholder="Adelanto:" name="adelanto" id="adelanto">
                    </div>
                <br>
            </div>
            
            <div class="col-sm-12">
                <label for="fecha">Fecha:</label>
                <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></i></span>
                <input type="text" class="form-control" disabled placeholder="Fecha:" name="fecha" id="fecha" value="{{$fecha}}">
                </div>

            </div>

        </div>


      </div>
      <br>
      <input type="hidden" name="_token" id="tokenChek" value="{{ csrf_token() }}">
      <div class="text-right m-t-15">
          <a class='btn btn-primary form-button' href="/home">Regresar</a>
          <button type="submit" class="btn btn-primary" id="Buttoncheck" >Guardar</button>
      </div>
              
  </div>
  {!! Form::close() !!}

@stop
@push('scripts')
<script src="{{asset('js/checkin/create.js')}}"></script>
@endpush