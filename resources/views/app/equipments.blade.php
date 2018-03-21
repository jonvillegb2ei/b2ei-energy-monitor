@extends('layouts.app')

@section('header')

    @component('components.page-header')
        {{ __('Equipments') }}
    @endcomponent

@endsection

@section('content')
    <div class="row">
        @foreach($equipments as $equipment)
        <div class="col-md-4">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-yellow">
                    <span class="pull-right">
                        <div class="btn-group">
                            <a href="{{route('equipment', ['equipment' => $equipment])}}" title="View equipment" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>
                            @administrator
                            <a href="{{route('technician.equipment.detail', ['equipment' => $equipment])}}" title="Edit equipment" class="btn btn-sm btn-default"><i class="fa fa-gear"></i></a>
                            @endadministrator
                        </div>
                    </span>
                    <div class="widget-user-image">
                        <img class="img-circle" src="https://download.schneider-electric.com/files?p_Doc_Ref=PB110409&p_File_Type=rendition_288_png&default_image=DefaultProductImage.png" alt="{{ __('Equipment image') }}">
                    </div>
                    <h3 class="widget-user-username">{{__($equipment->name)}}</h3>
                    <h5 class="widget-user-desc">{{__($equipment->localisation)}}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        @foreach($equipment->widgetVariables as $variable)
                        <li><a href="#">{{$variable->printable_name}} <span class="pull-right" style="font-weight: bold">{{$variable->printable_value}}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection