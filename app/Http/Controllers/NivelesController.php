<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Nivel;
use Validator;

use App\Events\ActualizacionBitacora;

class NivelesController extends Controller
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
        return view ("niveles.index");
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
        $nivel = new Nivel;
        $nivel->nivel_nombre = $data['nombre'];
        $nivel->user_id = Auth::user()->id;
        $nivel->save();                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$nivel,'niveles'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = Nivel::where("nivel_nombre",$dato)
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

        $query = Nivel::where("nivel_nombre",$dato)
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
    public function update(Nivel $nivel, Request $request)
    {
       /*$this->validate($request,['emp_cui' => 'required|unique:niveles,emp_cui,'.$nivel->id
       ]);*/
       $respuesta = $request->all();
       //dd($respuesta, $nivel);

        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$nivel->nivel_nombre, $respuesta['nombre'],'niveles'));
        $nivel->nivel_nombre = $request->nombre;
        $nivel->save();

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nivel $nivel, Request $request)
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
            $nivela=$nivel;
            $nivel->estado = 0;
            $nivel->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$nivela,$nivel,'niveles'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT P.id as id, P.nivel_nombre as nivel,  P.created_at as fecha, U.name as usuario_crea
        FROM niveles P
        INNER JOIN users U on P.user_id = U.id
        where P.estado = 1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
    public function cargarSelect()
	{

        $result = DB::table('niveles')
        ->select('niveles.id','niveles.nivel_nombre')->where('estado',1)->get();

		return Response::json( $result );		
    }
}