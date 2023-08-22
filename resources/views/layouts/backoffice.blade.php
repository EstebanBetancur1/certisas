<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Certisaas | Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('global-vendor/notyf/notyf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/font/css/awesome.min.css') }}">

    @yield('css')
    @yield('js_header')
</head>
<body>
    <main>
        <section class="main-container">
            <aside>
                <a href="{{ route('backoffice.templates.index') }}" class="home-link"><img class="logo" src="{{ asset('assets/img/certisaas-logo-color.svg') }}" alt=""></a>
                <div class="nav_links">
                    <a href="{{ route('backoffice.templates.index') }}">
                        <div class="link {{ (request()->segment(2) == 'templates') ? "active" : "" }} " >
                            <i class="icon-issue"></i>
                            <span>Plantillas</span>
                        </div>
                    </a>
                    <a href="{{ route('backoffice.emissions.my.certificates') }}" class="">
                        <div class="link {{ (request()->segment(3) == 'my-certificates') ? "active" : "" }}">
                            <i class="icon-certify"></i>
                            <span>Mis certificados</span>
                        </div>
                    </a>
                    <a href="{{ route('backoffice.company.show') }}">
                        <div class="link {{ (request()->segment(2) == 'company') ? "active" : "" }}">
                            <i class="icon-config"></i>
                            <span>Administración</span>
                        </div>
                    </a>

                    <a href="{{ route('backoffice.emissions.processed') }}">
                        <div class="link {{ (request()->segment(2) == 'declarations') ? "active" : "" }}">
                            <i class="icon-file"></i>
                            <span>Emisiones</span>
                        </div>
                    </a>

                    <a href="{{ route('backoffice.declarations.index') }}">
                        <div class="link {{ (request()->segment(2) == 'declarations') ? "active" : "" }}">
                            <i class="icon-statement"></i>
                            <span>Declaraciones</span>
                        </div>
                    </a>

                </div>
                <div class="menu-footer">
                    <a href="{{ route('auth.user.logout') }}" class="log-out">
                        <i class="icon-log-out"></i>
                        <span>Cerrar sesión</span>
                    </a>
                </div>

            </aside>
            <div class="page-content">
                <div class="header">
                    <div class="role">
                        <button class="menu-btn"></button>
                        <a href="{{ route('backoffice.templates.index') }}" class="home-link d-flex d-lg-none mt-0"><img class="logo" src="{{ asset('assets/img/logo.svg') }}" alt=""></a>
                        <div class="cs-field select d-none d-lg-flex">
                            <div class="select-container">
                                <select class="form-control companies-select-2" id="s-company" data-url="{{ route('backoffice.templates-json') }}">
                                    <option value="">{{__('Manager')}}</option>
                                    @foreach(session("myCompanies", []) as $myCompany)
                                        <option value="{{ $myCompany["id"] }}"{{$myCompany['id']==session('companyID')?' selected':''}}>{!! $myCompany["name"] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="company-logo">

                        @if(session()->has('companyLogo'))
                            <img src="{{ asset("upload/companies") . '/' . session('companyLogo') }}" alt="">
                        @else
                            <img src="{{ asset('images/icono-company.png') }}" alt="">
                        @endif

                    </div>

                   <div class="global-stats">
                        <div class="stat-item">
                            <img src="{{ asset('assets/img/empresas.svg') }}" alt="">
                            <div>
                                <h5>Total empresas</h5>
                                <span>{{session("totalCompanies")}}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <img src="{{ asset('assets/img/usuarios.svg') }}" alt="">
                            <div>
                                <h5>Usuarios registrados</h5>
                                <span>{{session("totalUsers")}}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <img src="{{ asset('assets/img/certificados.svg') }}" alt="">
                            <div>
                                <h5>Certificados emitidos</h5>
                                <span>{{session("totalEmissions")}}</span>
                            </div>
                        </div>
                   </div>
                   <div class="header-actions">
                        <button type="button" data-buttonmodal="accessModal" class="modal-btn" data-toggle="tooltip" data-placement="bottom" title="Solicitar acceso"><i class="icon-key"></i></button>
                        {{-- <button type="button" data-toggle="tooltip" data-placement="bottom" title="Mis tickets"><i class="icon-mailbox-2"></i><span>2</span></button> --}}
                        <a href="{{ route("backoffice.tickets.my") }}" data-toggle="tooltip" data-placement="bottom" title="Mis tickets"><i class="icon-mailbox-2"></i></a>
                       <div class="dropdown">
                           <button type="button" class="dropdown-toggle" style="width:auto;height:auto" id="profile-dropdown" data-toggle="dropdown">
                               <div class="profile-option img-fit">
                                   <!--
                                   <img onclick="document.getElementById('profile-dropdown').click()" src="https://images.unsplash.com/photo-1563306406-e66174fa3787?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGdpcmx8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    -->

                                   <img onclick="document.getElementById('profile-dropdown').click()" src="{{ asset("images/avatar.jpg") }}" style="vertical-align: initial!important" alt="">

                               </div>
                           </button>
                           <ul class="dropdown-menu dropdown-menu-right">
                               <li style="cursor:pointer" onclick="window.location.replace('{{ route("backoffice.account.myAccount") }}')" class="dropdown-item"><i class="icon-user"></i>{{__('My profile')}}</li>
                               <li style="cursor:pointer" onclick="window.location.replace('{{ route('auth.user.logout') }}')" class="dropdown-item"><i class="icon-log-out"></i>{{__('Logout')}}</li>
                           </ul>
                       </div>
                        {{--<div class="profile-option img-fit">
                            <img src="https://images.unsplash.com/photo-1563306406-e66174fa3787?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTF8fGdpcmx8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60" alt="">
                        </div>
                        <div class="menu">
                            <a href="{{ route("backoffice.account.myAccount") }}" class="link">
                               Mi perfil <i class="icon-user"></i>
                            </a>
                            <a href="{{ route('auth.user.logout') }}" class="link">
                                Salir <i class="icon-log-out"></i>
                             </a>
                        </div>--}}
                   </div>
                </div>

                    @yield("content")

            </div>
        </section>
    </main>

    <!-- Modal -->

    <div class="cs-modal-container" data-modal="accessModal">
        <div class="modal-shade"></div>
        <div class="cs-modal sm-modal">
            <div class="cs-modal-content">
                <div class="modal_header">
                    <h5 class="m-title" id="staticBackdropLabel">Seleccione una empresa</h5>

                    <button class="close-modal"><i class="icon-close"></i></button>

                </div>
                <div class="modal_body">

                    <form class="js-validation-signup" action="{{ route('backoffice.request.access') }}" method="post" enctype="multipart/form-data">

                                <div class="cs-field field">
                                    <label for="signup-rut">Cargar RUT</label>
                                    {{-- <input type="file" class="form-control" id="signup-rut" name="rut"> --}}
                                    <div class="upload">
                                        <input name="rut" id="signup-rut" type="file" class="upload" required accept="application/pdf, .doc,.docx,application/msword">
                                        <label for="signup-rut">Cargar archivo</label>
                                    </div>
                                    @if ($errors->has('rut'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('rut') }}</strong>
                                    </span>
                                @else
                                    <span class="text-info" role="alert">
                                        <strong>Si la empresa es nueva debe cargar el RUT (pdf).</strong>
                                    </span>
                                @endif
                                </div>


                                <div class="cs-field field">
                                    <label for="signup-nit">Nit</label>
                                    <input type="text" class="form-control" id="signup-nit" name="nit" placeholder="Ej: 123456789">

                                @if ($errors->has('nit'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('nit') }}</strong>
                                    </span>
                                @else
                                    <span class="text-info" role="alert">
                                        <strong>Si la empresa ya existe solo debe ingresar el NIT.</strong>
                                    </span>
                                @endif
                                </div>

                                {{ csrf_field() }}

                                <button type="submit" class="cs-btn btn-blue ml-auto">
                                    Enviar
                                </button>
                    </form>

                </div>



            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('global-vendor/notyf/notyf.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>

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

    {{--<script>
        /*$(function () {
            let inputSelect2 = $('.companies-select-2').select2(
                {
                    width: '300px'
                }
            );

            inputSelect2.on(".companies-select-2 select2:select", function (e) {
                var data = e.params.data;

                if(data !== null && data !== undefined){
                    window.location = "{{ route('backoffice.switch.company') }}?id="+data.id;
                    return;
                }

                new Notyf({delay:3000}).error('Ocurrio un error, por favor intente nuevamente.');
            });
        })*/
    </script>--}}

    @yield('js')
    @yield('modals')

  </body>
</html>
