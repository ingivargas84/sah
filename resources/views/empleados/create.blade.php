@extends('layouts.app')

@section('content')
<div class="loader loader-double is-active"></div>
    <form method="POST" id="EmpleadoForm"  action="{{route('empleados.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="emp_cui">CUI/DPI</label>
                                <input type="text" class="form-control" placeholder="CUI/DPI" name="emp_cui">
                            </div>
                            <div class="col-sm-4">
                                <label for="nit">Nit:</label>
                                <input type="text" class="form-control" placeholder="Nit:" name="nit" >
                            </div>
                            <div class="col-sm-4">
                                <label>Puesto</label>
                                <select class="form-control" name="puesto_id" id="facultadid">
                                    <option value="">Selecciona Puesto</option>
                                        @foreach($puestos as $puesto)
                                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres:" name="nombres" >
                            </div>
                            <div class="col-sm-6">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos:" name="apellidos" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono:" name="telefono" >
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Celular:</label>
                                <input type="text" class="form-control" placeholder="Celular:" name="celular" >
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Email:</label>
                                <input type="text" class="form-control" placeholder="Email:" name="email" >
                            </div>                                
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección:" name="direccion" >
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
    
                                    <input name="fecha_nacimiento" type="text" class="form-control pull-right" id="datepickerN">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Fecha de Alta:</label>
                        
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_alta" type="text" class="form-control pull-right" id="datepickerA">
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <label>Fecha de Baja:</label>
                        
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_baja" type="text" class="form-control pull-right" id="datepickerB">
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
    <script>
        $.validator.addMethod("cuiUnico", function(value, element) {
            var valid = false;
            $.ajax({
                type: "GET",
                async: false,
                url: "{{route('empleados.dpiDisponible')}}",
                data: "emp_cui=" + value,
                dataType: "json",
                success: function(msg) {
                    valid = !msg;
                }
            });
            return valid;
        }, "El DPI ya está asignado a otro empleado registrado en el sistema");

        $.validator.addMethod("nitUnico", function(value, element) {
            var valid = false;
            $.ajax({
                type: "GET",
                async: false,
                url: "{{route('empleados.nitDisponible')}}",
                data: "nit=" + value,
                dataType: "json",
                success: function(msg) {
                    valid = !msg;
                }
            });
            return valid;
        }, "El nit ya está registrado en el sistema");
    </script>

<script src="{{asset('js/empleados/create.js')}}"></script>
@endpush