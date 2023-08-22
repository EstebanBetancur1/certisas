@extends('layouts.'. $appLayout)

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    {!! $pageTitle !!}
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>

        {!! Form::model($item, ['route' => [$routeUpdate, $item->id], 'class' => 'form-horizontal', "files" => ($hasFiles)?true:false ]) !!}
        <div class="row">
            
            <div class="col-7">

                <div class="block">

                    <div class="block-content">

                        <table class="table table-bordered table-striped">
                            <tbody>

                                <tr>
                                    <th>Nombre</th>
                                    <td>{!! $item->name !!}</td>
                                </tr>

                                <tr>
                                    <th>Nit</th>
                                    <td>{!! $item->nit !!}</td>
                                </tr>
                                <tr>
                                    <th>DV</th>
                                    <td>{!! $item->dv !!}</td>
                                </tr>
                                <tr>
                                    <th>Direcci&oacute;n seccional</th>
                                    <td>{!! $item->sectional !!}</td>
                                </tr>
                                <tr>
                                    <th>Tipo</th>
                                    <td>

                                        @if((int)$item->type === 1)
                                            Persona Jur&iacute;dica
                                        @else
                                            Persona Natural
                                        @endif

                                    </td>
                                </tr>                                

                                <tr>
                                    <th>Ciudad</th>
                                    <td>{!! $item->city !!}</td>
                                </tr>

                                <tr>
                                    <th>Direcci&oacute;n</th>
                                    <td>{!! $item->address !!}</td>
                                </tr>

                                <tr>
                                    <th>Email RUT</th>
                                    <td>{!! $item->email !!}</td>
                                </tr>

                                <tr>
                                    <th>Email Registro</th>
                                    <td>{!! $item->email_user !!}</td>
                                </tr>

                                <tr>
                                    <th>Tel&eacute;fono</th>
                                    <td>{!! $item->phone !!}</td>
                                </tr>

                                <tr>
                                    <th>Fecha</th>
                                    <td>{!! $item->date !!}</td>
                                </tr>

                                <tr>
                                    <th>Actividades</th>
                                    <td>{!! $item->activities !!}</td>
                                </tr>

                                <tr>
                                    <th>Responsabilidades</th>
                                    <td>
                                        @php
                                            $data = ($item->responsibilities)?json_decode($item->responsibilities, true):[];
                                        @endphp
                                    
                                        @foreach($data as $code => $value)
                                            <p>{!! $value !!}</p>
                                        @endforeach
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <div class="col-5">

                <div class="block">

                    <div class="block-content" style="padding-bottom: 20px;">

                        <a href="{{ route("admin.requests.download", ["id" => $item->id]) }}" class="btn btn-secondary">Descargar RUT</a>

                        @if((int)$item->status === 0)
                            <a onclick="return confirm('Desea confirmar esta solicitud?')" href="{{ route("admin.requests.status", ["id" => $item->id, 'status' => 1]) }}" class="btn btn-primary">Verificar Solicitud</a>
                        @else
                            <div style="margin-top: 10px;" class="alert alert-success">Empresa verificada</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        {{ Form::close() }}

    </div>

@endsection
