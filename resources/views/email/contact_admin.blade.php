@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            Hemos recibido un mensaje de: <strong>{!! $post["full_name"] !!}</strong>

            <p>E-mail: {{ $post["email"] }}</p>
            <p>Mensaje: {{ $post["message"] }}</p>
            <p>Asunto: {{ $post["subject"] }}</p>
            <p>Empresa: {{ $post["company"] }}</p>

        </div>
    </section>
@endsection