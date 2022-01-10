<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoCliente;
use Validator;

use App\Events\ActualizacionBitacora;

class TiposClientesController extends Controller
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
        return view ("tipos_clientes.index");
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
        $tipo_cliente = new TipoCliente();
        $tipo_cliente->tipo_cliente = $data['tipo_cliente'];
        $tipo_cliente->descuento = $data['descuento'];
        $tipo_cliente->user_id = Auth::user()->id;
        $tipo_cliente->save();                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$tipo_cliente,'tipos_clientes'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("tipo_cliente");
        $query = TipoCliente::where("tipo_cliente",$dato)
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
        $dato = Input::get("tipo_cliente");
        $id = Input::get('id');

        $query = TipoCliente::where("tipo_cliente",$dato)
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
    public function update(TipoCliente $tipo_cliente, Request $request)
    {

        $respuesta = $request->all();
        $tipo_clientea=$tipo_cliente;
        $tipo_cliente->tipo_cliente = $request->tipo_cliente;
        $tipo_cliente->descuento = $request->descuento;
        $tipo_cliente->save();
        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$tipo_clientea,$tipo_cliente,'tipos_clientes'));

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoCliente $tipo_cliente, Request $request)
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
            $tipo_cliented=$tipo_cliente;
            $tipo_cliente->estado = 0;
            $tipo_cliente->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$tipo_cliented,$tipo_cliente,'tipos_clientes'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT TC.id as id, TC.tipo_cliente as tipo_cliente,TC.descuento as descuento,  TC.created_at as fecha, U.name as usuario_crea
        FROM tipos_clientes TC
        INNER JOIN users U on TC.user_id = U.id
        where TC.estado = 1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    
}
