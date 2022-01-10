<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Reservacion;
use App\documentos;
use App\Checkin;
use Validator;
use App\TipoDocumento;
use DB;

use App\Events\ActualizacionBitacora;
use App\Habitacion;
use App\Cliente;
use SebastianBergmann\Diff\Diff;


class CheckinController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
 
 
    public function index()
    {
        return view ("checkin.index");
    }
 
    public function create($id)
    {
       $fecha=Carbon::now();
       $date = $fecha->format('Y-m-d');
       $query="SELECT R.nombres,R.telefono,R.id, R.habitacion_id, R.pago,  DATEDIFF (R.fecha_inicio, R.fecha_fin) as dias
                FROM reservaciones R 
                WHERE R.habitacion_id ='".$id."' AND R.fecha_inicio = '".$date."' AND estado = 1";
       
       $reservacion= DB::select($query);

        $habitaciones= DB::table('habitacion')
        ->select('habitacion.precio','habitacion.estado_id','habitacion.descripcion as descripcion' ,'habitacion.id as id','habitacion.nombre_habitacion as nombreh','estado_habitacion.estado as estadoh','tipo_habitacion.tipo_habitacion as tipo')->leftJoin('estado_habitacion','habitacion.estado_id','=','estado_habitacion.id')->leftJoin('tipo_habitacion','habitacion.tipo_id','=','tipo_habitacion.id')->orderBy('habitacion.nombre_habitacion','asc')->where('habitacion.id',$id)->get();
        $documentos= TipoDocumento::where('estado',1)->get();
       return view("checkin.create" , compact("habitaciones", "documentos","fecha",'reservacion'));
    }

    public function store(Request $request)
    {       
        $data = $request->all();
        $checkin = new Checkin;
        $checkin->habitacion_id = $data['habitacion_id'];
        $checkin->cliente_id=$data['cliente_id'] ;
        $checkin->precio=$data['precio'] ;
        $checkin->adelanto=$data['adelanto'] ;
        $checkin->fecha_inicio=$data['fecha'] ;
        $checkin->user_id = Auth::user()->id;
        $checkin->save();      

        $habitacion  = Habitacion::where('id', $data['habitacion_id'])->first();
        $habitacion->estado_id= 3;
        $habitacion->save();

        if(empty($data['reservacion_id'])){
        }
        else{

            $reservacion  = Reservacion::where('id', $data['reservacion_id'])->first();
            $reservacion->estado_id = 3;
            $reservacion->color='#00F539';
            $reservacion->save();
        }


        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$checkin,'Check-in'));
        return Response::json(['success' => 'Éxito']);
        //return redirect()->route('check-in.index')->withFlash('Check-In Registrado exitosamente!');

    }
 

    public function update(Request $request)
    {
    $respuesta = $request->all();

    $checkin = Checkin::where('id', $request->id)->first();
        $checkina=$checkin;
        $checkin->nombre = $request->nombre;
        $checkin->save();
        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$checkina, $checkin,'checkin'));
        return Response::json(['success' => 'Éxito']);
    }
  
    public function getDatos($id, Cliente $clientes) {
        $tipo_id=$id;
            if ($tipo_id == "")
            {
                $result = "";
                return Response::json( $result);
                
            }
            else {
                $query = "SELECT id, no_documento FROM clientes
                            where clientes.tipo_documento_id='$tipo_id'";
                $result = DB::select($query);
                return Response::json( $result);
            }
    }

    public function getDatos1($id, Cliente $clientes) {
        $tipo_id=$id;
            if ($tipo_id == "")
            {
                $result = "";
                return Response::json( $result);
                
            }
            else {
                $query = "SELECT concat(nombres,' ',apellidos) as nombres, direccion FROM clientes
                            where clientes.id='$tipo_id'";
                $result = DB::select($query);
                return Response::json( $result);
            }
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
        $api_Result['data'] = Checkin::where('estado', 1)->with('user')->with('habitacion')->get();
        return Response::json( $api_Result );
    }

}

