<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('project', config('app.name', 'Laravel')) }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('global-vendor/notyf/notyf.css') }}">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}">

    @yield('css')

    @yield('js_header')

</head>

<body>

    <section id="login">
        <div class="container" id="c1">
            <div class="row">
                <div class="col-md-7 p-0">
                    <div id="registro" class="login-wrapper">
                        {{-- <div class="login-logo">
                            <img class="logo" src="{{ asset('assets/img/logo.svg') }}" alt="">
                        </div> --}}

                        @yield("content")

                    </div>
                </div>
                <div id="login-img" class="col-md-5 p-0">
                    <div class="img-fit">
                        <img src="{{ asset('assets/img/certisaas.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-wrapper">
            <ul class="footer-links">
              <li><a href="">¿Quienes somos?</a></li>
              <li><a href="">Servicios</a></li>
              <li><a href="">Contacto</a></li>
            </ul>
            <div class="copyright"><span class="black">Certisaas</span> | Todos los derechos reservados ®</div>
        </div>
    </section><!-- End Hero -->




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
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="{{ asset('assets/js/custom.js') }}"></script>

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
