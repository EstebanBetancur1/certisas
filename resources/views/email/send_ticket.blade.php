@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
            <p>La empresa <strong><?php echo $request['provider_name'] ?></strong> te ha generado un tikect</p>
            <p>Para ver el ticket haga click en el siguiente enlace: <a href="https://v4.certisaas.com/">Inicia sesión</a></p>
        </div>
    </section>
@endsection