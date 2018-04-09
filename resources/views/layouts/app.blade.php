<!DOCTYPE html>
<html ng-app="EnergyMonitor">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="{{url('/')}}" name="base-url">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <!--[if lt IE 9]>
    <script src="{{url('/js/html5shiv.min.js')}}"></script>
    <script src="{{url('/js/respond.min.js')}}"></script>
    <![endif]-->
    @yield('head')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('layouts.components.header')
    @include('layouts.components.sidebar')
    <div class="content-wrapper">
        <section class="content-header">
            @yield('header')
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>
    @include('layouts.components.footer')
</div>
<script src="{{mix('js/app.js')}}"></script>
@yield('script')
</body>
</html>
