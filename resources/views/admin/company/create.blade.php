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

            $('.companies-select-6').select2();
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
            
            <div class="col-6">

                <div class="block">

                    <div class="block-content">

                        @include("{$firstSegment}.{$secondSegment}.fields")

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-6">
                
                <div class="block">

                    <div class="block-content" style="padding-bottom: 20px;">

                        <h4>Responsabilidades</h4>

                        @foreach($responsibilities as $responsibility)

                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="responsibilities[]" value="{{ $responsibility->id }}" id="responsability-{{ $responsibility->id }}">
                              <label class="form-check-label" for="responsability-{{ $responsibility->id }}"> {!! $responsibility->code !!}: {!! $responsibility->title !!}</label>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        {{ Form::close() }}

    </div>

@endsection
