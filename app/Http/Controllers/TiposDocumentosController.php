<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoDocumento;
use Validator;
use App\Events\ActualizacionBitacora;


class TiposDocumentosController extends Controller
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
        return view ("tipos_documentos.index");
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
        $tipo = new TipoDocumento();
        $tipo->tipo_documento = $data['tipo_documento'];
        $tipo->user_id = Auth::user()->id;
        $tipo->save();                       

        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$tipo->tipo_documento,'tipos_documentos'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("tipo_documento");
        $query = TipoDocumento::where("tipo_documento",$dato)
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
        $dato = Input::get("tipo_documento");
        $id = Input::get('id');

        $query = TipoDocumento::where("tipo_documento",$dato)
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
    public function update(TipoDocumento $tipo_documento, Request $request)
    {
       $respuesta = $request->all();

        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$tipo_documento, $respuesta['tipo_documento'],'tipos_documentos'));
        $tipo_documento->tipo_documento = $request->tipo_documento;
        $tipo_documento->save();

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDocumento $tipo_documento, Request $request)
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
            $tipo_documento2=$tipo_documento;
            $tipo_documento->estado = 0;
            $tipo_documento->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$tipo_documento2,$tipo_documento,'tipos_documentos'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {

        $query = 'SELECT TD.id as id, TD.tipo_documento as tipo_documento, TD.created_at as fecha, U.name as usuario_crea
        FROM tipos_documentos TD
        INNER JOIN users U on TD.user_id = U.id
        where TD.estado = 1';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
