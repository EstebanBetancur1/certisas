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
                <h2>
                    {!! $pageTitle !!}
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>

        {{ Form::open(array('url' => route($routeStore), "class" => "form-horizontal", "files" => ($hasFiles)?true:false)) }}
        <div class="row">
            
            <div class="col-7">

                <div class="block">

                    <div class="block-content">

                        @include("{$firstSegment}.{$secondSegment}.fields")

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-5">

                <div class="block">

                    <div class="block-content">

                        {!! Form::label('image', 'Imagen Principal', ['class' => 'control-label']) !!}
                        <div class="preview-image border-info border text-center" data-field="image"></div>
                        <span class="label label-primary"><i class="fa fa-info-circle" aria-hidden="true"></i> Dimensiones: 400px por 400px</span>

                        @if (session('image'))
                            <p class="text-danger">{!! session('image') !!}</p>
                        @endif

                    </div>

                </div>

            </div>

        </div>
        {{ Form::close() }}

    </div>

@endsection
