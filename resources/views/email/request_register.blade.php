@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            <p>El usuario con nombre <strong>{!! $user->full_name !!}</strong> y correo electr&oacute;nico <strong>{!! $user->email !!}</strong> </p>
            <p>Ha solicitado acceso a la empresa: <strong>{!! $company->name !!}</strong></p>

            <p><a href="{{ route("auth.user.login.verify") }}">Iniciar sesion</a> para validar la cuenta.</p>
        </div>
    </section>
@endsection