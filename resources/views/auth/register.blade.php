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
    <form class="js-validation-signin px-30" action="{{ route('auth.user.register.create') }}" method="post" enctype="multipart/form-data">

        <div class="form-group row">
            <div class="col-12">

                <label for="signup-email">Correo Electr&oacute;nico</label>
                <input type="email" class="form-control" id="signup-email" name="email">

                @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">

                <label for="signup-rut">Cargar RUT</label>
                <input type="file" class="form-control" id="signup-rut" name="rut">

                @if ($errors->has('rut'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('rut') }}</strong>
                    </span>
                @endif

            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="termsChecked" name="terms">
                    <label class="form-check-label" for="termsChecked">
                        T&eacute;rminos y condiciones
                    </label>
                </div>

                @if ($errors->has('terms'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('terms') }}</strong>
                    </span>
                @endif

            </div>
        </div>

        <div class="form-group">

            {{ csrf_field() }}

            <button type="submit" class="btn btn-primary">
                <i class="si si-login mr-10"></i> Registrarme
            </button>

            <div class="block-content bg-body-light">
                <div class="form-group text-center">
                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                        <i class="fa fa-book text-muted mr-5"></i> Leer t&eacute;rminos y condiciones
                    </a>
                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route("auth.user.login.show") }}">
                        <i class="fa fa-user text-muted mr-5"></i> Iniciar sesi&oacute;n
                    </a>
                </div>
            </div>

        </div>

    </form>

@endsection