@extends('layouts.'.$appLayout)

@section('js')
    <script>
        $(function () {
            $('.companies-select-3').select2();
        })
    </script>
@endsection

@section('page_title')
    Plantillas
@endsection

@section('content')

    <div class="content">

        <div class="row">
            <div class="col-md-8">
                <h2>
                    Listado
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

                        {{ Form::open(['url' => route('backoffice.templates.index'), "class" => "", "method" => "get"]) }}
                        <div class="row">

                            <div class="col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                                    {!! Form::select('type', ["1" => "Retenci&oacute;n a t&iacute;tulo de ventas", "2" => "Retenci&oacute;n a t&iacute;tulo de renta", "3" => "Industria y comercio"], request()->input("type"), ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                    @if ($errors->has('type'))
                                        <p class="text-danger">{!! $errors->first('type') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                    {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                                    @if ($errors->has('year'))
                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    {!! Form::label('template', 'Plantilla', ['class' => 'control-label']) !!}
                                    {!! Form::select('template', $templates, (request()->has("template"))?request()->input("template"):null, ['class' => 'form-control companies-select-3', 'placeholder' => '- Seleccione']) !!}
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group" style="padding-top: 25px">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">
                                            Buscar
                                        </button>

                                        <a href="{{ route("backoffice.templates.index") }}" class="btn btn-secondary">
                                            Limpiar
                                        </a>

                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-2 text-center">
                                <div class="form-group" style="padding-top: 25px">
                                    <button class="btn btn-danger" name="action" type="submit" onclick="return confirm('Desea eliminar los registros?')" value="delete"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>

                        </div>
                    {{ Form::close() }}

                    <hr />


                        @include("{$firstSegment}.{$secondSegment}.table")

                        {{ $items->links() }}

                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
