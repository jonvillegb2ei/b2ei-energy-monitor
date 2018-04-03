@extends('layouts.app')

@section('header')

    @component('components.page-header')
        {{ __('Dashboard') }}
    @endcomponent

@endsection

@section('content')

    <div class="row">


        @foreach($equipments as $equipment)
        <div class="col-md-4">
            <a href="{{route('equipment', ['equipment' => $equipment])}}" style="color: inherit">
                <div class="box box-widget widget-user">
                    <div class="widget-user-header bg-green-active">
                        <h3 class="widget-user-username">{{$equipment->name}}</h3>
                        <h5 class="widget-user-desc">{{$equipment->localisation}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{$equipment->picture_url}}" alt="{{__('Equipment picture')}}">
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            @foreach($equipment->widgetVariables as $variable)
                                <li>
                                    <div style="height: 35px; padding-top: 10px; padding-right: 7px; padding-left: 7px;">
                                        {{$variable->printable_name}}
                                        <span class="pull-right" style="font-weight: bold">{{$variable->printable_value}}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </a>
        </div>
        @endforeach


    </div>

@endsection