<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('project', config('app.name', 'Laravel')) }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('global-vendor/notyf/notyf.css') }}">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        input[type="file"]#our-rut {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        label[for="our-rut"] {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background-color: #106BA0;
            display: inline-block;
            transition: all .5s;
            cursor: pointer;
            padding: 15px 40px !important;
            text-transform: uppercase;
            width: fit-content;
            text-align: center;

            border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
        }
    </style>

    @yield('css')

    @yield('js_header')

</head>

<body>

<!-- ======= Mobile nav toggle button ======= -->
<button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

<!-- ======= Header ======= -->
<header id="header" class="d-flex flex-column justify-content-center">

    <div class="text-center d-block d-sm-none">
        <img src="{{ asset('images/certisaas-logo-color.svg') }}" style="width: 40%; margin-bottom: 20px;" />
    </div>


    <nav class="nav-menu">
        <ul>
            <li class="active"><a href="#hero"><i class="bx bx-home"></i> <span>Inicio</span></a></li>
            <li><a href="#register"><i class="bx bx-user"></i> <span>Registrarme</span></a></li>
            <li><a href="#descripcion"><i class="bx bx-file-blank"></i> <span>Descripci&oacute;n</span></a></li>
            <li><a href="#caracteristicas"><i class="bx bx-book-content"></i> <span>Caracter&iacute;sticas</span></a></li>
            <li><a href="#beneficios"><i class="bx bx-server"></i> <span>Beneficios</span></a></li>
            <li><a href="#contacto"><i class="bx bx-envelope"></i> <span>Contacto</span></a></li>
        </ul>
    </nav><!-- .nav-menu -->

