<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Cliente;
use App\TipoCliente;
use App\TipoDocumento;
use Validator;

use App\Events\ActualizacionBitacora;

class ClientesController extends Controller
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
       
        return view ("clientes.index");
    }
    
    public function create()
    {
       $user = Auth::user()->id;
       $tipos_clientes = TipoCliente::where('estado', 1)->get();
       $tipos_documentos = TipoDocumento::where('estado', 1)->get();
       return view("clientes.create" , compact( "user", "tipos_clientes", 'tipos_documentos'));
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
       // dd($data);
        $cliente = Cliente::create($data);                  

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$cliente,'Clientes'));

        return redirect()->route('clientes.index')->withFlash('El Cliente ha sido creado exitosamente!');

    }

    public function nitDisponible()
	{
		$dato = Input::get("nit");
		$query = Cliente::where("nit",$dato)->get();
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
    public function nitDisponibleEdit()
    {
        $dato = Input::get("nit");
        $id = Input::get('id');
        
        $query = Cliente::where("nit",$dato)->where('id','!=', $id)->get();
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
    
    public function dpiDisponible()
	{
		$dato = Input::get("no_documento");
		$query = Cliente::where("no_documento",$dato)->get();
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
    public function dpiDisponibleEdit()
    {
        $dato = Input::get("no_documento");
        $id = Input::get('id');
        $query = Cliente::where("no_documento",$dato)->where('id','!=', $id)->get();
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
    public function edit(Cliente $cliente)
    {
        $query = "SELECT * FROM clientes WHERE id=".$cliente->id."";
        $fieldsArray = DB::select($query);

        $tipos_clientes = TipoCliente::where('estado', 1)->get();
        $tipos_documentos = TipoDocumento::where('estado', 1)->get();
        return view('clientes.edit', compact('cliente', 'fieldsArray', 'tipos_clientes', 'tipos_documentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Cliente $cliente, Request $request)
    {
        $clientea=$cliente;
        $cliente->update($request->all());
      
        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$clientea,$cliente,'Clientes'));    

        return redirect()->route('clientes.index', $cliente)->with('flash','El Cliente ha sido actualizado!');
    }

    public function active(Cliente $cliente, Request $request)
    {

        $data = $request->all();
        $clientea=$cliente;
        $cliente->estado = 1;
        $cliente->save();
        event(new ActualizacionBitacora(Auth::user()->id,'Reactivación',$clientea,$cliente,'Clientes'));    


        return Response::json(['success' => 'Éxito']);

        
    }

    public function destroy(Cliente $cliente, Request $request)
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
            $clientea=$cliente;
            $cliente->estado = 0;
            $cliente->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$clientea,$cliente,'Clientes'));    
            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT C.id as id, concat(C.nombres," ",C.apellidos) as nombres , C.celular as telefonos, C.nit as nit , C.correo as correo,
                    TS.tipo_cliente as tipo,  C.created_at as fecha,
                    if(C.estado= 1, "Activo", "Inactivo" )as estado, C.estado as estado_id
                    FROM clientes C 
                    LEFT JOIN tipos_clientes TS on C.tipo_id=TS.id';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
