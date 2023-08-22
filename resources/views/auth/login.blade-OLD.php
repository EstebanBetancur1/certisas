@extends('layouts.auth')

@section('content')

    <h4>Iniciar sesi&oacute;n</h4>

    <form class="js-validation-signin px-30" action="{{ route('auth.user.login.verify') }}" method="post">

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

        <div class="form-group" style="margin-bottom: 0;">

            {{ csrf_field() }}

            <button type="submit" class="btn btn-primary">
                <i class="si si-login mr-10"></i> Iniciar
            </button>

            <div class="" style="margin-top: 10px;">
                <a class="link-effect text-muted mr-10 d-inline-block" href="{{ route("frontoffice.home.index") }}#register">
                    Registrarme
                </a>

                |

                <a class="link-effect text-muted mr-10 d-inline-block" href="{{ route('password.request') }}">
                    ¿Olvido su contrase&ntilde;a?
                </a>

            </div>
        </div>

    </form>

@endsection
