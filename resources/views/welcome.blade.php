@extends('layout')
  @push('styles')
  <style>

    .carousel-item {
      height: 75vh;
      min-height: 15rem;
      background: no-repeat center center scroll;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
    </style>
  @endpush
@section('contenido')
   <!-- Navegación -->

   <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">  
        <a class="navbar-brand" href="#">
            @if($negocio[0]->logotipo)
            <img src="{{$negocio[0]->logotipo}}" height="50rem" style="fill:blue">
            @endif
          </a>   
    <a class="navbar-brand" href="#"><h6> SAH - Sistema de Administración de Hoteles</h6> </a>
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menú
            <i class="fa fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="/home"><h6> Home</h6> </a>
              </li>
              @guest
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}"> <h6> {{ __('Login') }} </h6></a>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link" href="/login"><h6> {{ Auth::user()->name }} ({{ Auth::user()->username }}) </h6> </a>
              </li>
              
              @endguest
              
            </ul>
          </div>
        </div>
      </nav>

    <!-- carrousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="{{url('images/imagen3.jpg')}}" alt="First slide" height="550" >
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{url('images/imagen2.jpg')}}" alt="Second slide" height="550">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="{{url('images/imagen1.jpg')}}" alt="Third slide" height="550">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
            
 <!-- Pié de página -->
 <footer>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
             <p class="copyright text-muted">Copyright &copy; 2019 · VR Informática y Sistemas. All rights reserved </p>
            </div>
          </div>
        </div>
      </footer>
      @endsection

      @section('scripts')
      
      @endsection