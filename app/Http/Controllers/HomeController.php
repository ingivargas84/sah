<?php

namespace App\Http\Controllers;

use DB;
use App\Habitacion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $habitaciones= DB::table('habitacion')
        ->select('habitacion.estado_id','habitacion.id as id','habitacion.nombre_habitacion as nombreh','estado_habitacion.estado as estadoh','tipo_habitacion.tipo_habitacion as tipo')->leftJoin('estado_habitacion','habitacion.estado_id','=','estado_habitacion.id')->leftJoin('tipo_habitacion','habitacion.tipo_id','=','tipo_habitacion.id')->orderBy('habitacion.nombre_habitacion','asc')->where('habitacion.estado',1)->get();
        
        return view('home',compact('habitaciones'));
    }
}
