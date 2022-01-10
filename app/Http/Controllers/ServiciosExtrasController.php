<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\ServicioExtra;
use App\TipoServicioExtra;
use Validator;

use App\Events\ActualizacionBitacora;

class ServiciosExtrasController extends Controller
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
        $tipos = TipoServicioExtra::where('estado', 1)->get();
        return view ("servicios_extra.index",compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $nuevos_datos = array(
            'nombre_servicio' => $request->nombre_servicio,
            'tipo_id' => $request->tipo_id,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
        );
        $json = json_encode($nuevos_datos);

        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
       // dd($data);
        $servicios = ServicioExtra::create($data);                  

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$json,'servicios_extra'));

       return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre_servicio");
        $query = ServicioExtra::where("nombre_servicio",$dato)->get();
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
        $dato = Input::get("nombre_servicio");
        $id = Input::get('id');
        
        $query = ServicioExtra::where("nombre_servicio",$dato)->where('id','!=', $id)->get();
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
    public function update(ServicioExtra $servicio_extra, Request $request)
    {
        $nuevos_datos = array(
            'nombre_servicio' => $request->nombre_servicio,
            'tipo_id' => $request->tipo_id,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
        );
        $json = json_encode($nuevos_datos);
 
         event(new ActualizacionBitacora(Auth::user()->id,'Edición',$servicio_extra, $json,'servicios_extra'));

        $servicio_extra->nombre_servicio= $request->nombre_servicio;
        $servicio_extra->tipo_id= $request->tipo_id;
        $servicio_extra->precio= $request->precio;
        $servicio_extra->descripcion= $request->descripcion;
        $servicio_extra->save();

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active(ServicioExtra $servicio_extra, Request $request)
    {

        $data = $request->all();

            $servicio_extraa=$servicio_extra;
            $servicio_extra->estado = 1;
            $servicio_extra->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Reactivación',$servicio_extraa,$servicio_extra,'servicios_extra'));    

 
            return Response::json(['success' => 'Éxito']);

        
    }

    public function destroy(ServicioExtra $servicio_extra, Request $request)
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
            $servicio_extraa=$servicio_extra;
            $servicio_extra->estado = 0;
            $servicio_extra->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$servicio_extraa,$servicio_extra,'servicios_extra'));    
            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT H.id as id,H.nombre_servicio as servicio, H.precio as precio,TS.nombre as tipo,  H.created_at as fecha, U.name as usuario_crea,
        H.tipo_id as tipo_id, H.descripcion as descripcion, if(H.estado= 1, "Activo", "Inactivo" )as estado, H.estado as estado_id
        FROM servicios_extra H 
        INNER JOIN users U on H.user_id = U.id
        LEFT JOIN tipo_servicios_extra TS on H.tipo_id=TS.id';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
