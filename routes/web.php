<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware'=>['auth','active', 'cajero'] ],
    function(){ 
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('user/getJson' , 'UsersController@getJson' )->name('users.getJson');
    Route::get('users' , 'UsersController@index' )->name('users.index');
    Route::post('users' , 'UsersController@store' )->name('users.store');
    Route::delete('users/delete/{user}' , 'UsersController@destroy' );
    Route::post('users/update/{user}' , 'UsersController@update' );
    Route::get('users/{user}/edit', 'UsersController@edit' );
    Route::post('users/reset/tercero/{user}' , 'UsersController@resetPasswordTercero');
    Route::post('users/reset' , 'UsersController@resetPassword')->name('users.reset');
    Route::get( '/users/cargar' , 'UsersController@cargarSelect')->name('users.cargar');


    //rutas para empleados
    Route::get( '/empleados' , 'EmpleadosController@index')->name('empleados.index');
    Route::get( '/empleados/getJson/' , 'EmpleadosController@getJson')->name('empleados.getJson');
    Route::get( '/empleados/new' , 'EmpleadosController@create')->name('empleados.new');
    Route::get( '/empleados/{empleado}/edit' , 'EmpleadosController@edit');
    Route::put( '/empleados/{empleado}/update' , 'EmpleadosController@update')->name('empleados.update');
    Route::post( '/empleados/save/' , 'EmpleadosController@store')->name('empleados.save');
    Route::delete('empleados/{empleado}' , 'EmpleadosController@destroy');
    Route::post( '/empleado/active/{empleado}' , 'EmpleadosController@active');
    Route::get('/empleados/nitDisponible/', 'EmpleadosController@nitDisponible')->name('empleados.nitDisponible');
    Route::get('cui-disponible/', 'EmpleadosController@dpiDisponible')->name('empleados.dpiDisponible');
    Route::get('cui-disponible-edit/', 'EmpleadosController@dpiDisponibleEdit')->name('empleados.dpiDisponibleEdit');
    Route::post( 'empleados/{empleado}/asignaruser' , 'EmpleadosController@asignarUser')->name('empleados.asignaruser');

    // rutas para empresa
    Route::get( '/empresa/{empresa}/edit' , 'EmpresaController@edit')->name('empresa.edit');
    Route::put( '/empresa/{empresa}/update' , 'EmpresaController@update')->name('empresa.update');

    // Rutas para puestos de empleados
    Route::get( '/puestos' , 'PuestosController@index')->name('puestos.index');
    Route::get( '/puestos/getJson/' , 'PuestosController@getJson')->name('puestos.getJson');
    Route::put( '/puestos/{puesto}/update' , 'PuestosController@update')->name('puestos.update');
    Route::post( '/puestos/save' , 'PuestosController@store')->name('puestos.save');
    Route::post('/puestos/{puesto}/delete' , 'PuestosController@destroy');
    Route::get('/puestos/nombreDisponible/', 'PuestosController@nombreDisponible');
    Route::get('/puestos/nombreDisponibleEdit/', 'PuestosController@nombreDisponibleEdit');

    // Rutas para niveles de empleados
    Route::get( '/niveles' , 'NivelesController@index')->name('niveles.index');
    Route::get( '/niveles/getJson/' , 'NivelesController@getJson')->name('niveles.getJson');
    Route::put( '/niveles/{nivel}/update' , 'NivelesController@update')->name('niveles.update');
    Route::post( '/niveles/save' , 'NivelesController@store')->name('niveles.save');
    Route::post('/niveles/{nivel}/delete' , 'NivelesController@destroy');
    Route::get('/niveles/nombreDisponible/', 'NivelesController@nombreDisponible');
    Route::get('/niveles/nombreDisponibleEdit/', 'NivelesController@nombreDisponibleEdit');

    //rutas para tipo de habitaciones
    Route::get( '/tipo_habitacion' , 'TipoHabitacionesController@index')->name('tipo_habitacion.index');
    Route::get( '/tipo_habitacion/getJson/' , 'TipoHabitacionesController@getJson')->name('tipo_habitacion.getJson');
    Route::put( '/tipo_habitacion/{tipo_habitacion}/update' , 'TipoHabitacionesController@update')->name('tipo_habitacion.update');
    Route::post( '/tipo_habitacion/save' , 'TipoHabitacionesController@store')->name('tipo_habitacion.save');
    Route::post('/tipo_habitacion/{tipo_habitacion}/delete' , 'TipoHabitacionesController@destroy');
    Route::get('/tipo_habitacion/nombreDisponible/', 'TipoHabitacionesController@nombreDisponible');
    Route::get('/tipo_habitacion/nombreDisponibleEdit/', 'TipoHabitacionesController@nombreDisponibleEdit');

     //rutas para habitaciones
     Route::get( '/habitaciones' , 'HabitacionesController@index')->name('habitaciones.index');
     Route::get( '/habitaciones/getJson/' , 'HabitacionesController@getJson')->name('habitaciones.getJson');
     Route::put( '/habitaciones/{habitacion}/update' , 'HabitacionesController@update')->name('habitaciones.update');
     Route::post( '/habitaciones/save' , 'HabitacionesController@store')->name('habitaciones.save');
     Route::post('/habitaciones/{habitacion}/delete' , 'HabitacionesController@destroy');
     Route::get('/habitaciones/nombreDisponible/', 'HabitacionesController@nombreDisponible')->name('habitaciones.nombreDisponible');
     Route::get('/habitaciones/nombreDisponibleEdit/', 'HabitacionesController@nombreDisponibleEdit')->name('habitaciones.nombreDisponibleEdit');
     Route::get( '/tipos_habitacion/cargar' , 'TipoHabitacionesController@cargarSelect')->name('tipos_habitacion.cargar');
     Route::get( '/niveles/cargar' , 'NivelesController@cargarSelect')->name('niveles.cargar');

     //rutas para tipo de servicios extras
     Route::get( '/tipo_servicios_extra' , 'TipoServicioExtraController@index')->name('tipo_servicios_extra.index');
     Route::get( '/tipo_servicios_extra/getJson/' , 'TipoServicioExtraController@getJson')->name('tipo_servicios_extra.getJson');
     Route::put( '/tipo_servicios_extra/{tipo_servicio_extra}/update' , 'TipoServicioExtraController@update')->name('tipo_servicios_extra.update');
     Route::post( '/tipo_servicios_extra/save' , 'TipoServicioExtraController@store')->name('tipo_servicios_extra.save');
     Route::post('/tipo_servicios_extra/{tipo_servicio_extra}/delete' , 'TipoServicioExtraController@destroy');
     Route::get('/tipo_servicios_extra/nombreDisponible/', 'TipoServicioExtraController@nombreDisponible');
     Route::get('/tipo_servicios_extra/nombreDisponibleEdit/', 'TipoServicioExtraController@nombreDisponibleEdit');

     //rutas para servicios extras
     Route::get( '/servicios_extra' , 'ServiciosExtrasController@index')->name('servicios_extra.index');
     Route::get( '/servicios_extra/getJson/' , 'ServiciosExtrasController@getJson')->name('servicios_extra.getJson');;
     Route::put( '/servicios_extra/{servicio_extra}/update' , 'ServiciosExtrasController@update')->name('servicios_extra.update');
     Route::post( '/servicios_extra/save' , 'ServiciosExtrasController@store')->name('servicios_extra.save');
     Route::post('/servicios_extra/{servicio_extra}/delete' , 'ServiciosExtrasController@destroy');
     Route::get('/servicios_extra/nombreDisponible/', 'ServiciosExtrasController@nombreDisponible');
     Route::get('/servicios_extra/nombreDisponibleEdit/', 'ServiciosExtrasController@nombreDisponibleEdit');
     Route::get( '/tipos_servicio_extra/cargar' , 'TipoServicioExtraController@cargarSelect')->name('tipos_servicio_extra.cargar');
     Route::post('/servicios_extra/{servicio_extra}/active' , 'ServiciosExtrasController@active');

     //rutas para Tipos de Clientes
    Route::get( '/tipos_clientes' , 'TiposClientesController@index')->name('tipos_clientes.index');
    Route::get( '/tipos_clientes/getJson/' , 'TiposClientesController@getJson')->name('tipos_clientes.getJson');
    Route::put( '/tipos_clientes/{tipo_cliente}/update' , 'TiposClientesController@update')->name('tipos_clientes.update');
    Route::post( '/tipos_clientes/save' , 'TiposClientesController@store')->name('tipos_clientes.save');
    Route::post('/tipos_clientes/{tipo_cliente}/delete' , 'TiposClientesController@destroy');
    Route::get('/tipos_clientes/nombreDisponible/', 'TiposClientesController@nombreDisponible');
    Route::get('/tipos_clientes/nombreDisponibleEdit/', 'TiposClientesController@nombreDisponibleEdit');
    
    //rutas para Tipos de Documentos de identificacion
    Route::get( '/tipos_documentos' , 'TiposDocumentosController@index')->name('tipos_documentos.index');
    Route::get( '/tipos_documentos/getJson/' , 'TiposDocumentosController@getJson')->name('tipos_documentos.getJson');
    Route::put( '/tipos_documentos/{tipo_documento}/update' , 'TiposDocumentosController@update')->name('tipos_documentos.update');
    Route::post( '/tipos_documentos/save' , 'TiposDocumentosController@store')->name('tipos_documentos.save');
    Route::post('/tipos_documentos/{tipo_documento}/delete' , 'TiposDocumentosController@destroy');
    Route::get('/tipos_documentos/nombreDisponible/', 'TiposDocumentosController@nombreDisponible');
    Route::get('/tipos_documentos/nombreDisponibleEdit/', 'TiposDocumentosController@nombreDisponibleEdit');
    
    //rutas para clientes
    Route::get('/clientes', 'ClientesController@index')->name('clientes.index');
    Route::get('/clientes/getJson/' , 'ClientesController@getJson')->name('clientes.getJson');
    Route::get('/clientes/new' , 'ClientesController@create')->name('clientes.new');
    Route::post('/clientes/save/' , 'ClientesController@store')->name('clientes.save');
    Route::get('/clientes/edit/{cliente}' , 'ClientesController@edit');
    Route::put('/clientes/{cliente}/update' , 'ClientesController@update')->name('clientes.update');
    Route::get('/clientes/nitDisponible/', 'ClientesController@nitDisponible')->name('clientes.nitDisponible');
    Route::get( '/clientes/dpiDisponible/', 'ClientesController@dpiDisponible')->name('clientes.dpiDisponible');
    Route::post('/clientes/{cliente}/active' , 'ClientesController@active');
    Route::post('/clientes/{cliente}/delete' , 'ClientesController@destroy');
    Route::get('/clientes/nitDisponibleEdit/', 'ClientesController@nitDisponibleEdit')->name('clientes.nitDisponibleEdit');
    Route::get('/clientes/dpiDisponibleEdit/', 'ClientesController@dpiDisponibleEdit')->name('clientes.dpiDisponibleEdit');

    //reservaciones
    Route::get('/reservaciones', 'ReservacionesController@index')->name('reservaciones.index');
    Route::get( '/habitaciones/cargar' , 'ReservacionesController@cargarHabitaciones');
    Route::get( '/reservaciones/get' , 'ReservacionesController@get_reservas');
    Route::post( '/reservaciones/create' , 'ReservacionesController@crear_reservas');
    Route::put('/reservaciones/{reservacion}/edit' , 'ReservacionesController@editar_reservas');
    Route::put('/reservaciones/{reservacion}/update' , 'ReservacionesController@modificar_reservas');
    Route::get('/reservacion/cargar' , 'ReservacionesController@cargarSelect');

    Route::get('/reservaciones/fecha_inicio' , 'ReservacionesController@fechaInicioDisponible');
    Route::get('/reservaciones/fecha_fin' , 'ReservacionesController@fechaFinDisponible');
    Route::get('/reservaciones/fecha_inicioedit' , 'ReservacionesController@fechaInicioDisponibleEdit');
    Route::get('/reservaciones/fecha_finedit' , 'ReservacionesController@fechaFinDisponibleEdit');
    Route::post('/reservacion/{reservacion}/delete' , 'ReservacionesController@destroy');

    //rutas tipo de pago
    Route::get( '/tipo_pago' , 'TiposPagoController@index')->name('tipo_pago.index');
    Route::get( '/tipo_pago/getJson/' , 'TiposPagoController@getJson')->name('tipo_pago.getJson');
    Route::put( '/tipo_pago/{tipo_pago}/update' , 'TiposPagoController@update')->name('tipo_pago.update');
    Route::post( '/tipo_pago/save' , 'TiposPagoController@store')->name('tipo_pago.save');
    Route::post('/tipo_pago/{tipo_pago}/delete' , 'TiposPagoController@destroy');
    Route::get('/tipo_pago/nombreDisponible/', 'TiposPagoController@nombreDisponible');
    Route::get('/tipo_pago/nombreDisponibleEdit/', 'TiposPagoController@nombreDisponibleEdit');

     //Rutas para Series
    Route::get( '/series' , 'SeriesFacturaController@index');
    Route::get( '/series/getJson/' , 'SeriesFacturaController@getJson');
    Route::post( '/series/save/' , 'SeriesFacturaController@store');
    Route::put( '/series/{serie}/update' , 'SeriesFacturaController@update');
    Route::get( '/series/rangoDisponible/', 'SeriesFacturaController@rangoDisponible');
    Route::get( '/series/rangoDisponible-edit/', 'SeriesFacturaController@rangoDisponible_edit');
    Route::post('/series/{serie}/delete' , 'SeriesFacturaController@destroy');
    Route::post('/series/{serie}/cambiarestado' , 'SeriesFacturaController@cambiarestado');
    Route::get('/series/cargarselect' , 'SeriesFacturaController@cargarSelect');


    //rutas para Impuestos
    Route::get( '/impuestos' , 'ImpuestosController@index')->name('impuestos.index');
    Route::get( '/impuestos/getJson/' , 'ImpuestosController@getJson')->name('impuestos.getJson');
    Route::put( '/impuestos/{impuesto}/update' , 'ImpuestosController@update')->name('impuestos.update');
    Route::post( '/impuestos/save' , 'ImpuestosController@store')->name('impuestos.save');
    Route::post('/impuestos/{impuesto}/delete' , 'ImpuestosController@destroy');
    Route::get('/impuestos/nombreDisponible/', 'ImpuestosController@nombreDisponible');
    Route::get('/impuestos/nombreDisponibleEdit/', 'ImpuestosController@nombreDisponibleEdit');

    //rutas para cajas
    Route::get( '/cajas' , 'CajasController@index')->name('cajas.index');
    Route::get( '/cajas/getJson/' , 'CajasController@getJson')->name('cajas.getJson');
    Route::put( '/cajas/update' , 'CajasController@update')->name('cajas.update');
    Route::post( '/cajas/save' , 'CajasController@store')->name('cajas.save');
    Route::post('/cajas/delete' , 'CajasController@destroy')->name('cajas.delete');
    Route::get('/cajas/nombreDisponible/', 'CajasController@nombreDisponible')->name('cajas.nombreDisponible');
    Route::get('/cajas/nombreDisponibleEdit/', 'CajasController@nombreDisponibleEdit')->name('cajas.nombreDisponibleEdit');
    Route::get('/cajas/movimiento/{caja}', 'CajasController@show')->name('cajas.show');
    Route::get( '/cajas/movimiento/{caja}/getJson' , 'CajasController@getJsonDetalle' )->name('cajas.getJsonDetalle');
    Route::get( '/users/cargarA' , 'UsersController@cargarSelectApertura')->name('users.cargarA');

    // RUTAS APERTURAS DE CAJAS
    Route::get( '/aperturas_cajas' , 'AperturaCajaController@index')->name('aperturas_cajas.index');
    Route::get( '/aperturas_cajas/getJson/' , 'AperturaCajaController@getJson')->name('aperturas_cajas.getJson');
    Route::put( '/aperturas_cajas/{tipo_pago}/update' , 'AperturaCajaController@update')->name('aperturas_cajas.update');
    //Route::post( '/aperturas_cajas/save' , 'AperturaCajaController@store')->name('aperturas_cajas.save');
    Route::post('/aperturas_cajas/{tipo_pago}/delete' , 'AperturaCajaController@destroy');

    Route::middleware('role:Administrador|super-admin')
    ->post( '/aperturas_cajas/apertura' , 'AperturaCajaController@apertura')->name('aperturas_cajas.apertura');
    Route::middleware('role:Administrador|super-admin')
    ->post( '/aperturas_cajas/cierre' , 'AperturaCajaController@cierre')->name('aperturas_cajas.cierre');
    Route::get( '/aperturas_cajas/get' , 'AperturaCajaController@get')->name('aperturas_cajas.get');

    Route::get( '/compras_cajas' , 'ComprasCajasController@index')->name('compras_cajas.index');
    Route::get( '/compras_cajas/getJson/' , 'ComprasCajasController@getJson')->name('compras_cajas.getJson');
    Route::post( '/compras_cajas/save' , 'ComprasCajasController@store')->name('compras_cajas.save');


    //rutas para cajas
    Route::get( '/check-in' , 'CheckinController@index')->name('check-in.index');
    Route::get( '/check-in/getJson/' , 'CheckinController@getJson')->name('check-in.getJson');
    Route::put( '/check-in/update' , 'CheckinController@update')->name('check-in.update');
    Route::get( '/check-in/new/{id}' , 'CheckinController@create')->name('check-in.new');
    Route::post( '/check-in/save' , 'CheckinController@store')->name('check-in.save');
    Route::post('/check-in/delete' , 'CheckinController@destroy')->name('check-in.delete');
    Route::get('/check-in/documentos/{id}', 'CheckinController@getDatos')->name('check-in.documentos');
    Route::get('/check-in/clientes/{id}', 'CheckinController@getDatos1')->name('check-in.clientes');

    Route::get( '/reservas/cargarA' , 'ReservacionesController@cargarReserva')->name('reservas.cargarA');

    
});

Route::get('/', function () {
    $negocio = App\Empresa::all();
    return view('welcome', compact('negocio'));
});

Auth::routes();
Route::get('activate/{token}', 'Auth\RegisterController@activate')->name('activate');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/user/get/' , 'Auth\LoginController@getInfo')->name('user.get');
Route::post('/user/contador' , 'Auth\LoginController@Contador')->name('user.contador');
Route::post('/password/reset2' , 'Auth\ForgotPasswordController@ResetPassword')->name('password.reset2');
Route::get('/user-existe/', 'Auth\LoginController@userExiste')->name('user.existe');

