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
                @if($item->is_admin)
                    <h2>Super Administrador</h2>
                @else
                    <h2>{!! $pageTitle !!}</h2>
                @endif
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('admin.company.search.from.rut') }}" class="btn btn-outline-secondary">Actualizar</a>
                <a href="{{ route($routeIndex) }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>

        {!! Form::model($item, ['route' => [$routeUpdate, $item->id], 'class' => 'form-horizontal', "files" => ($hasFiles)?true:false ]) !!}
        <div class="row">
            
            <div class="col-6">

                <div class="block">

                    <div class="block-content">

                        @include("{$firstSegment}.{$secondSegment}.fields")

                        <div class="form-group">

                            @method('PUT')
                            
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="block">

                    <div class="block-content" style="padding-bottom: 20px;">

                        <h4>Usuarios</h4>

                        @if($item->users->count())
                            @foreach($item->users as $user)
                                <p>
                                    <a href="{{ route("admin.users.edit", ["id" => $user->id]) }}" class="btn btn-secondary btn-sm">Editar</a>
                                    <a href="{{ route("admin.company.remove.permissions", ["id" => $item->id, 'user' => $user->id]) }}" onclick="return confirm('Desea quitar el permiso a este usuario?')" class="btn btn-danger btn-sm">Quitar Permiso</a>

                                    {!! $user->full_name !!}, {!! $user->email !!}
                                </p>
                            @endforeach
                        @else
                            <div class="alert alert-warning">La empresa no tiene usuarios asociados.</div>
                        @endif

                    </div>
                </div>
                
                <div class="block">

                    <div class="block-content" style="padding-bottom: 20px;">

                        <a href="{{ route("admin.company.upload.rut", ['id' => $item->id]) }}" class="btn btn-secondary"><i class="fa fa-upload"></i></a>

                        @if($item->file)
                            <a href="{{ route("admin.company.download", ["id" => $item->id]) }}" class="btn btn-secondary">Descargar RUT</a>
                        @endif

                        <hr />

                        <h4>Responsabilidades</h4>

                        @foreach($responsibilities as $responsibility)

                            @if(array_key_exists($responsibility->id, $responsibilitiesSelected))
                                <label style="display:block; width: 100%;margin-bottom: 5px;" class="form-check-label" for="responsability-{{ $responsibility->id }}"> <i class="fa fa-check"></i> {!! $responsibility->code !!}: {!! $responsibility->title !!}</label>
                            @endif

                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        {{ Form::close() }}

    </div>

@endsection
