<!DOCTYPE html>
<html>

<head>
    <title>IPCA - Login</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap.min.js') }}"></script>
</head>

<body class="form-body">
    <div class="container">
        <h1 class="form-heading" style="visibility: hidden;">login</h1>
        <div class="login-form form-wrapper">
            <div class="main-div">
                <div class="panel">
                    <img src="{{ asset('public/images/logo.png') }}" alt="logo" class="login-logo">                    
                </div>
                <form method="POST" action="{{ route('user.login.post') }}">
                        @csrf
                    <div class="form-group">
                        <i class="fa fa-envelope"></i>
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}"  autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" name="password" >
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>                
                </form>
            </div>
       </div>
    </div>
</body>
</html>