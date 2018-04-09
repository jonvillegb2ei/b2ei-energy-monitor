@extends('layouts.app')

@section('header')
    @component('components.page-header')
        {{ __('Users') }}
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('administrator.users_components.create-user')
        </div>
        <div class="col-md-9">
            @include('administrator.users_components.users')
        </div>
    </div>
@endsection