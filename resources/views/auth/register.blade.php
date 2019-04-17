<!DOCTYPE html>
<html>

<head>
    <title>IPCA - Create account</title>
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
        <h1 class="form-heading">{{ __('Register') }}</h1>
        <div class="login-form form-wrapper">
            <div class="main-div">
                <div class="panel">
                    <img src="{{ asset('public/images/logo.png') }}" alt="logo" class="login-logo">                    
                </div>
                <form method="POST" action="{{ route('register') }}">
                        @csrf
                    <div class="form-group">
                        <i class="fa fa-user"></i>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <i class="fa fa-envelope"></i>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <i class="fa fa-lock"></i>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <i class="fa fa-lock"></i>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="{{ __('Confirm Password') }}">
                    </div>    
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                    <div class="back-btn">
                        <p>Already account? <a href="{{ route('login') }}">Click</a> here</p>
                    </div>
                </form>
            </div>
       </div>
    </div>
</body>
</html>