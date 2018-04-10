@extends('layouts.app')

@section('header')

    @component('components.page-header', ['parent' => ['name' => trans('technician.title'), 'icon' => 'fa-gears', 'url' => route('technician')]])
        {{__($equipment->name)}}
    @endcomponent

@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 col-md-4 col-xl-3">
            <div class="row">
                <div class="col-md-12">
                    @include('administrator.technician_components.info')
                </div>
                <div class="col-md-12">
                    @include('administrator.technician_components.equipment-edit')
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-8 col-xl-9">
            <div class="row">
                <div class="col-md-12">
                    @include('administrator.technician_components.variables')
                </div>
            </div>
        </div>
    </div>


@endsection