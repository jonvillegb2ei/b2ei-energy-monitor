@extends('layouts.app')

@section('header')

    @component('components.page-header')
        {{ __('Technician') }}
    @endcomponent

@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    @include('administrator.technician_components.create-equipment')
                </div>
                <div class="col-md-12">
                    @include('administrator.technician_components.ping')
                </div>
                <div class="col-md-12">
                    @include('administrator.technician_components.identify')
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    @include('administrator.technician_components.equipments')
                </div>
                <div class="col-md-12">
                    @include('administrator.technician_components.modbus-client')
                </div>
                <div class="col-md-12">
                    @include('administrator.technician_components.applogs')
                </div>
                <div class="col-md-12">
                    @include('administrator.technician_components.syslogs')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
@endsection