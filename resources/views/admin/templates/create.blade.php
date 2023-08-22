@extends('layouts.admin')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .div-select-city{
            display: none;
        }

        .div-select-city .select2-container{
            width: 100%!important;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.companies-select-5').select2();

            $(".select-type").on("change", function(){
                let option = $(this).val();

                if(option === "2"){
                    $('.div-select-city').fadeIn(500);
                }else{
                    $('.div-select-city').fadeOut(500);
                }
            });
        })
    </script>
@endsection

@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Importar Plantillas

                    <a href="{{ route('admin.templates.index') }}" class="btn btn-primary btn-xs">Volver</a>

                </h3>
            </div>

            <div class="block-content">

                <form class="form-horizontal" action="{{ route('admin.templates.store') }}" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('company_id', 'Empresa', ['class' => 'control-label']) !!}
                                {!! Form::select('company_id', $companies, null, ['class' => 'form-control companies-select-5', 'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('company_id'))
                                    <p class="text-danger">{!! $errors->first('company_id') !!}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                                {!! Form::select('type', ["1" => "Rete fuente", "2" => "Rete ICA", "3" => "Rete IVA"], null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('type'))
                                    <p class="text-danger">{!! $errors->first('type') !!}</p>
                                @endif
                            </div>

                            <div class="div-select-city"> 
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}
                                    {!! Form::select('city_id', $cities, null, ['class' => 'form-control companies-select2', 'placeholder' => '- Seleccione']) !!}
                                    @if ($errors->has('city_id'))
                                        <p class="text-danger">{!! $errors->first('city_id') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('title', 'Nombre de la plantilla', ['class' => 'control-label']) !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                @if ($errors->has('title'))
                                    <p class="text-danger">{!! $errors->first('title') !!}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('type_template', 'Tipo de plantilla', ['class' => 'control-label']) !!}
                                {!! Form::select('type_template', ["1" => "Mensual", "2" => "Bimestral", "3" => "Anual"], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('type_template'))
                                    <p class="text-danger">{!! $errors->first('type_template') !!}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('file', 'Seleccionar csv', ['class' => 'control-label']) !!}
                                {!! Form::file('file', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                            </div>

                            <div class="form-group">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-primary btn-sm"> Cargar Plantillas </button>
                            </div>
                            
                        </div>
                    </div>

                </form>

                @if(isset($template) && $template)
                    <h4 class="page-header">Datos Cargados</h4>
                    <p><strong>Registros Importados: </strong> {{ $count }}</p>
                @endif

                @if(isset($errors) && count($errors))

                    <div class="alert alert-danger">Se encontraron los siguientes errores...</div>

                    <table id="list-items" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="10%">Fila</th>
                            <th>Campo</th>
                            <th>Mensaje</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($errors as $error)
                                <tr>
                                    <td>{!! $error['row'] !!}</td>
                                    <td>{!! $error['field'] !!}</td>
                                    <td>{!! $error['message'] !!}</td>
                                    <td>{!! $error['fields'][$error['field']] !!}</td>
                                    <td><span class="text-danger">Error</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <!-- END Page Content -->

@endsection