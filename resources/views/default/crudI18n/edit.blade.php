@extends('layouts.'. $appLayout)

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script>

    <script>

        @foreach($languages as $language)
            ClassicEditor
            .create( document.querySelector( '.editor-{{ $language->lang }}' ), {

                removePlugins: [ 'Image', 'EasyImage', "Image", "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload" ],

            } )
            .catch( error => {
                console.error( error );
            } );
        @endforeach

            //let p = ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName );
            //console.log(p);

    </script>

@endsection

@section("css")
    <style>
        .ck-editor .ck-editor__main .ck-content {
            min-height: 300px;
        }
    </style>
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

        <div class="row">
            
            <div class="col-9">

                <div class="block">

                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        @foreach($languages as $language)
                            <li class="nav-item">

                                @if(request()->has("lang"))
                                    <a class="nav-link {{ (request()->input("lang") === $language->lang)?"active":"" }}" href="#lang-{{ $language->lang }}">{!! $language->title !!}</a>
                                @else
                                    <a class="nav-link {{ ((int)$language->main === 1)?"active":"" }}" href="#lang-{{ $language->lang }}">{!! $language->title !!}</a>
                                @endif
                                
                            </li>
                        @endforeach
                    </ul>

                    <div class="block-content tab-content">

                        @foreach($languages as $language)

                            @if(request()->has("lang"))
                                <div class="tab-pane {{ (request()->input("lang") === $language->lang)?"active":"" }}" id="lang-{{ $language->lang }}" role="tabpanel">
                            @else
                                <div class="tab-pane {{ ((int)$language->main === 1)?"active":"" }}" id="lang-{{ $language->lang }}" role="tabpanel">
                            @endif

                                @if(array_key_exists($language->lang, $versions) && is_object($versions[$language->lang]))

                                    {!! Form::model($versions[$language->lang], ['route' => [$routeUpdate, $item->id], 'class' => 'form-horizontal', "files" => ($hasFiles)?true:false ]) !!}

                                @else

                                    {!! Form::model($item, ['route' => [$routeUpdate, $item->id], 'class' => 'form-horizontal', "files" => ($hasFiles)?true:false ]) !!}

                                @endif

                                    @include("{$firstSegment}.{$secondSegment}.fields-i18n", ["lang" => $language->lang])

                                    <div class="form-group">

                                        @method('PUT')

                                        <input type="hidden" name="lang" value="{{ $language->lang }}" />
                                        <input type="hidden" name="language_id" value="{{ $language->id }}" />
                                        
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>

                                {{ Form::close() }}

                            </div>

                        @endforeach

                    </div>

                </div>
                
            </div>

            <div class="col-3">

                <div class="block">
                    <div class="block-content">

                        {!! Form::model($item, ['route' => [$routeInstanceUpdate, $item->id], 'class' => 'form-horizontal' ]) !!}
                            
                            @include("{$firstSegment}.{$secondSegment}.fields")

                            <div class="form-group">

                                @method('PUT')
                                
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                            
                        {{ Form::close() }}

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
