@extends('layouts.app')



@section('content')
<!-- page content -->
    <!-- top tiles -->
    <div class="row tile_count" >
        @foreach ($habitaciones as $item)
            @if ($item->estado_id==1)
            <a href="{{ URL::route('check-in.new', $item->id) }}" class="check-in" data-id="{{$item->id}}"> <div class="col-sm-2 tile_stats_count" style="background-color: #16ff5c; margin: 15px;" >
                    <div class="count" style="color: white !important">{{$item->nombreh}}</div>
                    <span style="color: white !important"> {{$item->tipo}} </span>
                    <hr>
                    <span class="count_bottom text-center" style="color: white !important"><i class="fa fa-sort-asc"></i>{{$item->estadoh}} </i></span>
                </div>
            </a>
            @elseif ($item->estado_id==3)
            <a href="#" class="check-in" data-id="{{$item->id}}"> <div class="col-sm-2 tile_stats_count" style="background-color: #ba0000; margin: 15px;" >
                <div class="count" style="color: white !important">{{$item->nombreh}}</div>
                <span style="color: white !important"> {{$item->tipo}} </span>
                <hr>
                <span class="count_bottom text-center" style="color: white !important"><i class="fa fa-sort-asc"></i>{{$item->estadoh}} </i></span>
            </div>
        </a>
            @endif
        @endforeach
        
    </div>
    <!-- /top tiles -->

    <div class="row">

    </div>
    <br />

@endsection

