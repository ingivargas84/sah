@extends('layouts.app')
@section('content')
    <form method="POST" id="EmpresaUpdateForm"  action="{{route('empresa.update', $empresa)}}" enctype="multipart/form-data">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-4 {{$errors->has('nit')? 'has-error' : ''}}">
                        <label for="nit">Nit:</label>
                        <input type="text" class="form-control" placeholder="Nit" name="nit" value="{{old('nit', $empresa->nit)}}" >
                        {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                    </div>

                    <div class="col-sm-4">
                        <label for="nombre_contable">Nombre Contable:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contable" name="nombre_contable" value="{{old('nombre_contable', $empresa->nombre_contable)}}" >
                    </div>
                    <div class="col-sm-4">
                        <label for="nombre_comercial">Nombre Comercial:</label>
                        <input type="text" class="form-control" placeholder="Nombre Comercial" name="nombre_comercial" value="{{old('nombre_comercial', $empresa->nombre_comercial)}}" >
                    </div>
                </div>
                <br>                
                <div class="row">
                    <div class="col-sm-12">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" placeholder="Direccion" name="direccion" value="{{old('direccion', $empresa->direccion)}}">
                    </div>                                
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="telefonos">Teléfonos:</label>
                        <input type="text" class="form-control" placeholder="Telefonos" name="telefonos" value="{{old('telefonos', $empresa->telefonos)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" placeholder="Email" name="email" value="{{old('email', $empresa->email)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="no_patente">No. Patente:</label>
                        <input type="text" class="form-control" placeholder="No. Patente" name="no_patente" value="{{old('no_patente', $empresa->no_patente)}}">
                    </div>
                    <div class="col-sm-3">
                        <label>Fecha de Inicio de Operaciones:</label>
                
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <input name="fecha_inicio" type="text" class="form-control pull-right" id="datepickerI" value="{{old('fecha_inicio', $empresa->fecha_inicio ? $empresa->fecha_inicio->format('d-m-Y') : null) }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 {{$errors->has('logotipo')? 'has-error' : ''}}">
                        <label for="logotipo">Logotipo</label><br>
                            @if($empresa->logotipo)
                            <img width="120rem" src="{{$empresa->logotipo}}" alt="No tiene ningun logotipo">
                            <br>
                            @endif
                        <br>
                        <input type="file" name="logotipo">
                        {!!$errors->first('logotipo', '<label class="error">:message</label>')!!}
                    </div>
                </div>

                <br>
                <div class="text-right m-t-15">
                    <button class="btn btn-success form-button">Guardar</button>
                </div>
                                    
                                   
            </div>
    </form>

@stop


@push('scripts')

<script src="{{asset('js/empresa/edit.js')}}"></script>
@endpush