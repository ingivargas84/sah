@extends('layouts.app')

@section('content')
    <form method="POST" id="ClienteUpdateForm"  action="{{route('clientes.update', $cliente)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
            <input type="hidden" name="id" value="{{$cliente->id}}">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="tittle-custom"> Edición de Clientes </h3>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3 form-group {{$errors->has('nit')? 'has-error' : ''}}">
                        {!! Form::label("nit","NIT:") !!}
                        {!! Form::text( "nit" , $cliente->nit , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
                        {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::label("correo","Correo Electrónico:") !!}
                        {!! Form::text( "correo" , $cliente->correo , ['class' => 'form-control' , 'placeholder' => 'Correo Electrónico' ]) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::label("tipo_id","Tipo de Cliente:") !!}
                        <select class="form-control" id='tipo_id' name="tipo_id">
                            @foreach ($tipos_clientes as $tipo_cliente)
                            @if ( $tipo_cliente->id == $cliente->tipo_id)
                            <option value="{{$tipo_cliente->id}}" selected>{{ $tipo_cliente->tipo_cliente}}</option>
                            @else
                            <option value="{{$tipo_cliente->id}}">{{ $tipo_cliente->tipo_cliente}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        {!! Form::label("tipo_documento_id","Tipo de Documento de Identificación:") !!}
                        <select class="form-control" id='tipo_documento_id' name="tipo_documento_id" >
                            @foreach ($tipos_documentos as $tipo_documento)
                            @if ( $tipo_documento->id == $cliente->tipo_documento_id)
                            <option value="{{$tipo_documento->id}}" selected>{{ $tipo_documento->tipo_documento}}</option>
                            @else
                            <option value="{{$tipo_documento->id}}">{{ $tipo_documento->tipo_documento}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4 form-group {{$errors->has('no_documento')? 'has-error' : ''}}">
                        {!! Form::label("no_documento","No. documento:") !!}
                        {!! Form::text( "no_documento" , $cliente->no_documento , ['class' => 'form-control' , 'placeholder' => 'No. documento' ]) !!}
                        {!!$errors->first('no_documento', '<label class="error">:message</label>')!!}
                    </div>
                    <div class="col-sm-4">
                        {!! Form::label("nombres","Nombres:") !!}
                        {!! Form::text( "nombres" , $cliente->nombres , ['class' => 'form-control' , 'placeholder' => 'Nombres' ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! Form::label("apellidos","Apellidos:") !!}
                        {!! Form::text( "apellidos" , $cliente->apellidos , ['class' => 'form-control' , 'placeholder' => 'Apellidos' ]) !!}
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

                            <input name="nacimiento" type="text" class="form-control pull-right" id="datepickerN" value="{{old('nacimiento', $cliente->nacimiento )}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::label("celular","Celular:") !!}
                        {!! Form::text( "celular" , $cliente->celular , ['class' => 'form-control' , 'placeholder' => 'Celular' ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! Form::label("telefono","Teléfono:") !!}
                        {!! Form::text( "telefono" , $cliente->telefono , ['class' => 'form-control' , 'placeholder' => 'Teléfono' ]) !!}
                    </div>
                </div>
                <div class="row">
                <br>
                    <div class="col-sm-12">
                        {!! Form::label("direccion","Dirección:") !!}
                        {!! Form::text( "direccion" , $cliente->direccion , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
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
    $.validator.addMethod("nitUnico", function(value, element) {
        var n=value.toUpperCase();
        var id = $("input[name='id']").val();
        if(n=='CF'|| n=='C/F'){
            return true;
        }else{
            var valid = false;
            $.ajax({
                type: "GET",
                async: false,
                url: "{{route('clientes.nitDisponibleEdit')}}",
                data: {"nit": value, "id" : id},
                dataType: "json",
                success: function(msg) {
                    valid = !msg;
                }
            });
            return valid;
        }
    }, "El nit ya está registrado en el sistema");

    $.validator.addMethod("cuiUnico", function(value, element) {
        var dd= ($("#tipo_documento_id").find("option:selected").text()).toUpperCase();
        var id = $("input[name='id']").val();
        if(dd=='DPI' ||dd=='CUI' ||dd=='DPI/CUI' || dd=='DPI-CUI' || dd=='CUI/DPI'){
            var valid = false;
            console.log(id);
            $.ajax({
                type: "GET",
                async: false,
                url: "{{route('clientes.dpiDisponibleEdit')}}",
                data: {"no_documento=" : value, "id": id},
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
</script>
<script src="{{asset('js/clientes/edit.js')}}"></script>
@endpush