<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{mix('css/login.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('home')}}"><b>B2EI</b>&nbsp;-&nbsp;Energy monitor</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">{{ __('Reset Password') }}</p>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf



            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ $email or old('email') }}" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
                @endif
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Send Password Reset Link') }}</button>
                </div>
            </div>


        </form>
    </div>
</div>
<script src="{{mix('js/login.js')}}"></script>
</body>
</html>
