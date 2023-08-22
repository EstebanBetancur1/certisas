@extends('layouts.'. $appLayout)

@section('css')
    <style type="text/css">
        .preview-image > .image{
            text-align: center;
        }

        .preview-image > .image img{
            margin: 0 auto;
        }

        #summary{
            height: 150px;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('global-vendor/preview/preview.js') }}" type="text/javascript"></script>

    <script>
        $(function () {
            $(".preview-image").preview({
                allowedTypes: "jpg,jpeg,png",
                pathPreview: '{{ asset('images/default-image.png') }}'
            });
        })
    </script>
@endsection

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                @if($item->is_admin)
                    <h2>Super Administrador</h2>
                @else
                    <h2>{!! $pageTitle !!}</h2>
                @endif
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>

        <div class="block">
            <div class="block-content">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="30%">Campo</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Nombre Completo</th>
                            <td>{!! $item->full_name !!}</td>
                        </tr>
                        <tr>
                            <th>Correo Electr&oacute;nico</th>
                            <td>{!! $item->email !!}</td>
                        </tr>
                        <tr>
                            <th>Tel&eacute;fono</th>
                            <td>{!! $item->phone !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
