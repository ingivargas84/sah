<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use Illuminate\Support\Facades\Storage;
use Validator;
use Image;

class EmpresaController extends Controller
{
    public function edit(Empresa $empresa)
    {
        return view('empresa.edit', compact('empresa'));
    }

    public function update(Empresa $empresa, Request $request)
    {
        if($request->hasfile('logotipo'))
        {
            $this->validate($request, [
                'logotipo' => 'image|mimes:png'
            ]);

            $image = Image::make($request->file('logotipo')->getRealPath());
            $image->encode('data-url');

            $empresa->logotipo = $image;

            $empresa->save();            
        }

        $empresa->update([
            'nit' => $request['nit'],
            'nombre_contable' => $request['nombre_contable'],
            'nombre_comercial' => $request['nombre_comercial'],
            'direccion' => $request['direccion'],
            'telefonos' => $request['telefonos'],
            'email' => $request['email'],
            'fecha_inicio' => $request['fecha_inicio'],
            'no_patente' => $request['no_patente']
        ]);
     
       return redirect()->route('empresa.edit', $empresa)->with('flash','La informacion del negocia ha sido guardada');
    }
}
