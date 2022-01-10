<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Caja;
use Validator;

use App\Events\ActualizacionBitacora;

class CajasController extends Controller
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
        $cajeros = User::role(['Recepcion','Ventas'])->where('active', 1)->get();
        return view ("cajas.index",compact('cajeros' ));
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

        $caja = new Caja;
        $caja->nombre = $data['nombre'];
        $caja->user_id = Auth::user()->id;
        $caja->save();                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$caja,'cajas'));

        return Response::json(['success' => 'Éxito']);
    }
 
    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = Caja::where("nombre",$dato)
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

        $query = Caja::where("nombre",$dato)
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
    public function update(Request $request)
    {
    /*$this->validate($request,['emp_cui' => 'required|unique:cajas,emp_cui,'.$caja->id
    ]);*/
    $respuesta = $request->all();

    $caja = Caja::where('id', $request->id)->first();
        $cajaa=$caja;
        $caja->nombre = $request->nombre;
        $caja->save();
        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$cajaa, $caja,'cajas'));
        return Response::json(['success' => 'Éxito']);
    }
  
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
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
            
            $caja = Caja::where('id',$request->id)->first();
            $cajaa=$caja;
            $caja->estado = 0;
            $caja->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$cajaa,$caja,'cajas'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    
        
    }
     
    public function getJson(Request $params)
    {
        /*$query = "SELECT * FROM cajas ";

        $result = DB::select($query);
        $api_Result['data'] = $result;*/

        $api_Result['data'] = Caja::where('estado', 1)->with('user')->get();

        return Response::json( $api_Result );
    }
    public function getJsonDetalle(Request $params, Caja $caja)
    {

        $api_Result['data'] = $caja->movimientos_cajas()->with('user')->get();

        return Response::json( $api_Result );
    }

    public function show(Caja $caja)
    {
        return view('cajas.show', compact('caja'));
    }
}
