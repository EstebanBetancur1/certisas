@extends('layouts.'.$appLayout)

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css"/>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>

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

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    {!! $pageTitle !!}
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admin.company.search.from.rut') }}" class="btn btn-secondary">Actualizar empresa</a>
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
