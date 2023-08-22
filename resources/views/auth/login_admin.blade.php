@extends('layouts.auth')

@section('content')

    <div class="login-logo">
        <img class="logo" src="{{ asset('assets/img/logo.svg') }}" alt="">
    </div>

    <div class="login-title">
        <h3 class="black">Iniciar sesión</h3>
    </div>
    <form action="{{ route('auth.admin.login.verify') }}" method="post">
        <div class="cs-field field">
          <label for="usuario" class="bold">Usuario</label>
          <input type="text" placeholder="Escriba su usuario" id="login-username" name="email" required>
        </div>
        <div class="cs-field field">
          <label for="contraseña" class="bold">Contraseña</label>
          <input type="password" placeholder="Contraseña" id="login-password" name="password" required>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="login-enviar cs-btn btn-blue">Iniciar sesión</button>

    </form>

@endsection
