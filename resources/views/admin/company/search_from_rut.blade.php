@extends('layouts.'. $appLayout)

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .div-select-city .select2-container{
            width: 100%!important;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.companies-select2').select2();

            $(".select-type").on("change", function(){
                let option = $(this).val();

                if(option === "3"){
                    $('.div-select-city').fadeIn(500);
                }else{
                    $('.div-select-city').fadeOut(500);
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
                    Buscar y actualizar empresa
                </h2>
            </div>

            <div class="col-md-4 text-right">
                <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>

        <div class="row">

            <div class="col-6">

                <div class="block">

                    <div class="block-content">

                        {{ Form::open(array('url' => route('admin.company.update.from.rut'), "class" => "form-horizontal", "files" => true)) }}

                            <div class="div-select-city">
                                <div class="form-group">
                                    {!! Form::label('user', 'Usuario', ['class' => 'control-label']) !!}
                                    {!! Form::select('user', $users, null, ['class' => 'form-control companies-select-6', 'placeholder' => '- Seleccione']) !!}
                                </div>
                            </div>

                            <div class="form-group">

                                <label for="rut">Cargar RUT</label>

                                <input type="file" class="form-control" id="rut" name="rut">

                                @if ($errors->has('rut'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('rut') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">

                                {{ csrf_field() }}

                                <button type="submit" class="btn btn-primary">Actualizar</button>

                            </div>

                        {{ Form::close() }}

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
