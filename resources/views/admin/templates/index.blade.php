@extends('layouts.'.$appLayout)

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.companies-select2').select2();
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
                <a href="{{ route($routeCreate) }}" class="btn btn-success">{!! $textCreateBtn !!}</a>
            </div>
        </div>

        <div class="row">
            
            <div class="col-12">

                <div class="block">

                    <div class="block-content">

                        {{ Form::open(['url' => route('admin.templates.index'), "class" => "", "method" => "get"]) }}
                        <div class="row" style="justify-content: space-between">

                            {{-- <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('type', 'Tipo de impuestos', ['class' => 'control-label']) !!}
                                    {!! Form::text('nit', (request()->has("nit"))?request()->input("nit"):null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                            </div> --}}

                            {{-- <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
                                    {!! Form::text('name', (request()->has("name"))?request()->input("name"):null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                            </div> --}}

                            <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                    {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                                    @if ($errors->has('year'))
                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('company', 'Empresa', ['class' => 'control-label']) !!}
                                    {!! Form::select('company', $companies, (request()->has("company"))?request()->input("company"):null, ['class' => 'form-control companies-select2', 'placeholder' => '- Seleccione']) !!}
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('template', 'Plantilla', ['class' => 'control-label']) !!}
                                    {!! Form::select('template', $templates, (request()->has("template"))?request()->input("template"):null, ['class' => 'form-control companies-select2', 'placeholder' => '- Seleccione']) !!}
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group" style="padding-top: 25px">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-list"></i>
                                        </button>
                                        <a href="{{ route("admin.templates.index") }}" class="btn btn-secondary">
                                            <i class="fa fa-eraser"></i>
                                        </a>
                                    </div>

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
