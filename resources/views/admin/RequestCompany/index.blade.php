@extends('layouts.'.$appLayout)

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #example_wrapper > div:nth-child(1){
            display: flex;
            justify-content: center;
            align-items: center;
            justify-content: space-between;
        }
        #example_filter{
            display: flex;
            justify-content: end;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
      $(document).ready(function() {
    $('#example').DataTable({
        "lengthChange": false,
        language: {
        "emptyTable": "No hay solicitudes de empresas",
         url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        });
    });

    </script>
@endsection

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    Solicitud de Empresa
                </h2>
            </div>
        </div>

        <div class="row">
            
            <div class="col-12">

                <div class="block">

                    <div class="block-content">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Solicitante</th>
                                    <th>Empresa</th>
                                    {{-- <th>Estado</th> --}}
                                    <th>Aprobar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr>
                                        <td>{{ $request['full_name'] }}</td>
                                        <td>{{ $request['name'] }}</td>
                                        {{-- <td>{{ $request['status'] == 0 ? 'No Aprobado' : 'Otro Estado' }}</td> --}}
                                        <td>
                                            <a href="https://v4.certisaas.com/admin/users/{{ $request['user_id'] }}/company/{{ $request['company_id'] }}" type="button" class="btn btn-success">Aprobar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Solicitante</th>
                                    <th>Empresa</th>
                                    {{-- <th>Estado</th> --}}
                                    <th>Aprobar</th>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
