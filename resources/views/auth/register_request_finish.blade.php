@extends('layouts.auth')

@section('content')

    <div class="block block-themed block-rounded block-shadow">

        <div class="block-header bg-primary-light">
            <h3 class="block-title">Solicitud finalizada</h3>
        </div>

        <div class="block-content">

            @if(session("status_finish") === "ok")
                <div class="alert alert-success">La solicitud ha sido generada con &eacute;xito. Usted recibir&aacute; un correo en cuanto sea confirmada su solicitud.</div>
            @else
                <div class="alert alert-danger">Ocurrio un error al generar la solicitud, por favor intente m&aacute;s tarde.</div>
            @endif

        </div>

    </div>

@endsection