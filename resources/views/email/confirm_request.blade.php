@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">

            <p>Hemos aprobado su solicitud de registro con los siguientes datos: </p>

            <div>NIT: {!! $company->nit !!}</div>
            <div>Empresa: {!! $company->name !!}</div>

            <p>
                Por favor ingrese al siguiente enlace: <a href="{{ route("auth.complete.register", ["token" => $user->token_pre_register]) }}">Completar registro</a> para finalizar el proceso.
            </p>

            <br />

            <p>Gracias.</p>
            <p>Certisaas</p>

        </div>
    </section>
@endsection