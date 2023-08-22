@extends('layouts.auth')

@section('content')

    <!-- Header -->
    <div class="px-30 py-10 text-center">
        <a class="link-effect font-w700" href="/">
            <img src="{{ asset('images/certisaas-logo-color.svg') }}" style="width: 96px;" class="img-fluid" />
        </a>

        <h2 class="h5 font-w400 mb-0" style="padding-top: 20px;">Iniciar sesi&oacute;n</h2>
    </div>
    <!-- END Header -->

    <!-- Sign In Form -->
    <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
    <form class="js-validation-signin px-30" action="{{ route('auth.admin.login.verify') }}" method="post">

        <div class="form-group row">
            <div class="col-12">
                <div class="form-material floating">
                    <input type="email" class="form-control" id="login-username" name="email">
                    <label for="login-username">Correo Electr&oacute;nico</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="form-material floating">
                    <input type="password" class="form-control" id="login-password" name="password">
                    <label for="login-password">Password</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember">
                    <label class="custom-control-label" for="login-remember-me">Recordarme</label>
                </div>
            </div>
        </div>

        <div class="form-group">

            {{ csrf_field() }}

            <button type="submit" class="btn btn-primary">
                <i class="si si-login mr-10"></i> Iniciar
            </button>

        </div>

    </form>

    <!-- END Sign In Form -->

@endsection
