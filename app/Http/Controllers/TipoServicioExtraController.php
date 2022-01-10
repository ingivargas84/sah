<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoServicioExtra;
use Validator;
use App\Events\ActualizacionBitacora;

class TipoServicioExtraController extends Controller
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
        return view ("tipo_servicios_extra.index");
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
        $tipo = new TipoServicioExtra();
        $tipo->nombre = $data['nombre'];
        $tipo->user_id = Auth::user()->id;
        $tipo->save();                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$tipo->nombre,'tipo_servicios_extra'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = TipoServicioExtra::where("nombre",$dato)
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
        $dato = Input::get("nombre");
        $id = Input::get('id');

        $query = TipoServicioExtra::where("nombre",$dato)
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
    public function update(TipoServicioExtra $tipo_servicio_extra, Request $request)
    {
       $respuesta = $request->all();

        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$tipo_servicio_extra, $respuesta['nombre'],'tipo_servicios_extra'));
        $tipo_servicio_extra->nombre = $request->nombre;
        $tipo_servicio_extra->save();

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoServicioExtra $tipo_servicio_extra, Request $request)
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
            $tipo_servicio_extra2=$tipo_servicio_extra;
            $tipo_servicio_extra->estado = 0;
            $tipo_servicio_extra->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$tipo_servicio_extra2,$tipo_servicio_extra,'tipo_servicio_extra'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT P.id as id, P.nombre as nombre, P.created_at as fecha, U.name as usuario_crea
        FROM tipo_servicios_extra P
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
