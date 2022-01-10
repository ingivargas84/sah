<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoHabitacion;
use Validator;
use App\Events\ActualizacionBitacora;

class TipoHabitacionesController extends Controller
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
        return view ("tipo_habitacion.index");
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
        $tipo = new TipoHabitacion();
        $tipo->tipo_habitacion = $data['nombre'];
        $tipo->user_id = Auth::user()->id;
        $tipo->save();                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','','','tipo_habitacion'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = TipoHabitacion::where("tipo_habitacion",$dato)
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

        $query = TipoHabitacion::where("tipo_habitacion",$dato)
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
    public function update(TipoHabitacion $tipo_habitacion, Request $request)
    {
       $respuesta = $request->all();
       //dd($respuesta, $tipo_habitacion);

        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$tipo_habitacion->tipo_habitacion, $respuesta['nombre'],'tipo_habitacion'));
        $tipo_habitacion->tipo_habitacion = $request->nombre;
        $tipo_habitacion->save();

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoHabitacion $tipo_habitacion, Request $request)
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
            $tipo_habitacion2=$tipo_habitacion;
            $tipo_habitacion->estado = 0;
            $tipo_habitacion->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$tipo_habitacion2,$tipo_habitacion,'tipo_habitacion'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT TH.id as id, TH.tipo_habitacion as nombre, TH.created_at as fecha, U.name as usuario_crea
        FROM tipo_habitacion TH
        INNER JOIN users U on TH.user_id = U.id
        where TH.estado = 1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    public function cargarSelect()
	{

        $result = DB::table('tipo_habitacion')
        ->select('tipo_habitacion.id','tipo_habitacion.tipo_habitacion')->where('estado',1)->get();

		return Response::json( $result );		
    }
}
