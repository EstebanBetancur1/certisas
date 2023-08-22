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
        <link rel="stylesheet" href="{{ asset('global-vendor/theme-panel/css/themes/corporate.min.css') }}">

        <link rel="stylesheet" href="{{ asset('global-vendor/notyf/notyf.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">

        @yield('css')

        @yield('js_header')

    </head>

    <body>
        
        <div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-modern main-content-boxed side-trans-enabled page-header-fixed">
 
            <nav id="sidebar">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow px-15">
                        <!-- Mini Mode -->
                        <div class="content-header-section sidebar-mini-visible-b">
                            <!-- Logo -->
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                            </span>
                            <!-- END Logo -->
                        </div>
                        <!-- END Mini Mode -->

                        <!-- Normal Mode -->
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Sidebar -->

                            <!-- Logo -->
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="{{ route("admin.dashboard.index") }}">
                                    <span class="font-size-xl text-dual-primary-dark"> {{ setting('project', config('app.name', 'Laravel')) }} </span>
                                </a>
                            </div>
                            <!-- END Logo -->
                        </div>
                        <!-- END Normal Mode -->
                    </div>
                    <!-- END Side Header -->

                    <!-- Side User -->
                    <div class="content-side content-side-full content-side-user px-10 align-parent">
                        <!-- Visible only in mini mode -->
                        <div class="sidebar-mini-visible-b align-v animated fadeIn">
                            <img class="img-avatar img-avatar32" src="{{ asset("global-vendor/theme-panel/media/avatars/avatar15.jpg") }}" alt="">
                        </div>
                        <!-- END Visible only in mini mode -->

                        <!-- Visible only in normal mode -->
                        <div class="sidebar-mini-hidden-b text-center">
                            <a class="img-link" href="{{ route('admin.assistants.edit', ['id' => Auth::guard('admin')->user()->id ]) }}">
                                <img class="img-avatar" src="{{ asset("global-vendor/theme-panel/media/avatars/avatar15.jpg") }}" alt="">
                            </a>
                            <ul class="list-inline mt-10">
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase" href="{{ route('admin.assistants.edit', ['id' => Auth::guard('admin')->user()->id ]) }}">{{ auth("admin")->user()->full_name }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark" href="{{ route('auth.admin.logout') }}">
                                        <i class="si si-logout"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END Visible only in normal mode -->
                    </div>
                    <!-- END Side User -->

                    <!-- Side Navigation -->
                    <div class="content-side content-side-full">
                        <ul class="nav-main">
                            <li>
                                <a class="{{ (request()->segment(2) == '') ? "active" : "" }}" href="{{ route('admin.dashboard.index') }}">
                                    <i class="fa fa-dashboard"></i> <span class="sidebar-mini-hide">Escritorio</span>
                                </a>
                            </li>

                            <li class="@if(in_array(request()->segment(2), ['requests'])) open @endif">
                                <a class="{{ (request()->segment(2) == 'requests') ? "active" : "" }}" href="{{ route('admin.requests.index') }}">
                                    <i class="fa fa-flag"></i> <span class="sidebar-mini-hide">Solicitudes</span>
                                </a>
                            </li>

                            <li class="@if(in_array(request()->segment(2), ['requests'])) open @endif">
                                <a class="{{ (request()->segment(2) == 'requests') ? "active" : "" }}" href="{{ route('admin.company.index') }}">
                                    <i class="fa fa-building"></i> <span class="sidebar-mini-hide">Empresas</span>
                                </a>
                            </li>

                            <li class="@if(in_array(request()->segment(2), ['templates'])) open @endif">
                                <a class="{{ (request()->segment(2) == 'templates') ? "active" : "" }}" href="{{ route('admin.templates.index') }}">
                                    <i class="fa fa-file-excel-o"></i> <span class="sidebar-mini-hide">Plantillas</span>
                                </a>
                            </li>

                            @if(isAdminOrHasPermissionOf('class_uses_recursive($class)-module'))
                            <li class="{{ (request()->segment(2) == 'users') ? "open" : "" }}">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                    <i class="fa fa-users"></i><span class="sidebar-mini-hide">Usuarios</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.users.index') }}" class="{{ (request()->segment(3) == '') ? "active" : "" }}"> Listado </a></li>
                                    @if(isAdminOrHasPermissionOf('create-action'))
                                        <li><a href="{{ route('admin.users.create') }}" class="{{ (request()->segment(3) == 'create') ? "active" : "" }}"> Nuevo </a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @if(isAdminOrHasPermissionOf('assistants-module'))
                            <li class="{{ (request()->segment(2) == 'assistants') ? "open" : "" }}">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                    <i class="fa fa-user-circle"></i><span class="sidebar-mini-hide">Asistentes</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.assistants.index') }}" class="{{ (request()->segment(3) == '') ? "active" : "" }}"> Listado </a></li>
                                    @if(isAdminOrHasPermissionOf('create-action'))
                                        <li><a href="{{ route('admin.assistants.create') }}" class="{{ (request()->segment(3) == 'create') ? "active" : "" }}"> Nuevo </a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            <li class="nav-main-heading"><span class="sidebar-mini-visible">GR</span><span class="sidebar-mini-hidden">General</span></li>

                            @if(isAdminOrHasPermissionOf('security-module'))
                            <li class="@if(in_array(request()->segment(2), ['roles', 'permissions'])) open @endif">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                    <i class="fa fa-unlock-alt"></i><span class="sidebar-mini-hide">Roles y Permisos</span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('admin.roles.index') }}" class="{{ (request()->segment(2) == 'roles') ? "active" : "" }}"> Roles </a></li>
                                    <li><a href="{{ route('admin.permissions.index') }}" class="{{ (request()->segment(2) == 'permissions') ? "active" : "" }}"> Permisos </a></li>
                                </ul>
                            </li>
                            @endif

                            @if(isAdminOrHasPermissionOf('languages-module'))
                            <li class="@if(in_array(request()->segment(2), ['languages'])) open @endif">
                                <a class="{{ (request()->segment(2) == 'languages') ? "active" : "" }}" href="{{ route('admin.languages.index') }}">
                                    <i class="fa fa-flag"></i> <span class="sidebar-mini-hide">Idiomas</span>
                                </a>
                            </li>
                            @endif

                            @if(isAdminOrHasPermissionOf('settings-module'))
                            <li>
                                <a class="{{ (request()->segment(2) == 'settings') ? "active" : "" }}" href="{{ route('admin.settings.edit') }}">
                                    <i class="fa fa-cog"></i> <span class="sidebar-mini-hide">Ajustes</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- END Side Navigation -->
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
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->

                        <!-- END Layout Options -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="content-header-section">
                        <!-- User Dropdown -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ auth("admin")->user()->full_name }}</span>
                                <i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                                <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">User</h5>
                                <a class="dropdown-item" href="{{ route('admin.assistants.edit', ['id' => Auth::guard('admin')->user()->id ]) }}">
                                    <i class="si si-user mr-5"></i> Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('auth.admin.logout') }}">
                                    <i class="si si-logout mr-5"></i> Salir
                                </a>
                            </div>
                        </div>
                        <!-- END User Dropdown -->

                        <!-- Notifications -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-flag"></i>
                                <span class="badge badge-primary badge-pill">1</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
                                <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notificaciones</h5>
                                <ul class="list-unstyled my-20">

                                    <li>
                                        <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                            <div class="ml-5 mr-15">
                                                <i class="fa fa-fw fa-check text-success"></i>
                                            </div>
                                            <div class="media-body pr-10">
                                                <p class="mb-0">You’ve upgraded to a VIP account successfully!</p>
                                                <div class="text-muted font-size-sm font-italic">15 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                                    <i class="fa fa-flag mr-5"></i> Ver todo
                                </a>
                            </div>
                        </div>
                        <!-- END Notifications -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Loader -->
                <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
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

                @yield("content")

            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        <b>Version</b> 1.0.0
                    </div>
                    <div class="float-left">
                       <strong>Copyright &copy; 2020. </strong> Todos los derechos reservados
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <script src="{{ asset('global-vendor/theme-panel/js/codebase.core.min.js')}}"></script>
        <script src="{{ asset('global-vendor/theme-panel/js/codebase.app.min.js')}}"></script>

        <script src="{{ asset('global-vendor/notyf/notyf.js') }}"></script>

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