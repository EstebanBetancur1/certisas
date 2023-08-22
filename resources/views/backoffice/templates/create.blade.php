@extends('layouts.backoffice')

@section('js')
    <script>
        $(function () {
            $('.companies-select-4').select2();
            $('.div-select-city').hide();

            $(".select-type").on("change", function(){
                let option = $(this).val();

                if(option === "3"){
                    $('.div-select-city').fadeIn(500);
                }else{
                    $('.div-select-city').fadeOut(500);
                }
            });

            $(".save-template").on("click", function(){
                $('.loader-container').addClass('show-loader');
            });
        })
    </script>
@endsection

@section('page_title')
    Plantillas
@endsection

@section('content')

    <!-- Page Content -->
    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    Importar
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('backoffice.templates.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>

        <div class="block p-relative">

        <div class="loader-container">
            <div>
                <div class="loader"></div>
                <span> Cargando información</span>
            </div>
        </div>

            <div class="block-content">

                <form class="form-horizontal" action="{{ route('backoffice.templates.store') }}" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                                {!! Form::select('type', ["1" => "Retenci&oacute;n a t&iacute;tulo de ventas", "2" => "Retenci&oacute;n a t&iacute;tulo de renta", "3" => "Industria y comercio"], null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('type'))
                                    <p class="text-danger">{!! $errors->first('type') !!}</p>
                                @endif
                            </div>

                            <div class="div-select-city">
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}
                                    {!! Form::select('city_id', $cities, null, ['class' => 'form-control companies-select-4', 'placeholder' => '- Seleccione']) !!}
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
                                {!! Form::label('period_type', 'Tipo de plantilla', ['class' => 'control-label']) !!}
                                {!! Form::select('period_type', ["1" => "Mensual", "2" => "Bimestral", "3" => "Anual"], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('period_type'))
                                    <p class="text-danger">{!! $errors->first('period_type') !!}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('file', 'Seleccionar csv', ['class' => 'control-label']) !!}
                                {!! Form::file('file', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                            </div>

                            <div class="form-group">
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-primary btn-sm save-template"> Cargar Plantillas </button>
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