</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">

        <!--
        <h1>Brandon Johnson</h1>
        <p>I'm <span class="typed" data-typed-items="Designer, Developer, Freelancer, Photographer"></span></p>
        <div class="social-links">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
        -->

        <div class="row">

            <div class="col-12 col-md-12 col-lg-7 text-center">
                <img src="{{ asset('images/certisaas-logo-color.svg') }}" style="width: 50%; margin-bottom: 20px;" />
            </div>

            <div class="col-12 col-md-12 col-lg-5">

                <div class="card">
                    <div class="card-body text-left" style="background-color: #f7f7f7;">

                        <h4>Iniciar sesi&oacute;n</h4>

                        <form class="js-validation-signin px-30" action="{{ route('auth.user.login.verify') }}" method="post">

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material floating">
                                        <input type="email" class="form-control" id="login-username" name="email">
                                        <label for="login-username">Correo Electr&oacute;nico</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material floating">
                                        <input type="password" class="form-control" id="login-password" name="password">
                                        <label for="login-password">Password</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember">
                                        <label class="custom-control-label" for="login-remember-me">Recordarme</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">

                                {{ csrf_field() }}

                                <button type="submit" class="btn btn-primary">
                                    <i class="si si-login mr-10"></i> Iniciar
                                </button>

                                <div class="" style="margin-top: 10px;">
                                    <a class="link-effect text-muted mr-10 d-inline-block" href="#register">
                                        Registrarme
                                    </a>

                                    |

                                    <a class="link-effect text-muted mr-10 d-inline-block" href="{{ route('password.request') }}">
                                        ¿Olvido su contrase&ntilde;a?
                                    </a>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="register" class="about d-flex flex-column justify-content-center">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-12 col-md-7 text-center">
                    <img src="{{ asset('images/certisaas-logo-blanco.svg') }}" style="width: 50%; margin-bottom: 20px;" />
                </div>
                <div class="col-12 col-md-5">
                    <div class="card">
                        <div class="card-body text-left" style="background-color: #f7f7f7;">

                            <h4>Registrarme</h4>

                            <form class="js-validation-signin px-30" action="{{ route('auth.user.register.create') }}" method="post" enctype="multipart/form-data">

                                <div class="form-group row">
                                    <div class="col-12">

                                        <label for="signup-email">Correo Electr&oacute;nico</label>
                                        <input type="email" class="form-control" id="signup-email" name="email">

                                        @if ($errors->has('email'))
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12">

                                        <label for="our-rut" class="our-rut"><span>Cargar RUT</span></label>
                                        <input type="file" class="form-control" id="our-rut" name="rut">

                                        @if ($errors->has('rut'))
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('rut') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="termsChecked" name="terms">
                                            <label class="form-check-label" for="termsChecked">
                                                <a target="_blank" href="{{ asset("politicas_privacidad.pdf") }}">T&eacute;rminos y condiciones</a>
                                            </label>
                                        </div>

                                        @if ($errors->has('terms'))
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('terms') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form-group">

                                    {{ csrf_field() }}

                                    <button type="submit" class="btn btn-primary">
                                        <i class="si si-login mr-10"></i> Registrarme
                                    </button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Facts Section ======= -->
    <section id="descripcion" class="facts d-flex flex-column justify-content-center">

        <div class="logo-left">
            <img src="{{ asset('images/certisaas-logo-color.svg') }}" style="width: 50%;" />
        </div>

        <div class="container" data-aos="fade-up">

            <div class="section-title">

                <h2 style="padding-top: 15px; padding-bottom: 10px;">¿Que es Certisaas?</h2>

                <p class="text-justify">
                    Es una aplicación 100% web la cual permite a las empresas generar electrónicamente los distintos certificados tributarios y otros documentos, de conformidad con lo señalado en el Artículo 381 del Estatuto Tributario, Artículo 7 del Decreto 380 de 1996, Artículo 23 del Decreto 522 de 2003 y Artículos 31 y 33 del Decreto 4680 de 2008.
                </p>

                <p class="text-justify" style="margin-top: 10px;">
                    Una vez digitalizados estos certificados son almacenados en nuestro servidor y enviados vía e-mail en cuestión de segundos, generando importantes ahorros asociados a la emisión y administración de dichos documentos mejorando sensiblemente la velocidad y eficiencia en el proceso.
                </p>

                <h3 style="margin-top: 20px; margin-bottom: 15px;">¿Cuales certificados puede ser emitidos?</h3>

                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="count-box">
                            <i class="icofont-check"></i>
                            <p>
                                Certificado bimestral de IVA retenido (Rete IVA).
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="count-box">
                            <i class="icofont-check"></i>
                            <p>
                                Certificado bimestral de Impuesto Industria y Comercio retenido (Rete ICA).
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="count-box">
                            <i class="icofont-check"></i>
                            <p>
                                Certificado Anual de Retención en la Fuente.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="count-box">
                            <i class="icofont-check"></i>
                            <p>
                                Comprobantes de n&oacute;mina de pago y certificaciones laborales.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="count-box">
                            <i class="icofont-check"></i>
                            <p>
                                Certificado Anual de Ingresos y Retenciones.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="count-box">
                            <i class="icofont-check"></i>
                            <p>
                                Certificado Anual de Intereses por Préstamo de Vivienda.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <!---
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="icofont-simple-smile"></i>
                        <span data-toggle="counter-up">232</span>
                        <p>Happy Clients</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="icofont-document-folder"></i>
                        <span data-toggle="counter-up">521</span>
                        <p>Projects</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="icofont-live-support"></i>
                        <span data-toggle="counter-up">1,463</span>
                        <p>Hours Of Support</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="icofont-users-alt-5"></i>
                        <span data-toggle="counter-up">15</span>
                        <p>Hard Workers</p>
                    </div>
                </div>

            </div>
            -->

        </div>
    </section><!-- End Facts Section -->

    <!-- ======= Skills Section ======= -->
    <section id="caracteristicas" class="resume d-flex flex-column justify-content-center">

        <div class="logo-left">
            <img src="{{ asset('images/certisaas-logo-blanco.svg') }}" style="width: 50%;" />
        </div>

        <div class="container" data-aos="fade-up">

            <div class="section-title">

                <h2 class="text-white">Caracter&iacute;sticas de Certisaas</h2>

                <p class="text-justify pb-5 text-white">
                    Es una solución de fácil manejo, la cual simplifica y facilita la emisión y recepción de los distintos certificados tributarios a través de la web, la cual permite:
                </p>

                <div class="row">
                    <div class="col-lg-6 text-justify">
                        <div class="resume-item">
                            <p class="text-white">
                                Facilidad en el proceso de emisión de certificados.
                            </p>
                        </div>

                        <div class="resume-item">
                            <p class="text-white">
                                Alta capacidad de escalamiento: Puede procesar grandes volúmenes de documentos rápidamente.
                            </p>
                        </div>

                        <div class="resume-item">
                            <p class="text-white">
                                Para mayor seguridad, al momento de la emisión del certificado, el destinatario recibirá vía e-mail la notificación del envío con una contraseña de acceso, para garantizar que esta información solo podrá ser consultada por el conocedor de la misma.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6 text-justify">

                        <div class="resume-item">
                            <p class="text-white">
                                El usuario (Emisor-Receptor) tiene la posibilidad de exportar e importar (según sea el caso) los distintos certificados además de mantenerlos almacenados en el servidor.
                            </p>
                        </div>

                        <div class="resume-item">
                            <p class="text-white">
                                En caso de cambio del funcionario receptor, el programa automáticamente generará una nueva contraseña una vez sea notificado el nuevo e-mail de destino.
                            </p>
                        </div>

                        <div class="resume-item">
                            <p class="text-white">
                                Oportunidad en la generación y entrega de la información.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Skills Section -->

    <!-- ======= Resume Section ======= -->
    <section id="beneficios" class="resume d-flex flex-column justify-content-center">

        <div class="logo-left">
            <img src="{{ asset('images/certisaas-logo-color.svg') }}" style="width: 50%;" />
        </div>

        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Beneficios de Certisaas</h2>
                <p>

                </p>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="resume-item">
                        <p>
                            Mejora notablemente la eficiencia en el proceso, disminuyendo el número de llamadas recibidas, envíos por fax y correo, reducción de costos, almacenamiento digitalizado en nuestros servidores o servidor local.
                        </p>
                    </div>

                    <div class="resume-item">
                        <p>
                            Los cambios a los certificados por parte del emisor se pueden hacer en cuestión de segundos.
                        </p>
                    </div>

                    <div class="resume-item">
                        <p>
                            Facilita la carga de información en forma detallada a través de plantillas en Excel, donde es posible obtener la información por cada documento objeto de las distintas retenciones practicadas.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6">

                    <div class="resume-item">
                        <p>
                            Contiene reporte adicional detallado por documento en formatos Excel para que el usuario receptor pueda validar la información contenida en el certificado y compararla con sus registros contables.
                        </p>
                    </div>

                    <div class="resume-item">
                        <p>
                            No requiere imprimir, lo cual contribuye a la protección y conservación del medio ambiente. Los documentos son almacenados en nuestros servidores y permanecen allí por largos periodos de tiempo.
                        </p>
                    </div>

                    <div class="resume-item">
                        <p>
                            Por tratarse de un servicio 100% web no se requiere de instalaciones en los servidores locales del emisor ni del receptor del certificado.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Resume Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contacto" class="contact d-flex flex-column justify-content-center">

        <div class="logo-left">
            <img src="{{ asset('images/certisaas-logo-blanco.svg') }}" style="width: 50%;" />
        </div>

        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2 class="text-white">Contacto</h2>
            </div>

            <div class="row mt-1">

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body text-left">

                            <div class="info">

                                <div class="email">
                                    <i class="icofont-envelope"></i>
                                    <h4>Email:</h4>
                                    <p>info@saascolombia.com</p>
                                </div>

                                <div class="phone">
                                    <i class="icofont-phone"></i>
                                    <h4>Tels:</h4>
                                    <p>(1) 6407562 / 3124325633</p>
                                </div>

                                <div class="phone">
                                    <i class="icofont-whatsapp"></i>
                                    <h4>Whatsapp:</h4>
                                    <p>+57 - 3124325633</p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-8 mt-5 mt-lg-0">

                    <div class="card">

                        <div class="card-body text-left">

                            <form action="{{ route('frontoffice.home.contact') }}" method="post" role="form" class="php-email-form">

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="full_name" class="form-control" id="name" placeholder="Su nombre" data-rule="minlen:4" data-msg="El campo es obligatorio" />
                                        <div class="validate"></div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Su correo electr&oacute;nico" data-rule="email" data-msg="El campo es obligatorio" />
                                        <div class="validate"></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="company" class="form-control" id="company" placeholder="Nombre de la empresa" data-rule="minlen:4" data-msg="El campo es obligatorio" />
                                        <div class="validate"></div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" data-rule="minlen:4" data-msg="El campo es obligatorio" />
                                        <div class="validate"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="El campo es obligatorio" placeholder="Su Mensaje"></textarea>
                                    <div class="validate"></div>
                                </div>

                                <div class="mb-3">
                                    <div class="loading">Cargando...</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Su mensaje ha sido enviado con éxito</div>
                                </div>

                                <div class="text-center">
                                    <button type="submit">Enviar</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main>

<!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">

        <div class="copyright">
            &copy; Copyright <strong><span>Certisaas <?php date('Y') ?></span></strong> - Todos los derechos reservados.
        </div>

    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>
<div id="preloader"></div>

<script src="{{ asset('global-vendor/notyf/notyf.js') }}"></script>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/vendor/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/vendor/typed.js/typed.min.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script type="application/javascript">
    jQuery('input[type=file]').change(function(){
        var filename = jQuery(this).val().split('\\').pop();
        console.log(filename);
        jQuery('label.our-rut').find('span').html(filename);
    });
</script>


@if(Session::has('alert_error'))
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new Notyf({delay:3000}).error('{!! Session('alert_error') !!}');
        });
    </script>
@endif

@if(Session::has('alert_success'))
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new Notyf({delay:3000}).success('{!! Session('alert_success') !!}');
        });
    </script>
@endif

@yield('js')
@yield('modals')
</body>
</html>
