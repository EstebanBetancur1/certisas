@extends('layouts.auth')

@section('content')

    <form class="js-validation-signup" action="{{ route('auth.complete.register.update', ['token' => $item->token_pre_register]) }}" method="post">

        @csrf

        <div class="block block-themed block-rounded block-shadow">

            <div class="block-header bg-primary-light">
                <h3 class="block-title">Registro de usuario</h3>
            </div>

            <div class="block-content">

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-fullname">Nombre completo</label>
                        <input type="text" class="form-control" id="signup-fullname" name="full_name" placeholder="">
                        @if ($errors->has('full_name'))
                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('full_name') }}</strong>
                                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-phone">Tel&eacute;fono</label>
                        <input type="text" class="form-control" id="signup-phone" name="phone" placeholder="">
                        @if ($errors->has('phone'))
                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-password">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="signup-password" name="password" placeholder="********">
                        @if ($errors->has('password'))
                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-password-confirm">Confirmaci&oacute;n de contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="signup-password-confirm" name="password_confirmation" placeholder="********">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="termsChecked" name="terms">
                            <label class="form-check-label" for="termsChecked">
                                <a target="_blank" href="{{ asset("politicas_privacidad.pdf") }}">T&eacute;rminos y condiciones</a>
                            </label>
                        </div>

                        @if ($errors->has('terms'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('terms') }}</strong>
                            </span>
                        @endif

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus mr-10"></i> Registrarme
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
