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
                @if($item->is_admin)
                    <h2>Super Administrador</h2>
                @else
                    <h2>{!! $pageTitle !!}</h2>
                @endif
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

                        @include("{$firstSegment}.{$secondSegment}.fields")

                        <div class="form-group">

                            @method('PUT')
                            
                            <input type="hidden" name="company_id" value="{{ $item->company_id }}" />
                            <input type="hidden" name="user_id" value="{{ $item->user_id }}" />
                            <input type="hidden" name="template_id" value="{{ $item->template_id }}" />

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-5">

            </div>

        </div>
        {{ Form::close() }}

    </div>

@endsection
