@extends('layouts.'.$appLayout)

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('admin/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(function () {
            $('#list-items').DataTable({
                language: {
                    search: "Buscar: ",
                    lengthMenu:    "Mostrar _MENU_ registros por fila",
                    info:           "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                    emptyTable:     "No se encontraron registros",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Pr&oacute;ximo",
                        last:       "Ultimo"
                    }
                }
            });
        })
    </script>
@endsection

@section('page_title')
    Administraci&oacute;n / <small style="color: #ffffff;">Usuarios</small>
@endsection

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    {!! $pageTitle !!}
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route($routeCreate) }}" class="btn btn-success">{!! $textCreateBtn !!}</a>
            </div>
        </div>

        <div class="row">
            
            <div class="col-12">

                <div class="block">

                    <div class="block-content">

                        @include("{$firstSegment}.{$secondSegment}.table")

                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
