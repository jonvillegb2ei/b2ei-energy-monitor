@extends('layouts.app')

@section('header')

    @component('components.page-header')
        {{ trans('app.profile.title') }}
    @endcomponent

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @component('components.panel', ['class' => 'box-primary'])
                @slot('title')
                    {{ trans('app.profile.modal-title') }}
                @endslot
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>{{__(session('success')['message'])}}</h5>
                    </div>
                @endif
                <form action="{{route('profile.edit')}}" method="POST" role="form">
                    @csrf
                    <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                        <label for="firstname">{{ trans('app.profile.firstname') }}</label>
                        <input name="firstname" id="firstname" class="form-control" value="{{\Auth::user()->firstname}}" type="text">
                        <span class="help-block">{{ $errors->first('firstname') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                        <label for="lastname">{{ trans('app.profile.lastname') }}</label>
                        <input name="lastname" id="lastname" class="form-control" value="{{\Auth::user()->lastname}}" type="text">
                        <span class="help-block">{{ $errors->first('lastname') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">{{ trans('app.profile.email') }}</label>
                        <input name="email" id="email" class="form-control" value="{{\Auth::user()->email}}" type="text">
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">{{ trans('app.profile.password') }}</label>
                        <input name="password" id="password" class="form-control" placeholder="{{__('Change your password')}}" value="" type="password">
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <label for="password_confirmation">{{ trans('app.profile.password-confirmation') }}</label>
                        <input name="password_confirmation" id="password_confirmation" placeholder="{{__('Confirm your password')}}" class="form-control" value="" type="password">
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right">{{ trans('app.profile.button') }}</button>
                        </div>
                    </div>
                </form>
            @endcomponent
        </div>
    </div>
 @endsection