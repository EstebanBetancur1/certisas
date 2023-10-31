@extends('layouts.admin')

@section('content')
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Escritorio
            <small>Resumen del panel</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="{{ route('admin.users.index') }}">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="fa fa-user fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $customersCount }}">0</div>
                        <div class="font-size-sm font-w600 text-muted">Clientes</div>
                    </div>
                </a>
            </div>            

            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="{{ route('admin.assistants.index') }}">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="fa fa-user-circle fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $assistantsCount }}">0</div>
                        <div class="font-size-sm font-w600 text-muted">Asistentes</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="{{ route('admin.requests.index') }}">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="fa fa-exclamation fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $reuestCount }}">0</div>
                        <div class="font-size-sm font-w600 text-muted">Solicitudes</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="{{ route('admin.RequestCompany.index') }}">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="fa fa-exclamation fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $RequestClietsCount }}">0</div>
                        <div class="font-size-sm font-w600 text-muted">Solicitudes Empresa</div>
                    </div>
                </a>
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection