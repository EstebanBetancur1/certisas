@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            <p>Hola, <strong>{{ $request['agent_name'] }}</strong></p>
            <p>Te informamos que la empresa <strong>{{ $request['provider_name'] }}</strong> ha generado un ticket de emisión con el número <strong>{{ $request['emission_id'] }}</strong></p>
            <p>Para el certificado: <strong>{{ $request['subject'] }}<strong></p>
            <p>Para acceder al ticket y revisar los detalles, simplemente haz clic en el siguiente enlace: <a href="https://v4.certisaas.com/">Iniciar sesión</a></p>
            <p>Número de ticket: <strong>{{ $request['ticket'] }}</strong></p>
        </div>
    </section>
@endsection
