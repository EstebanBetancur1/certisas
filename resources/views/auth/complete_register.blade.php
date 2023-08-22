@extends('layouts.auth')

@section('content')

    <div class="login-title">
        <h3 class="black">Iniciar sesión</h3>
    </div>
    <form action="{{ route('auth.complete.register.update', ['token' => $item->token_pre_register]) }}" method="post">

        <div class="cs-field field">
            <label for="signup-fullname" class="bold">Nombre completo</label>
            <input type="text" placeholder="Escriba su nombre" id="signup-fullname" name="full_name" required>
        </div>
        @if ($errors->has('full_name'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('full_name') }}</strong>
            </span>
        @endif

        <div class="cs-field field">
            <label for="signup-phone" class="bold">Teléfono</label>
            <input type="text" placeholder="Escriba su teléfono" id="signup-phone" name="phone" required>
        </div>
        @if ($errors->has('phone'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif

        <div class="cs-field field">
            <label for="signup-password" class="bold">Contraseña</label>
            <input type="password" placeholder="Contraseña" id="signup-password" name="password" required>
        </div>
        @if ($errors->has('password'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

        <div class="cs-field field">
            <label for="signup-password-confirm" class="bold">Confirmación de contraseña</label>
            <input type="password" placeholder="Contraseña" id="signup-password-confirm" name="password_confirmation" required>
        </div>
        @if ($errors->has('password_confirmation'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif

        <div class="login-terminos">
            <input class="" type="hidden" value="1" id="termsChecked" name="terms">
            <span>Al hacer clic en Registrarse, indicas que has leído y aceptas los <a href="{{ asset("politicas_privacidad.pdf") }}">Términos y condiciones</a></span>
        </div>
        @if ($errors->has('terms'))
            <span class="text-danger" role="alert">
                <strong>{{ $errors->first('terms') }}</strong>
            </span>
        @endif

        <button type="submit" class="login-enviar cs-btn btn-blue">Registrarme</button>

    </form>

@endsection
