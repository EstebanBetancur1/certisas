@extends('layouts.backoffice')

@section("css")
    <style>
        .block-content.block-content-full i.fa{
            font-size: 50px;
            color: #dbdbdb;
        }

        .block-content p{
            padding-bottom: 0px!important;
            margin-bottom: 0px!important;
        }
    </style>
@endsection

@section("js")

    @if(! session("companyID", false))
        {{-- <script type="text/javascript">
            $(function(){
                $('#switchCompany').modal('show');
            });
        </script> --}}
    @endif


@endsection

@section('page_title')
    Escritorio
    <small style="color: #ffffff; font-size: 14px;">Resumen del panel</small>
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Icon Navigation -->
        <div class="row gutters-tiny push">

            <div class="col-6 col-md-4 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow text-center" href="{{ route('backoffice.templates.index') }}">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="icon-upload"></i>
                        </p>
                        <p class="font-w600">Emitir Certificados</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow ribbon ribbon-primary text-center" href="{{ route('backoffice.emissions.my.certificates') }}" class="{{ (request()->segment(3) == 'my-certificates') ? "active" : "" }}">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="icon-download"></i>
                        </p>
                        <p class="font-w600">Mis Certificados</p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4 col-xl-4">
                <a class="block block-rounded block-bordered block-link-shadow text-center" href="{{ route('backoffice.company.show') }}">
                    <div class="block-content">
                        <p class="mt-5">
                            <i class="icon-configure"></i>
                        </p>
                        <p class="font-w600">Administraci&oacute;n</p>
                    </div>
                </a>
            </div>

        </div>
        <!-- END Icon Navigation -->

    </section>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="switchCompany" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Seleccione una empresa</h5>
                </div>
                <div class="modal-body">

                    <form action="{{ route('backoffice.switch.company') }}" method="get">
                        <div class="form-row">
                            <div class="col-9">

                                <select class="form-control" id="template" name="id">
                                    <option selected="selected" value="">- Seleccione</option>

                                    @foreach(session("myCompanies", []) as $myCompany)
                                        <option value="{{ $myCompany["id"] }}">{!! $myCompany["name"] !!}</option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-primary">Seleccionar</button>
                            </div>
                        </div>

                        <div class="form-row">
                            <p style="padding-top: 10px;">
                                <a href="{{ route('auth.user.logout') }}">
                                    <i class="fa fa-sign-out"></i> Volver a iniciar sesi&oacute;n
                                </a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
