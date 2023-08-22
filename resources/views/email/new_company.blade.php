@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            <p>Se ha registrado una nueva empresa con nombre: <strong>{!! $request->name !!}</strong> y nit <strong>{!! $request->nit !!}</strong> </p>

            <p><a href="{{ route("auth.admin.login.show") }}">Iniciar sesion</a> para validar la empresa.</p>
        </div>
    </section>
@endsection