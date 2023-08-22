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
                        <div class="login-logo">
                            <img class="logo" src="{{ asset('assets/img/logo.svg') }}" alt="">
                        </div>
                        <div class="login-title">
                            <h3 class="black">{{__('Sign In')}}</h3>
                        </div>
                        <form action="{{ route('auth.user.login.verify') }}" id="login-form" method="post" novalidate>
                            <div class="cs-field field">
                                <label for="login-email" class="bold">{{__('E-Mail Address')}}</label>
                                <input type="text" placeholder="{{__('Enter your email')}}" id="login-email" name="email" required>
                            </div>
                            <div class="cs-field field">
                                <label for="login-password" class="bold">{{__('Password')}}</label>
                                <input type="password" placeholder="{{__('Enter your password')}}" id="login-password" name="password" required>
                            </div>
                            @csrf
                            <div class="alert alert-info d-none"><span class="icofont-spin icofont-spinner-alt-2 me-2"></span><span>{{__('Loading...')}}</span></div>
                            <div class="d-flex">
                                <div class="form-check d-inline-flex align-items-center" style="flex: 1 1 0;">
                                    <input class="form-check-input" type="checkbox" value="true" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">{{__('Remember Me')}}</label>
                                </div>
                                <button type="submit" class="login-enviar cs-btn btn-blue">{{__('Login')}}</button>
                            </div>
                            <div class="login-secundary-actions"><a id="registrarme" href="#">{{__('Register')}}</a>  |  <a href="#" class="modal-btn" data-buttonmodal="password">{{__('Forgot Your Password?')}}</a></div>
                        </form>
                    </div>
                </div>

                <div id="login-img" class="col-md-5 p-0 h-100">
                    <div class="img-fit">
                      <video width="320" height="240" autoplay loop muted poster="{{ asset('assets/img/login-video.jpg') }}">
                        <source src="{{ asset('assets/img/video-login.mp4') }}" type="video/mp4">
                        <source src="{{ asset('assets/img/video-login.webm') }}" type="video/webm">
                        <source src="{{ asset('assets/img/video-login.ogv') }}" type="video/ogv">
                        Your browser does not support the video tag.
                      </video>
                      <!-- <img src="images/certisaas.jpg" alt=""> -->
                    </div>
                </div>

            </div>
        </div>
        <div id="c2" class="container move2">
            <div class="row overflow-hidden">
              <div class="col-md-7 p-0">
                <div id="registro" class="login-wrapper">
                  <div class="login-logo">
                    <img class="logo" src="images/logo.svg" alt="">
                  </div>
                  <div class="login-title">
                    <h3 class="black">{{__('Register')}}</h3>
                  </div>

                    <form class="js-validation-signin px-30" id="signup-form" action="{{ route('auth.user.register.create') }}" method="post" enctype="multipart/form-data" novalidate>
                        <div class="cs-field field">
                            <label for="signup-email" class="bold">{{__('E-Mail Address')}}</label>
                            <input type="email" placeholder="{{__('Enter your email')}}" id="signup-email" name="email" required>
                        </div>
                        <div class="cs-field field">
                            <label for="our-rut" class="bold">{{__('Upload RUT document')}}</label>
                            <div class="upload" id="signup-rut">
                                <input name="rut" id="our-rut" type="file" class="upload" required accept="application/pdf">
                                <label for="our-rut">{{__('Select a file')}}</label>
                            </div>
                        </div>
                        <div class="login-terminos">
                            <input class="" type="hidden" value="1" id="termsChecked" name="terms">
                            <span>{!! __("By clicking \"Register\", you accept our :terms_and_conditions", ['terms_and_conditions' => '<a href="'.asset("politicas_privacidad.pdf").'" target="_blank">'.__('Terms and Conditions').'</a>']) !!}</span>
                        </div>
                        @csrf
                        <div class="alert alert-info d-none"><span class="icofont-spin icofont-spinner-alt-2 me-2"></span><span>{{__('Loading...')}}</span></div>
                        <button type="submit" class="login-rut cs-btn btn-blue">{{__('Register')}}</button>
                        <div class="login-secundary-actions">
                        <a id="iniciar" href="#">{{__('Sign In')}}</a>
                        </div>
                    </form>
                </div>
              </div>

              <div id="login-img" class="col-md-5 p-0 h-100">
                <div class="img-fit">
                  <video width="320" height="240" autoplay loop muted>
                    <source src="{{ asset('assets/img/video.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
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
    </section>
    <div class="cs-modal-container" data-modal="password">
        <div class="modal-shade"></div>
        <div class="cs-modal sm-modal">
            <div class="cs-modal-content">
                <div class="modal_header">
                  <h4 class="m-title">{{__('Recover your password')}}</h4>
                  <button class="close-modal"><i class="icon-close"></i></button>
                </div>
                <form id="recover-form" action="{{route('password.email')}}" method="post" novalidate>
                  <div class="cs-field field">
                    <label for="recover-email">{{__('Enter your email and we\'ll send you a link to reset your password.')}}</label>
                    <input type="email" id="recover-email" name="email" placeholder="{{__('E-Mail Address')}}" required>
                  </div>
                    @csrf
                    <div class="alert alert-info d-none"><span class="icofont-spin icofont-spinner-alt-2 me-2"></span><span>{{__('Loading...')}}</span></div>
                  <button class="cs-btn btn-blue ml-auto">{{__('Send')}}</button>
                </form>
            </div>
        </div>
    </div>

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
{{-- <script src="assets/js/main.js"></script> --}}

<script src="{{ asset('assets/js/custom.js') }}"></script>

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
<script src="{{mix('/js/login.js')}}"></script>
<script src="{{mix('/js/register.js')}}"></script>
<script src="{{mix('/js/recover-password.js')}}"></script>
@yield('js')
@yield('modals')
</body>
</html>
