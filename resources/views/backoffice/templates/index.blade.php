@extends('layouts.'.$appLayout)

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css')}}" />
<link type="text/css" href="{{asset('https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.bootstrap3.min.css" />

@endsection

@section('js')
<script defer type="text/javascript" src="{{asset('https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js')}}"></script>
<script defer type="text/javascript" src="{{asset('https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js')}}"></script>
<script defer src="{{mix('/js/templates-datatable.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
  $('#example').DataTable({
      "lengthChange": false,
      language: {
      "emptyTable": "No hay solicitudes de empresas",
       url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
      },
      });
  });

  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/js/standalone/selectize.min.js"></script>
    <script>
        $(function () {
            $('.div-select-city').hide();

            $(".select-type").on("change", function(){
                let option = $(this).val();

                if(option === "3"){
                    $('.div-select-city').fadeIn(500);
                }else{
                    $('.div-select-city').fadeOut(500);
                }
            });

            $(".save-template").on("click", function(){
                $('.loader-container').addClass('show-loader');
            });
        })
    </script>
<script>
    $(document).ready(function() {
        $('.companies-select-4').selectize({
            create: true,
            sortField: 'text'
        });
    });
    </script>

@endsection

@section('page_title')
    Plantillas
@endsection

@section('content')


    <div class="content">
        <div class="">
            <div class="page-headline">
                <h4 class="page-title">Plantillas</h4>
                <!-- <button data-buttonmodal="import-template" class="cs-btn btn-outline-secundary sm-btn modal-btn">{!! $textCreateBtn !!}</button> -->
                <!-- <a href="{{ route($routeCreate) }}" data-buttonmodal="import-template" class="btn btn-primary btn-blue sm-btn">{!! $textCreateBtn !!}</a> -->
            </div>
                {{ Form::open(['url' => route('backoffice.templates-json'), "class" => "", "method" => "get", 'id' => 'filter-form']) }}
                @csrf
                <div class="content-header">
                            <div class="table-actions">
                                <button class="btn-icon open-filter" type="button">Filtrar<i class="icon-filter"></i></button>
                                <button id="delete-button" class="btn-icon table-action d-none"><i class="icon-trash"></i></button>
                                <div class="filter-container">

                                    <div class="cs-field select">
                                        {!! Form::label('type', 'Tipo de impuesto', ['class' => '']) !!}
                                        <div class="select-container">
                                            {!! Form::select('type', ["1" => "Retenci&oacute;n a t&iacute;tulo de ventas", "2" => "Retenci&oacute;n a t&iacute;tulo de renta", "3" => "Industria y comercio"], request()->input("type"), ['class' => '', 'placeholder' => 'Seleccione','id' => 's-type']) !!}
                                        </div>
                                        @if ($errors->has('type'))<p class="text-danger">{!! $errors->first('type') !!}</p>@endif
                                    </div>
                                    <div class="cs-field select">
                                        {!! Form::label('year', 'A&ntilde;o', ['class' => '']) !!}
                                        <div class="select-container">
                                            {!! Form::select('year', $years, request()->input("year"), ['class' => '', 'placeholder' => 'Seleccione','id' => 's-year']) !!}
                                            @if ($errors->has('year'))
                                                <p class="text-danger">{!! $errors->first('year') !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="cs-field select">
                                        {!! Form::label('template', 'Plantilla', ['class' => '']) !!}
                                        <div class="select-container">
                                            {!! Form::select('template', $templates, (request()->has("template"))?request()->input("template"):null, ['class' => '', 'placeholder' => 'Seleccione', 'id' => 's-template']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-light" id="btn-clean-filters">{{__('Clean Filters')}}</button>
                                    <button class="btn btn-primary" type="submit">{{__('Filter')}}</button>
                                    <a href="" id="btn-download" class="btn btn-secondary">
                                        <i class="fa fa-download"></i>
                                    </a>

                                    @if(session('errores'))
                                        <!-- Botón para descargar los errores -->
                                        <a href="{{ route('backoffice.descargar.errores') }}" class="btn btn-danger" style="margin-left:40px;">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <button data-buttonmodal="import-template" class="btn-icon table-action modal-btn" type="button" rel="tooltip" data-placement="top" title="{!! $textCreateBtn !!}"><i class="icon-import-table"></i></button>
                </div>
            {{ Form::close() }}

        </div>

        @include("{$firstSegment}.{$secondSegment}.table")

        {{-- {{ $items->links() }} --}}
        {{ $items->links('pagination.default') }}

    </div>

    <div class="cs-modal-container" data-modal="import-template">
        <div class="modal-shade"></div>
        <div class="cs-modal sm-modal">
            <div class="cs-modal-content">
                <div class="modal_header">
                  <h4 class="m-title">{{__('Import Template')}}</h4>
                  <button class="close-modal"><i class="icon-close"></i></button>
                </div>
                <form class="form-horizontal" action="{{ route('backoffice.templates.store') }}" method="post" enctype="multipart/form-data">

                    <div class="cs-field field">
                        {!! Form::label('type', 'Tipo de impuesto', ['class' => '']) !!}
                        <div class="select-container">
                            {!! Form::select('type', ["1" => "Retenci&oacute;n a t&iacute;tulo de ventas", "2" => "Retenci&oacute;n a t&iacute;tulo de renta", "3" => "Industria y comercio"], null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                            @if ($errors->has('type'))
                                <p class="text-danger">{!! $errors->first('type') !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="cs-field field div-select-city">
                        {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}
                        <div class="select-container">
                            {!! Form::select('city_id', $cities, null, ['class' => 'form-control companies-select-4', 'placeholder' => '- Seleccione']) !!}
                            @if ($errors->has('city_id'))
                                <p class="text-danger">{!! $errors->first('city_id') !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="cs-field field">
                        {!! Form::label('title', 'Nombre de la plantilla', ['class' => 'control-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                        @if ($errors->has('title'))
                            <p class="text-danger">{!! $errors->first('title') !!}</p>
                        @endif
                    </div>

                    <div class="cs-field field" >
                        {!! Form::label('period_type', 'Tipo de plantilla', ['class' => 'control-label']) !!}
                        <div class="select-container" style="z-index: 0">
                            {!! Form::select('period_type', ["1" => "Mensual", "2" => "Bimestral", "3" => "Anual"], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                            @if ($errors->has('period_type'))
                                <p class="text-danger">{!! $errors->first('period_type') !!}</p>
                            @endif
                        </div>
                    </div>

                    <div class="cs-field field">
                        {!! Form::label('file', 'Cargar .xlsx', ['class' => 'bold']) !!}
                        <div class="upload">
                            <input name="file" id="file" type="file" class="upload" required>
                            <label for="file">{{__('Select a file')}}</label>
                        </div>
                    </div>
                    {!! csrf_field() !!}
                  <button type="submit" class="cs-btn btn-blue ml-auto" >{{__('Import')}}</button>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Delete Templates')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('backoffice.templates.delete')}}" method="post">
                        @csrf
                        <div class="md-msm">
                            {{__('Are you sure you want to delete the selected records?')}}
                        </div>
                        <div class="d-flex">
                            <button type="button" data-dismiss="modal" class="btn btn-light">{{__('Cancel')}}</button>
                            <button class="cs-btn btn-danger ml-auto sm-btn" id="confirm-delete" type="button">{{__('Delete')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
