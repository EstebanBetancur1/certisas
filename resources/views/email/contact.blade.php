@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            Hola, <strong>{!! $post["full_name"] !!}</strong>

            <p>Le agredecemos el tiempo que le ha tomado enviar este mensaje. </p>
            <p>A la brevedad le enviaremos nuestra respuesta.</p>

            <p><a href="{{ route("frontoffice.home.index") }}">Volver a Certisaas</a></p>
        </div>
    </section>
@endsection