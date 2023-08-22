@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">

            <p>Le damos la bienvenida a nuestro sistema de certificados. </p>
            <p>Usted ha sido dado de alta en le empresa {{ $nameCompany }}. </p>
            <p>Por favor, ingrese con los datos de accesos:</p>

            <p>Usuario: <strong>{{ $user->email }}</strong></p>
            <p>Contraseña: <strong>{{ $password }}</strong></p>
        </div>
    </section>
@endsection