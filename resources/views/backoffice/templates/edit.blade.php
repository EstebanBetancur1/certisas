@extends('layouts.'. $appLayout)
@section('css')
<style>
    .preview-image>.image {text-align: center;}
    .preview-image>.image img {margin: 0 auto;}
    #summary {height: 150px;}
</style>
@endsection

@section('js')
<script src="{{ asset('global-vendor/preview/preview.js') }}" type="text/javascript"></script>
<script>$(()=>{$(".preview-image").preview({allowedTypes: "jpg,jpeg,png", pathPreview: '{{asset('images/default-image.png')}}'});})</script>
@endsection
@section('page_title')
    Plantillas
@endsection
@section('content')
<ul class="cs-breadcrumbs">
                <li><a href="{{ route($routeIndex) }}"><i class="icon-arrow-left"></i> Emitir certificados</a></li>
                <li><span>Editar certificado</span></li>
            </ul>
<div class="content content-scroll w-breadcrumb">

    <div class="row ">
        <div class="col-md-12">

        </div>
        <div class="col-md-8" style="margin-right: auto;margin-left: auto">
            @if($item->is_admin)
            <h4 class="page-title">Super Administrador - Editar</h4>
            @else
            <h4 class="page-title">Editar</h4>
            @endif

            {!! Form::model($item, ['route' => [$routeUpdate, $item->id], 'class' => 'form-horizontal', "files" =>
            ($hasFiles)?true:false ]) !!}

            <div class="block">
                <div class="block-content">

                    @include("{$firstSegment}.{$secondSegment}.fields")

                    <div class="form-group">

                        @method('PUT')

                        <input type="hidden" name="company_id" value="{{ $item->company_id }}" />
                        <input type="hidden" name="user_id" value="{{ $item->user_id }}" />
                        <input type="hidden" name="template_id" value="{{ $item->template_id }}" />

                        <button type="submit" class="cs-btn btn-blue mt-3">Guardar cambios</button>
                    </div>

                </div>

            </div>

            {{ Form::close() }}
        </div>

    </div>



</div>

@endsection
