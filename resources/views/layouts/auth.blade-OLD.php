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
            <li class="active"><a href="{{ route("frontoffice.home.index") }}"><i class="bx bx-home"></i> <span>Inicio</span></a></li>
        </ul>
    </nav><!-- .nav-menu -->

</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">

        <div class="row">

            <div class="col-12 col-md-12 col-lg-7 text-center align-middle">
                <img src="{{ asset('images/certisaas-logo-color.svg') }}" style="width: 50%; margin-bottom: 20px;" />
            </div>

            <div class="col-12 col-md-12 col-lg-5">

                <div class="card">
                    <div class="card-body text-left" style="background-color: #f7f7f7;">

                        @yield("content")

                    </div>
                </div>

            </div>
        </div>

    </div>
</section><!-- End Hero -->


<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">

        <div class="copyright">
            &copy; Copyright <strong><span>Certisaas 2020</span></strong> - Todos los derechos reservados.
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
<script src="{{ asset('assets/js/main.js') }}"></script>

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
