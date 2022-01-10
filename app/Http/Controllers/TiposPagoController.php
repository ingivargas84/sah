<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoPago;
use Validator;
use App\Events\ActualizacionBitacora;

class TiposPagoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view ("tipo_pago.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $tipo = TipoPago::create($data);                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$tipo,'tipo_pago'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("tipo_pago");
        $query = TipoPago::where("tipo_pago",$dato)
                        ->where('estado', 1)->get();
        $contador = count($query);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }

    public function nombreDisponibleEdit()
    {
        $dato = Input::get("tipo_pago");
        $id = Input::get('id');

        $query = TipoPago::where("tipo_pago",$dato)
                        ->where('estado', 1)
                        ->where('id','!=', $id)->get();
        $contador = count($query);

        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoPago $tipo_pago, Request $request)
    {
        $tipo_pagoa=$tipo_pago;
        $tipo_pago->update($request->all());
      
        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$tipo_pagoa,$tipo_pago,'tipos_pago'));  

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoPago $tipo_pago, Request $request)
    {
        $password_usuario = Auth::user()->password;

        $data = $request->all();

        $errors = Validator::make($data,[
            'password_actual' => ['required'],
        ]);

         if($errors->fails())
         {
            return  Response::json($errors->errors(), 422);
         }

         if(password_verify($data['password_actual'],$password_usuario))
         {
            $tipo_pago2=$tipo_pago;
            $tipo_pago->estado = 0;
            $tipo_pago->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$tipo_pago2,$tipo_pago,'tipos_pago'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT P.id as id, P.tipo_pago as nombre,  P.created_at as fecha, U.name as usuario_crea
        FROM tipos_pago P
        INNER JOIN users U on P.user_id = U.id
        where P.estado = 1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    public function cargarSelect()
	{

        $result = DB::table('tipo_servicios_extra')
        ->select('tipo_servicios_extra.id','tipo_servicios_extra.nombre')->where('estado',1)->get();

		return Response::json( $result );		
    }
}
