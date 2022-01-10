<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Habitacion;
use App\EstadoReservacion;
use App\Reservacion;
use Validator;

use App\Events\ActualizacionBitacora;
use App\TipoHabitacion;
class ReservacionesController extends Controller
{
    public function index()
    {
        $habitaciones=Habitacion::where('estado', 1)->get();
        $tiposhabitaciones=TipoHabitacion::where('estado', 1)->get();
        return view ("reservaciones.index",compact('habitaciones','tiposhabitaciones'));
    }
    public function get_reservas(){
        $reservas =Reservacion::select('pago as pago','estado_id','id as id','habitacion_id as resourceId','fecha_inicio as start','fecha_fin as end','nombres as title','telefono as telefono','color')->where('estado',1)->get()->toArray();
        return Response::json( $reservas);
    }

    //funcion para crear la reserva
    public function crear_reservas(Request $request){
        $datos=$request->all();
        $datos['nombres']=ucwords($datos['nombres']);
        $datos['estado_id']=1;
        $datos['color']='#B5ECFA';
        $reservacion= Reservacion::create($datos);
        event(new ActualizacionBitacora(Auth::user()->id,'Creación','',$reservacion,'reservaciones'));    
        return Response::json(['success' => 'Éxito']);
    }

    public function editar_reservas(Reservacion $reservacion, Request $request){
        $color='#B5ECFA';
        $reservaciona=$reservacion;
        if($request->estado_id==1 && $request->pago>1){
            $request->estado_id=2;
        }
        if ($request->estado_id==1) {
            $color='#B5ECFA';
        } else if ($request->estado_id==2) {
           $color='#0021F5';
        } else if($request->estado_id==3) {
            $color='#00F539';
        }
        else{
            $color='#f50010';
        }
        
        $reservacion->nombres= $request->nombres;
        $reservacion->estado_id= $request->estado_id;
        $reservacion->telefono= $request->telefono;
        $reservacion->habitacion_id= $request->habitacion_id;
        $reservacion->pago= $request->pago;
        $reservacion->fecha_inicio= $request->fecha_inicio;
        $reservacion->fecha_fin= $request->fecha_fin;
        $reservacion->color=$color;
        $reservacion->save();
        
        event(new ActualizacionBitacora(Auth::user()->id,'Edición',$reservaciona,$reservacion,'Reservaciones')); 
        return Response::json(['success' => 'Éxito']);
    }

    public function modificar_reservas(Reservacion $reservacion, Request $request){
        $reservaciona=$reservacion;
        $reservacion->habitacion_id= $request->habitacion_id;
        $reservacion->fecha_inicio= $request->fecha_inicio;
        $reservacion->fecha_fin= $request->fecha_fin;
        $reservacion->save();
        event(new ActualizacionBitacora(Auth::user()->id,'Modificación',$reservaciona,$reservacion,'Reservaciones')); 

        return Response::json(['success' => 'Éxito']);
    }

    public function cargarHabitaciones(Request $request) 
    {
        $id = Input::get("id");
        if ($id==0) {
            $result = DB::table('habitacion')
            ->select('habitacion.estado_id','habitacion.id','habitacion.nombre_habitacion','estado_habitacion.estado')->leftJoin('estado_habitacion','habitacion.estado_id','=','estado_habitacion.id')->orderBy('habitacion.nombre_habitacion','asc')->where('habitacion.estado',1)->get();
            
		return Response::json( $result );

        } else {
            $result = DB::table('habitacion')
        ->select('habitacion.estado_id','habitacion.id','habitacion.nombre_habitacion','estado_habitacion.estado')->leftJoin('estado_habitacion','habitacion.estado_id','=','estado_habitacion.id')->where('tipo_id',$id)->orderBy('habitacion.nombre_habitacion','asc')->where('habitacion.estado',1)->get();

		return Response::json( $result );

        }
    }
    public function cargarSelect()
	{

        $result = DB::table('estado_reservacion')
        ->select('estado_reservacion.id','estado_reservacion.estado')->get();

		return Response::json( $result );		
    }

    public function destroy(Reservacion $reservacion, Request $request)
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
            $reservaciona=$reservacion;
            $reservacion->estado = 0;
            $reservacion->save();
            event(new ActualizacionBitacora(Auth::user()->id,'Inactivación',$reservaciona,$reservacion,'reservaciones'));    
            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         } 
        
    }//end delete

    public function fechaInicioDisponible(Request $request){
        
        $fecha_inicio=Carbon::parse($request->fecha_inicio);
        $fecha_fin=Carbon::parse($request->fecha_fin);
        $habitacion_id=$request->habitacion_id;
    
        $query = "SELECT R.fecha_fin
        FROM reservaciones R
        WHERE  R.fecha_fin  BETWEEN DATE_ADD('".$fecha_inicio."', INTERVAL 1 DAY)  AND '".$fecha_fin."'  AND R.habitacion_id = '".$habitacion_id."'and R.estado=1";

        $result = DB::select($query);
        $contador = count($result);
   
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
        

    }


    public function fechaFinDisponible(Request $request){
        $fecha_inicio=Carbon::parse($request->fecha_inicio);
        $fecha_fin=Carbon::parse($request->fecha_fin);
        $habitacion_id=$request->habitacion_id;
    
        $query = " SELECT R.fecha_inicio
                    FROM reservaciones R
                    WHERE  R.fecha_inicio  BETWEEN '".$fecha_inicio."'  AND DATE_SUB('".$fecha_fin."', INTERVAL 1 DAY) AND R.habitacion_id ='".$habitacion_id."' and R.estado=1";

        $result = DB::select($query);
        $contador = count($result);

        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }

    }//fin fecha fin disponible

    public function fechaInicioDisponibleEdit(Request $request){
        
        $fecha_inicio=Carbon::parse($request->fecha_inicio);
        $fecha_fin=Carbon::parse($request->fecha_fin);
        $habitacion_id=$request->habitacion_id;
        $id=$request->id;
        $query = "SELECT R.fecha_fin
        FROM reservaciones R
        WHERE  R.fecha_fin  BETWEEN DATE_ADD('".$fecha_inicio."', INTERVAL 1 DAY)  AND '".$fecha_fin."'  AND R.habitacion_id = '".$habitacion_id."'and R.estado=1 and R.id!='".$id ."'";

        $result = DB::select($query);
        $contador = count($result);
   
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
        

    }


    public function fechaFinDisponibleEdit(Request $request){
        $fecha_inicio=Carbon::parse($request->fecha_inicio);
        $fecha_fin=Carbon::parse($request->fecha_fin);
        $habitacion_id=$request->habitacion_id;
        $id=$request->id;
        $query = " SELECT R.fecha_inicio
                    FROM reservaciones R
                    WHERE  R.fecha_inicio  BETWEEN '".$fecha_inicio."'  AND DATE_SUB('".$fecha_fin."', INTERVAL 1 DAY) AND R.habitacion_id ='".$habitacion_id."' and R.estado=1 and R.id!='".$id ."'";

        $result = DB::select($query);
        $contador = count($result);

        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }

    }//fin fecha fin disponible edit

   
}
