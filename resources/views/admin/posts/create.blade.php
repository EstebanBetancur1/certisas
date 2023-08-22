@extends('layouts.'. $appLayout)

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script>

    <script src="{{ asset('global-vendor/preview/preview.js') }}" type="text/javascript"></script>

    <script>

        @php
            $language = $languages->where("main", 1)->first();
        @endphp

        ClassicEditor
            .create( document.querySelector( '.editor-{{ $language->lang }}' ), {

                removePlugins: [ 'Image', 'EasyImage', "Image", "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload" ],

            } )
            .catch( error => {
                console.error( error );
            } );

        $(function () {
            $(".preview-image").preview({
                allowedTypes: "jpg,jpeg,png",
                pathPreview: '/images/default-image.png'
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
            
            <div class="col-9">

                <div class="block">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        @foreach($languages as $language)
                            @if((int)$language->main === 1)
                                <li class="nav-item">
                                    <a class="nav-link active" href="#lang-{{ $language->lang }}">{!! $language->title !!}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="block-content tab-content">
                        @foreach($languages as $language)
                            @if((int)$language->main === 1)
                                <div class="tab-pane {{ ((int)$language->main === 1)?"active":"" }}" id="lang-{{ $language->lang }}" role="tabpanel">

                                    @include("{$firstSegment}.{$secondSegment}.fields-i18n", ["lang" => $language->lang])

                                    @include("{$firstSegment}.{$secondSegment}.fields")

                                    <hr />

                                    <div class="form-group row justify-content-md-center">
                                        <div class="col-7">
                                            {!! Form::label('image', 'Imagen Principal', ['class' => 'control-label']) !!}
                                            <div class="preview-image border-info border text-center" data-field="image"></div>
                                            <span class="label label-primary"><i class="fa fa-info-circle" aria-hidden="true"></i> Dimensiones: 450px por 300px</span>

                                            @if (session('image'))
                                                <p class="text-danger">{!! session('image') !!}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
        {{ Form::close() }}

    </div>

@endsection
