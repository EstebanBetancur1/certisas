@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            <p>Felicitaciones su cuenta ha sido verificada para la empresa <strong>{!! $company->name !!}</strong>

            <p><a href="https://v4.certisaas.com/">Iniciar sesion</a></p>
        </div>
    </section>
@endsection