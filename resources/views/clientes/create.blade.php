@extends('layouts.app')

@section('content')
    <form method="POST" id="ClienteForm"  action="{{route('clientes.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="tittle-custom"> Creación de Clientes </h3>
                        <line>
                    </div>
                </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::label("nit","NIT:") !!}
                            {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label("correo","e-mail:") !!}
                            {!! Form::text( "correo" , null , ['class' => 'form-control' , 'placeholder' => 'e-mail']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label("tipo_id","Tipo de Cliente:") !!}
                            <select class="form-control" id='tipo_id' name="tipo_id">
                                <option value="">Selecciona Tipo cliente</option>
                                @foreach ($tipos_clientes as $tipo_cliente)
                                <option value="{{$tipo_cliente->id}}">{{$tipo_cliente->tipo_cliente}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label("tipo_documento_id","Tipo de Documento de Identificación:") !!}
                            <select class="form-control" name="tipo_documento_id" id="tipo_documento_id">
                                <option value="">Selecciona Tipo de Documento de Identificación</option>
                                @foreach ($tipos_documentos as $tipo_documento)
                                <option value="{{$tipo_documento->id}}">{{$tipo_documento->tipo_documento}}</option>
                            
                                @endforeach
                              </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label("no_documento","No. Documento:") !!}
                            {!! Form::text( "no_documento" , null , ['class' => 'form-control' , 'placeholder' => 'No. Documento' ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label("nombres","Nombres:") !!}
                            {!! Form::text( "nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label("apellidos","Apellidos:") !!}
                            {!! Form::text( "apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label("nacimiento","Fecha de Nacimiento:") !!}
                            {!! Form::date( "nacimiento" , null , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label("celular","Celular:") !!}
                            {!! Form::text( "celular" , null , ['class' => 'form-control' , 'placeholder' => 'Celular' ]) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::label("telefono","Teléfono:") !!}
                            {!! Form::text( "telefono" , null , ['class' => 'form-control' , 'placeholder' => 'Teléfon' ]) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::label("direccion","Dirección:") !!}
                            {!! Form::text( "direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
                        </div>
                    
                    </div>    
                    <br>
                
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                            <button class="btn btn-success form-button">Guardar</button>
                        </div>
                               
            </div>
    </form>

@stop

@push('scripts')
<script>
    $.validator.addMethod("cuiUnico", function(value, element) {
        var dd= ($("#tipo_documento_id").find("option:selected").text()).toUpperCase();
        if(dd=='DPI' ||dd=='CUI' ||dd=='DPI/CUI' || dd=='DPI-CUI' || dd=='CUI/DPI'){
            var valid = false;
            $.ajax({
                type: "GET",
                async: false,
                url: "{{route('clientes.dpiDisponible')}}",
                data: "no_documento=" + value,
                dataType: "json",
                success: function(msg) {
                    valid = !msg;
                }
            });
            return valid;
        }
        else{
            return true;
        }
    }, "El DPI ya está asignado a otro cliente registrado en el sistema");

    $.validator.addMethod("nitUnico", function(value, element) {
        var n=value.toUpperCase();
        if(n=='CF'|| n=='C/F'){
            return true;
        }else{
            var valid = false;
            $.ajax({
                type: "GET",
                async: false,
                url: "{{route('clientes.nitDisponible')}}",
                data: "nit=" + value,
                dataType: "json",
                success: function(msg) {
                    valid = !msg;
                }
            });
            return valid;
        }
    }, "El nit ya está registrado en el sistema");

    function saveContact(button) {
        $("#ButtonCliente").attr('disabled', 'disabled');
        var l = Ladda.create(document.querySelector("#ButtonCliente"));
        l.start();
        var formData = $("#ClienteForm").serialize();
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('#tokenHabitacion').val()},
            url: "{{route('clientes.save')}}",
            data: formData,
            dataType: "json",
            success: function(data) {
			$('.loader').removeClass('is-active');
                alertify.set('notifier','position', 'top-center');
                alertify.success('Cliente con Éxito!!');
                
            },
            error: function(errors) {
			$('.loader').removeClass('is-active');
                alertify.error('ha ocurrido un error'); 
            }
            
        });
    }
</script>

<script src="{{asset('js/clientes/create.js')}}"></script>
@endpush