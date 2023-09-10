@extends('layouts.email')

@section('content')
    <section class="row">
        <div class="pull-left">
        	<p>Señores: </p>

        	<p>{!! $provider['name'] !!}</p>

        	<p>
        		De conformidad con lo señalado en el Artículo 381 del Estatuto Tributario, Artículo 7 del Decreto 380 de 1996, Artículo 23 del Decreto 522 de 2003 y Artículos 31 y 33 del Decreto 4680 de 2008, en el siguiente link podrá descargar sus certificados tributarios. 
        	</p>

        	<p>
        		<a href="http://v4.certisaas.com/">www.v4.certisaas.com</a>
        	</p>

        	<p>
        		Al ingresar podrá usted seleccionar el certificado y bajarlo en formato PDF.
        	</p>

            <p>
            	En caso que usted no sea la persona indicada para recibir esta información, le solicitamos reenviarla a la persona en su organización encargada de contabilidad ó impuestos. 
            </p>

            <p><a href="{{ route("auth.user.login.show") }}">Iniciar sesion</a>.</p>
        </div>
    </section>
@endsection