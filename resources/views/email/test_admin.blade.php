@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            Hola, Test Test</strong>

            <p>Esto es una prueba de envio de correo </p>

            <p><a href="{{ route("frontoffice.home.index") }}">Volver a Certisaas</a></p>
        </div>
    </section>
@endsection