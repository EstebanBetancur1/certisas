<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ setting('project', config('app.name', 'Laravel')) }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="{{ asset('global-vendor/theme-panel/css/codebase.min.css') }}">
        <link rel="stylesheet" href="{{ asset('global-vendor/theme-panel/css/themes/corporate.css') }}">

        <link rel="stylesheet" href="{{ asset('global-vendor/notyf/notyf.css') }}">
        <link rel="stylesheet" href="{{ asset('backoffice-assets/css/style.css') }}">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

        @yield('css')

        @yield('js_header')

    </head>

    <body>
        
        <div id="page-container" class="sidebar-inverse side-scroll page-header-fixed page-header-glass page-header-inverse main-content-boxed">

            
            <!-- Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow bg-black-op-10">
                        <div class="content-header-section text-center align-parent">
                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Sidebar -->

                            <!-- Logo -->
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="{{ route("backoffice.account.dashboard") }}">
                                    <img src="{{ asset('images/certisaas-logo-blanco.svg') }}" style="width: 100%" class="img-fluid" />
                                </a>
                            </div>
                            <!-- END Logo -->
                        </div>
                    </div>
                    <!-- END Side Header -->

                    <!-- Side Main Navigation -->
                    <div class="content-side content-side-full">
                        <!--
                        Mobile navigation, desktop navigation can be found in #page-header

                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        -->
                        <ul class="nav-main">
                            
                            <li>
                                <a class="active" href="db_corporate.html"><i class="si si-rocket"></i>Dashboard </a>
                            </li>

                            @if(in_array(request()->segment(2), ['emissions', 'templates']))

                                <li class="@if(in_array(request()->segment(2), ['templates'])) open @endif">
                                    <a class="{{ (request()->segment(2) == 'templates') ? "active" : "" }}" href="{{ route('backoffice.templates.index') }}">
                                        <i class="fa fa-file-excel-o"></i> <span class="sidebar-mini-hide">Plantillas</span>
                                    </a>
                                </li>

                                <li class="@if(in_array(request()->segment(2), ['emissions'])) open @endif">
                                    <a class="{{ (request()->segment(2) == 'emissions') ? "active" : "" }}" href="{{ route('backoffice.emissions.processed') }}">
                                        <i class="fa fa-file-excel-o"></i> <span class="sidebar-mini-hide">Emisiones Generadas</span>
                                    </a>
                                </li>

                            @endif

                            @if((int)session("companyUserType") === 1)

                                <li>
                                    <a class="{{ (request()->segment(2) == 'assistants') ? "active" : "" }}" href="{{ route('backoffice.assistants.index') }}">
                                        <i class="fa fa-users"></i> <span class="sidebar-mini-hide">Usuarios</span>
                                    </a>
                                </li>

                            @endif

                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="{{ route("backoffice.account.myAccount") }}">Mis Tickets</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('auth.user.logout') }}">Tickets de empresa</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <!-- END Side Main Navigation -->
                </div>
                <!-- Sidebar Content -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Logo -->
                        <div class="content-header-item mr-5">
                            <a class="link-effect font-w600" href="{{ route("backoffice.account.dashboard") }}">
                               <img src="{{ asset('images/certisaas-logo-blanco.svg') }}" class="img-logo img-fluid" />
                            </a>
                        </div>
                        <!-- END Logo -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="content-header-section">
                        <!-- Header Navigation -->

                        <ul class="nav-main-header">

                            @if(in_array(request()->segment(2), ['emissions', 'templates', 'declarations']) && ! in_array(request()->segment(3), ['my-certificates']))

                                <li class="@if(in_array(request()->segment(2), ['templates'])) open @endif">
                                    <a class="{{ (request()->segment(2) == 'templates') ? "active" : "" }}" href="{{ route('backoffice.templates.index') }}">
                                        <i class="fa fa-file-excel-o"></i> <span class="sidebar-mini-hide">Plantillas</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="nav-submenu {{ (in_array(request()->segment(2), ['emissions', 'declarations'])) ? "active" : "" }}" data-toggle="nav-submenu" href="#">
                                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                    </a>

                                    <ul>
                                        <li>
                                            <a href="{{ route("backoffice.emissions.processed") }}">Emisiones</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('backoffice.declarations.index') }}">Declaraciones</a>
                                        </li>
                                    </ul>

                                </li>

                            @endif

                            <li>
                                <a class="nav-submenu {{ (request()->segment(2) == 'tickets' && in_array(request()->segment(3), ['company', 'my'])) ? "active" : "" }}" data-toggle="nav-submenu" href="#">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route("backoffice.tickets.my") }}">Mis Tickets</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('backoffice.tickets.company') }}"> Tickets de empresa</a>
                                    </li>
                                </ul>
                            </li>


                            @if((int)session("companyUserType") === 1)

                                <li>
                                    <a class="nav-submenu {{ (request()->segment(2) == 'assistants' || request()->segment(2) == 'company') ? "active" : "" }}" data-toggle="nav-submenu" href="#">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route("backoffice.company.show") }}">Empresa</a>
                                        </li>

                                        <li>
                                            <a href="{{ route("backoffice.assistants.index") }}">Usuarios</a>
                                        </li>
                                    </ul>
                                </li>

                            @endif

                            <li>
                                <a class="nav-submenu {{ (request()->segment(2) == 'my-account') ? "active" : "" }}" data-toggle="nav-submenu" href="#"><i class="si si-user"></i></a>
                                <ul>
                                    <li>
                                        <a href="{{ route("backoffice.account.myAccount") }}">Perfil</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('auth.user.logout') }}">Salir</a>
                                    </li>
                                </ul>
                            </li>

                            @if((request()->segment(2) != 'dashboard'))
                                <li>
                                    <a class="{{ (request()->segment(2) == 'dashboard') ? "active" : "" }} text-center btn-home" data-toggle="tooltip" data-placement="bottom" title="Volver al inicio" href="{{ route("backoffice.account.dashboard") }}">
                                        <i class="fa fa-arrow-circle-left"></i>
                                    </a>
                                </li>
                            @endif

                        </ul>

                        <!-- END Header Navigation -->

                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Loader -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">

                <!-- Header -->
                <div class="bg-primary-dark">
                    <div class="content content-top">
                        <div class="row push">
                            <div class="col-md py-10 d-md-flex align-items-md-center text-center">
                                <h1 class="text-white mb-0">
                                    @yield("page_title")
                                </h1>
                            </div>

                            <div class="col-md-2 py-10 d-md-flex align-items-md-center justify-content-md-end text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-rounded btn-secondary" data-toggle="modal" data-target="#accessModal">
                                        <span class="d-none d-sm-inline-block">Solicitar Accesos</span>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4 py-10 d-md-flex select-company align-items-md-center justify-content-md-end text-center">

                                <select class="form-control companies-select-2" name="template">
                                    <option selected="selected" value="">- Seleccione</option>

                                    @foreach(session("myCompanies", []) as $myCompany)

                                        @if((int)$myCompany["id"] === (int)session("companyID"))

                                            <option selected="selected" value="{{ $myCompany["id"] }}">{!! $myCompany["name"] !!}</option>

                                        @else

                                            <option value="{{ $myCompany["id"] }}">{!! $myCompany["name"] !!}</option>

                                        @endif

                                    @endforeach

                                </select>

                            </div>

                            <!--
                            <div class="col-md py-10 d-md-flex align-items-md-center justify-content-md-end text-center">

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-rounded btn-primary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user d-sm-none"></i>
                                        <span class="d-none d-sm-inline-block">{!! session("companyName") !!}</span>
                                        <i class="fa fa-angle-down ml-5"></i>
                                    </button>

                                    @if(count(session("myCompanies", [])) > 1)
                                        <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">

                                            <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">Mis Empresas</h5>

                                        </div>
                                    @endif
                                </div>
                            </div>
                            -->

                        </div>
                    </div>
                </div>
                <!-- END Header -->

                <!-- Page Content -->
                <div class="bg-white">

                    <div class="content">

                        @yield("content")

                    </div>

                </div>
                <!-- END Page Content -->

                <footer style="text-align: center; padding-top: 20px; width: 100%;">
                    <p>&copy; 2020 Todos los derechos reservados.</p>
                </footer>

            </main>
            <!-- END Main Container -->

        </div>
        <!-- END Page Container -->

        <!-- Modal -->
        <div class="modal fade" id="accessModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Seleccione una empresa</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">

                        <form class="js-validation-signup" action="{{ route('backoffice.request.access') }}" method="post" enctype="multipart/form-data">

                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="signup-rut">Cargar RUT</label>
                                    <input type="file" class="form-control" id="signup-rut" name="rut">
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
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
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
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">

                                    {{ csrf_field() }}

                                    <button type="submit" class="btn btn-primary">
                                        Enviar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>

        <script src="{{ asset('global-vendor/theme-panel/js/codebase.core.min.js')}}"></script>
        <script src="{{ asset('global-vendor/theme-panel/js/codebase.app.min.js')}}"></script>

        <script src="{{ asset('global-vendor/notyf/notyf.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


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

        <script type="text/javascript">
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })
        </script>

        <script>
            $(function () {
                let inputSelect2 = $('.companies-select-2').select2();

                inputSelect2.on(".companies-select-2 select2:select", function (e) {
                    var data = e.params.data;

                    if(data !== null && data !== undefined){
                        window.location = "{{ route('backoffice.switch.company') }}?id="+data.id;
                        return;
                    }

                    new Notyf({delay:3000}).error('Ocurrio un error, por favor intente nuevamente.');
                });
            })
        </script>

        @yield('js')
        @yield('modals')

    </body>
</html>