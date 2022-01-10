@extends('layouts.app')

@section('content')
<div class="loader loader-double is-active"></div>
    <form method="POST" id="EmpleadoUpdateForm"  action="{{route('empleados.update', $empleado)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
            
                <div class="row">
                    <div class="col-sm-4 {{$errors->has('emp_cui')? 'has-error' : ''}}">
                        <label for="emp_cui">CUI/DPI</label>
                        <input type="text" class="form-control" placeholder="CUI/DPI" name="emp_cui" value="{{old('emp_cui', $empleado->emp_cui)}}">
                        {!!$errors->first('emp_cui', '<label class="error">:message</label>')!!}
                    </div>
                    <div class="col-sm-4 {{$errors->has('nit')? 'has-error' : ''}}">
                        <label for="nit">Nit:</label>
                        <input type="text" class="form-control" placeholder="Nit:" name="nit" value="{{old('nit', $empleado->nit)}}" >
                        {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                    </div>
                    <div class="col-sm-4">
                        <label>Puesto</label>
                        <select class="form-control" name="puesto_id" id="facultadid">
                            <option value="">Selecciona Puesto</option>
                                @foreach($puestos as $puesto)
                                    @if($puesto->id == $empleado->puesto_id)
                                        <option value="{{$puesto->id}}" selected>{{ $puesto->nombre}}</option>
                                    @else
                                        <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                    @endif
                                @endforeach
                        </select>
                    </div>
                </div>
                <br>                
                <div class="row">
                    <div class="col-sm-6">
                        <label for="nombres">Nombres:</label>
                        <input type="text" class="form-control" placeholder="Nombres:" name="nombres" value="{{old('nombres', $empleado->nombres)}}">
                    </div>
                    <div class="col-sm-6">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" placeholder="Apellidos:" name="apellidos" value="{{old('apellidos', $empleado->apellidos)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="telefono">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Telefono:" name="telefono" value="{{old('telefono', $empleado->telefono)}}" >
                    </div>
                    <div class="col-sm-4">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" placeholder="Celular:" name="celular" value="{{old('celular', $empleado->celular)}}">
                    </div>
                    <div class="col-sm-4">
                        <label for="celular">Email:</label>
                        <input type="text" class="form-control" placeholder="Email:" name="email" value="{{old('email', $empleado->email)}}">
                    </div>                                
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-12">
                        <label for="direccion">Direccion:</label>
                        <input type="text" class="form-control" placeholder="Direccion:" name="direccion" value="{{old('direccion', $empleado->direccion)}}">
                    </div>                                
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label>Fecha de Nacimiento:</label>
                
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <input name="fecha_nacimiento" type="text" class="form-control pull-right" id="datepickerN" value="{{old('fecha_nacimiento', $empleado->fecha_nacimiento ? $empleado->fecha_nacimiento->format('d-m-Y') : null) }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Fecha de Alta:</label>
                
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <input name="fecha_alta" type="text" class="form-control pull-right" id="datepickerA" value="{{old('fecha_alta', $empleado->fecha_alta ? $empleado->fecha_alta->format('d-m-Y') : null) }}">
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <label>Fecha de Baja:</label>
                
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <input name="fecha_baja" type="text" class="form-control pull-right" id="datepickerB" value="{{old('fecha_baja', $empleado->fecha_baja ? $empleado->fecha_baja->format('d-m-Y') : null) }}">
                        </div>
                    </div>
                </div>

                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('empleados.index') }}">Regresar</a>
                    <button class="btn btn-success form-button">Guardar</button>
                </div>
            </div>
    </form>

@stop

@push('scripts')

<script src="{{asset('js/empleados/edit.js')}}"></script>
@endpush