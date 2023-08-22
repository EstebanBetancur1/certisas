@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">

            <p>Hemos recibido  su solicitud de registro con los siguientes datos:. </p>

            <div>NIT: {!! $company->nit !!}</div>
            <div>Empresa: {!! $company->name !!}</div>
            <div>Email: {!! $company->email !!}</div>

            <p>Por favor, confime su cuenta de correo haciendo clic en el siguiente enlace:</p>

            <p>
                <a href="{{ route("auth.request.email.confirmation", [ "token" => $company->token ]) }}">Confirmar mi correo</a>
            </p>

            <p>
                Una vez sea aprobado el ingreso a la plataforma le estaremos enviando un email de aprobación para que continue con el proceso de registro.
            </p>

            <br />

            <p>Gracias.</p>
            <p>Certisaas</p>

        </div>
    </section>
@endsection