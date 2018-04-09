@extends('layouts.app')

@section('header')
    @component('components.page-header', [ 'parent' => ['name' => __('Equipments'), 'icon' => 'fa-gears', 'url' => route('equipments')]])
        {{__($equipment->name)}}
    @endcomponent
@endsection



@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-4 col-xl-3">
            <div class="row">
                <div class="col-md-12">
                    @include('app.equipment_components.info')
                </div>
                <div class="col-md-12">
                    @include('app.equipment_components.variables')
                </div>
                <div class="col-md-12">
                    @include('app.equipment_components.export')
                </div>
            </div>
        </div>
        @include('app.equipment_components.charts')
    </div>
@endsection