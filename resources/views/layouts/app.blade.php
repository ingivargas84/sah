<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SAH</title>


    <!-- Fonts -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{asset('datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('css/css-loader-master/dist/css-loader.css') }}">
    <!-- NProgress -->

    
    <link href="{{asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">

    <link href="{{asset('fullcalendar-3.10.0/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{asset('fullcalendar-3.10.0/scheduler.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
	@stack('styles')
    <!-- bootstrap-progressbar -->
    <link href="{{asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{asset('css/alertify.css') }}">
    <link rel="stylesheet" href="{{asset('css/default.css') }}">
    <!-- Custom Theme Style -->
    <link href="{{asset('build/css/custom.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{asset('css/sebas.css') }}">
    @if(session()->has('flash'))
    <div class="alert alert-success">{{ session('flash') }}
      <a href="#" class="close" data-dismiss="alert">&times;</a>
    </div>
  @elseif(session()->has('alerta'))
    <div class="alert alert-warning">{{ session('alerta') }}
      <a href="#" class="close" data-dismiss="alert">&times;</a>
    </div>
  @endif
    <!-- Styles -->
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                <a href="/home" class="site_title center"><i class="fas fa-hotel"></i> <span>SAH </span></a>
                </div>
    
                <div class="clearfix"></div>
    
                <!-- menu profile quick info -->
                <div class="profile clearfix">
                <div class="profile_pic">
        
                </div>
                <div class="profile_info">
                    <span>Welcome, {{ Auth::user()->name}}</span>
                    
                </div>
                </div>
                <!-- /menu profile quick info -->
    
                <br />
    
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
               
                    <div class="menu_section">
                        <ul class="nav side-menu">
                
                            <li><a><li class="{{request()->is('home*')? 'active': ''}}"><a href="{{ url('/home') }}"><i class="fas fa-key"></i> Habitaciones</a></li></a>
                            </li>

                            <li><a><i class="fas fa-user-lock"></i> Clientes <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('tipos_clientes*')? 'active': ''}}"><a href="{{ url('/tipos_clientes') }}"><i class="fas fa-restroom"></i> Tipos de Clientes</a></li>
                                    <li class="{{request()->is('tipos_documentos*')? 'active': ''}}"><a href="{{ url('/tipos_documentos') }}"><i class="fas fa-file-alt"></i> Tipos de documentos</a></li>
                                    <li class="{{request()->is('clientes*')? 'active': ''}}"><a href="{{ url('/clientes') }}"><i class="fas fa-user-clock"></i> Clientes</a></li>
                                </ul>
                            </li>


                            <li><a><i class="fas fa-tasks"></i> Reservaciones <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('reservaciones*')? 'active': ''}}"><a href="{{ url('/reservaciones') }}"><i class="fas fa-ticket-alt"></i> Reservaciones</a></li>
                                    <li class="{{request()->is('check-in*')? 'active': ''}}"><a href="{{ url('/check-in') }}"><i class="fas fa-file-signature"></i> Check-in</a></li>
                                    <li class="{{request()->is('check-out*')? 'active': ''}}"><a href="{{ url('/check-out') }}"><i class="fas fa-user-check"></i> Check-out</a></li>
                                </ul>
                            </li>

                            <li><a><i class="fas fa-hotel"></i> Gestion del Hotel <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('niveles*')? 'active': ''}}"><a href="{{ url('/niveles') }}"><i class="fas fa-h-square"></i> Pisos / Niveles</a></li>
                                    <li class="{{request()->is('tipo_habitacion*')? 'active': ''}}"><a href="{{ url('/tipo_habitacion') }}"><i class="fas fa-door-open"></i> Tipos de Habitaciones</a></li>
                                    <li class="{{request()->is('habitaciones*')? 'active': ''}}"><a href="{{ url('/habitaciones') }}"><i class="fas fa-bed"></i> Habitaciones</a></li>
                                    <li class="{{request()->is('tipo_servicios_extra*')? 'active': ''}}"><a href="{{ url('/tipo_servicios_extra') }}"><i class="fas fa-dice"></i> Tipos de Servicios Extras</a></li>
                                    <li class="{{request()->is('servicios_extra*')? 'active': ''}}"><a href="{{ url('/servicios_extra') }}"><i class="fas fa-swimming-pool"></i> Servicios Extras</a></li>
                                    <!-- <li class="{{request()->is('servicios*')? 'active': ''}}"><a href="{{ url('/servicios') }}"><i class="fas fa-phone"></i> Servicios a la Habitación</a></li> -->
                                </ul>
                            </li>

                            <li><a><i class="fas fa-cash-register"></i> Control de Caja <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('cajas*')? 'active': ''}}"><a href="{{ url('/cajas') }}"><i class="fas fa-coins"></i> Cajas</a></li>
                                    <li class="{{request()->is('aperturas_cajas*')? 'active': ''}}"><a href="{{ url('/aperturas_cajas') }}"><i class="fas fa-file-invoice-dollar"></i> Aperturas / Cierres de Cajas</a></li>
                                    <li class="{{request()->is('compras_cajas*')? 'active': ''}}"><a href="{{ url('/compras_cajas') }}"><i class="fas fa-hand-holding-usd"></i> Salidas / Compras por caja</a></li>
                                    <li class="{{request()->is('tipo_pago*')? 'active': ''}}"><a href="{{ url('/tipo_pago') }}"><i class="fas fa-search-dollar"></i> Tipos de Pago</a></li>
                                </ul>
                            </li>

                            <li><a><i class="fas fa-file-invoice"></i> Facturación <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('series*')? 'active': ''}}"><a href="{{ url('/series') }}"><i class="fas fa-receipt"></i> Series de Facturas</a></li>
                                    <li class="{{request()->is('impuestos*')? 'active': ''}}"><a href="{{ url('/impuestos') }}"><i class="fas fa-money-check-alt"></i> Impuestos</a></li>
                                </ul>
                            </li>

                            <li><a><i class="fas fa-user-friends"></i> Gestion de Personal <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('empleados*')? 'active': ''}}"><a href="{{ url('/empleados') }}"><i class="fas fa-user-tie"></i> Empleados</a></li>
                                    <li class="{{request()->is('puestos*')? 'active': ''}}"><a href="{{ url('/puestos') }}"> <i class="fas fa-user-tag"></i> Puestos de Empleados</a></li>
                                </ul>
                            </li>
                        

                            <li><a><i class="fas fa-users"></i> Administración de Usuarios <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('users*')? 'active': ''}} "><a href="{{ url('/users') }}"> <i class="fas fa-user-cog"></i> Gestión de Usuarios</a></li>
                                
                                    <li><a href="#" data-toggle="modal" data-target="#modalResetPassword"><i class="fas fa-unlock-alt"></i> Cambiar Contraseña</a></li>
                                </ul>
                            </li>
                            
                            @role('super-admin|Administrador')
                            <li><a><i class="fas fa-store"></i> Mi Negocio <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="{{request()->is('empresa*')? 'active': ''}}"><a href="{{route('empresa.edit', 1)}}"> <i class="fas fa-edit"></i> Editar Mi Negocio</a></li>
                                    
                                </ul>
                            </li>
                            @endrole
                    </ul>             

                    </div>

                
                </div>
                <!-- /sidebar menu -->
    
                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                <a data-toggle="tooltip" data-placement="top" title="Settings">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="Lock">
                    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                </a>
                <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
                </div>
                <!-- /menu footer buttons -->
           
            </div>
       
            </div>
            <div class="top_nav">
                    <div class="nav_menu">
                      <nav>
                        <div class="nav toggle">
                          <a id="menu_toggle"><i class="fas fa-bars"></i></a>
                        </div>
          
                        <ul class="nav navbar-nav navbar-right">
                          <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              {{ Auth::user()->name }} ({{Auth::user()->username}}) 
                              <span class=" fas fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                              <li><a href="{{ url('/users') }}"> Profile</a></li>
                              <li>
                                <a href="javascript:;">
                                  <span>Settings</span>
                                </a>
                              </li>
                              <li><a href="javascript:;">Help</a></li>
                              <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}<i class="fas fa-sign-out pull-right"></i>

                                </a>
                                
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                    </form>
                                  
                                </li>
                            </ul>
                          </li>
          
                         
                        </ul>
                      </nav>
                    </div>
                  </div>
            <div class="right_col" role="main">
                @yield('content')
            </div>
    </div>        
</div>


<!-- jQuery -->
<script src="{{asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->

<script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{asset('js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('js/datatable/dataTables.bootstrap.min.js') }}"></script>
<script src="{{asset('js/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{asset('js/datatable/jszip.min.js') }}"></script>
<script src="{{asset('js/datatable/pdfmake.min.js') }}"></script>
<script src="{{asset('js/jquery.validate.js') }}"></script>
<script src="{{asset('js/alertify.js') }}"></script>

<!-- FastClick -->
<script src="{{asset('vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{asset('vendors/nprogress/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
<!-- gauge.js -->
<script src="{{asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{asset('vendors/iCheck/icheck.min.js') }}"></script>
<!-- Skycons -->
<script src="{{asset('vendors/skycons/skycons.js') }}"></script>
<!-- Flot -->
<script src="{{asset('vendors/Flot/jquery.flot.js') }}"></script>
<script src="{{asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{asset('vendors/Flot/jquery.flot.time.js') }}"></script>
<script src="{{asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
<script src="{{asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
<script src="{{asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{asset('vendors/DateJS/build/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{asset('datepicker/bootstrap-datepicker.js')}}"></script>
<!--full calendar -->


<script src="{{asset('vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{asset('js/jquery-ui.js') }}"></script>
<script src="{{asset('fullcalendar-3.10.0/fullcalendar.js')}}"></script>
<script src="{{asset('fullcalendar-3.10.0/locale-all.js')}}"></script>
<script src="{{asset('fullcalendar-3.10.0/scheduler.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{asset('build/js/custom.min.js') }}"></script>
<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!}
</script>
@include('users.resetPassword')
@stack('scripts')

<script>
    alertify.defaults = {
        // dialogs defaults
        autoReset:true,
        basic:false,
        closable:true,
        closableByDimmer:true,
        frameless:false,
        maintainFocus:true, // <== global default not per instance, applies to all dialogs
        maximizable:true,
        modal:true,
        movable:true,
        moveBounded:false,
        overflow:true,
        padding: true,
        pinnable:true,
        pinned:true,
        preventBodyShift:false, // <== global default not per instance, applies to all dialogs
        resizable:true,
        startMaximized:false,
        transition:'pulse',
    
        // notifier defaults
        notifier:{
            // auto-dismiss wait time (in seconds)  
            delay:5,
            // default position
            position:'bottom-right',
            // adds a close button to notifier messages
            closeButton: false
        },
    
        // language resources 
        glossary:{
            // dialogs default title
            title:'Aviso!',
            // ok button text
            ok: 'OK',
            // cancel button text
            cancel: 'Cancelar'            
        },
    
        // theme settings
        theme:{
            // class name attached to prompt dialog input textbox.
            input:'ajs-input',
            // class name attached to ok button
            ok:'ajs-ok',
            // class name attached to cancel button 
            cancel:'ajs-cancel'
        }
    };
</script>
</body>
</html>
