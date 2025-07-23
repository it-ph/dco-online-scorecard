<?php header("Content-Security-Policy: default-src 'self'; style-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com; font-src https://fonts.googleapis.com https://fonts.gstatic.com 'self' data:"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('eclerx/e-Logo-97x97-1.png')}}">
    <title>DCO - Scorecard</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/dco-scorecard.css')}}" rel="stylesheet">
    <!-- page css -->
    <link href="{{asset('css/login/login-register-lock.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/login/login.css')}}" rel="stylesheet">
    <link href="{{asset('css/login/styles.css')}}" rel="stylesheet">

{{-- <style class="cp-pen-styles">

        </style> --}}

    <!-- You can change the theme colors from here -->
    {{-- <link href="css/colors/default-dark.css" id="theme" rel="stylesheet"> --}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    {{-- <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">DCO Scorecard</p>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    {{-- <section id="wrapper" class="login-register login-sidebar" style="background-image:url({{asset('images/eclerx/eClerx-white.png')}});"> --}}
        <section id="wrapper" class="login-register login-sidebar">
            <ul class="bg-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        <div class="login-box card">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <a href="javascript:void(0)" class="text-center db"><img src="{{asset('images/eclerx/eClerx-logo.png')}}" class="logo" alt="Home" /><br/>
                        <span class="dco-scorecard">  DCO SCORECARD</span>
                    </a>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input id="email" type="text" placeholder="Email Address" autofocus class="login-form-txt form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required  autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="password" placeholder="Password" type="password" class="login-form-txt form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" class="filled-in chk-col-light-blue">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="checkbox-signup"> Remember me </label>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div> --}}
                    {{-- <div class="form-group m-t-10">
                        <div class="col-xs-12 text-center db">
                            <a href="{{route('connect')}}" class="btn btn-warning btn-md text-uppercase btn-rounded">Single Sign-On</a>
                        </div>
                    </div> --}}
                    <div class="form-group m-t-10">
                        <div class="col-xs-12 text-center db">
                            {{-- <a href="{{route('connect')}}" class="btn btn-warning btn-md text-uppercase btn-rounded">Login</a> --}}
                            <button class="btn btn-warning btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Login</button>
                        </div>
                    </div>
                </form>
                <!-- <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form> -->
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('js/theme/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('js/theme/popper.min.js')}}"></script>
    <script src="{{asset('js/theme/bootstrap.min.js')}}"></script>
</body>

</html>
