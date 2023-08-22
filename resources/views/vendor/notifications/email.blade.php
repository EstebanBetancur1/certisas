@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            <p><strong>Hola,</strong></p>

            <p>Has solicitado un cambio de contrase&ntilde;a.</p>
            <p>Por favor haga clic sobre el siguiente enlace.</p>

            <p>
                <a href="{{ $actionUrl }}">¡Cambiar mi contrase&ntilde;a ahora!</a>
            </p>

            <p>Si usted no ha solicitado esta acci&oacute;n por favor ignore este mensaje.</p>

        </div>
    </section>
@endsection