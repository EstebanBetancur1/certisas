@extends('layouts.backoffice')

@section('css')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css" />
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<style>
       .highlighted {
        background-color: #0275d8 !important; 
        color: white;                
        }
    </style>

@endsection

@section('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
    <script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js">
</script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script>
    $(function () {

        // $('.select2').select2();

        $('.period-type').on("change", function () {
            periodoCombo($(this).val());
        });

        $('.datepicker1').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });

        $('.datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });

        $('.datepicker3').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });
    });

        ttableOne = $('#list-items-dc-1').DataTable({
            "dom": 'rt',
            ordering: false,
            language: {
                // search: '.search-data-form',
                lengthMenu: '',
                info: "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                emptyTable: "No se encontraron registros",
                paginate: {
                    previous: "<i class='icon-arrow-left'><i>",
                    next: "<i class='icon-arrow-right'><i>",
                    // last: "Ultimo"
                }
            },
        });
        $('.search-data-form input').keyup(function(){
            ttableOne.search($(this).val()).draw() ;
        })

        ttableTwo = $('#list-items-dc-2').DataTable({
            "dom": 'rt',
            ordering: false,
            language: {
                // search: '.search-data-form',
                lengthMenu: '',
                info: "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                emptyTable: "No se encontraron registros",
                paginate: {
                    previous: "<i class='icon-arrow-left'><i>",
                    next: "<i class='icon-arrow-right'><i>",
                    // last: "Ultimo"
                }
            },
        });
        $('.search-data-form input').keyup(function(){
            ttableTwo.search($(this).val()).draw() ;
        })

        ttableThree = $('#list-items-dc-3').DataTable({
            "dom": 'rt',
            ordering: false,
            language: {
                // search: '.search-data-form',
                lengthMenu: '',
                info: "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                emptyTable: "No se encontraron registros",
                paginate: {
                    previous: "<i class='icon-arrow-left'><i>",
                    next: "<i class='icon-arrow-right'><i>",
                    // last: "Ultimo"
                }
            },
        });
        $('.search-data-form input').keyup(function(){
            ttableThree.search($(this).val()).draw() ;
        })

    function periodoCombo(option) {

        if (option === "") {
            $(".input-period").attr("disabled", "disabled");
            $(".input-period").html("<option>- Seleccione</option>");
            return;
        }

        $.ajax({
            type: "GET",
            data: {},
            url: '{{ route("backoffice.emissions.combo") }}?o=' + option,
            dataType: 'html',
            success: function (result) {
                result = eval('(' + result + ')');

                if (result.status !== undefined) {
                    if (result.status === 'ok') {
                        if (result.html === "empty") {
                            $(".input-period").attr("disabled", "disabled");
                            $(".input-period").html("<option>- Seleccione</option>");
                        } else {
                            $(".input-period").removeAttr("disabled");
                            $(".input-period").html(result.html);
                        }
                    }
                }
            },
            error: function () {
                new Notyf({
                    delay: 3000
                }).error('Por favor, intente nuevamente');
            }
        });
    }

</script>

<script>
    $(document).ready(function() {
     var dataArray = []; // Hacer dataArray accesible globalmente dentro de este script
 
     // Cambiar el estado de selección de todas las filas
     $(document).on('click', '#all-rowsd', function() {
         var checked = $(this).find('input').prop('checked');
         dataArray = []; // Restablecer dataArray
 
         $(this).closest('table').find('tbody tr').each(function() {
             var checkbox = $(this).find('td:first-child input');
             checkbox.prop('checked', checked);
             $(this).toggleClass('highlighted', checked);
 
             if (checked) {
                 $('.btn-icon.table-action').removeClass('d-none');
                 dataArray.push({ id: $(this).find('td:nth-child(2)').text() });
             } else {
                 $('.btn-icon.table-action').addClass('d-none');
             }
         });
     });
 
     // Cambiar el estado de selección de una fila individual
     $(document).on('click', '.check_rows_cs_filedsd', function() {
         var checkbox = $(this);
         var row = checkbox.closest('tr');
         var id = row.find('td:nth-child(2)').text();
         var isChecked = checkbox.is(':checked');
 
         row.toggleClass('highlighted', isChecked);
         
         if (isChecked) {
             dataArray.push({ id: id });
         } else {
             dataArray = dataArray.filter(item => item.id !== id);
         }

         console.log('dataArray', dataArray);
 
         // Mostrar u ocultar el botón de acción
         var isAnyChecked = $('.check_rows_cs_filedsd').is(':checked');
         isAnyChecked ? $('.btn-icon.table-action').removeClass('d-none') : $('.btn-icon.table-action').addClass('d-none');
     });
 
     // Función para enviar datos para eliminar
     function sendDataToEliminate() {
         $('.deleteRows').on('click', function(e) {
             e.preventDefault();
             
             if (dataArray.length === 0) {
                 new Notyf().error('No has seleccionado ningún elemento.');
                 return;
                }
           
 
             var data = {
                 "_token": "{{ csrf_token() }}",
                 "data": dataArray
             };
             
             $.ajax({
                 type: "POST",
                 data: data,
                 url: '{{ route("backoffice.declarations.destroy") }}',
                 dataType: 'json',
                 success: function(result) {
                     if (result.hasOwnProperty('status') && result.status === 'success') {
                         if (result.hasOwnProperty('deletedCount')) {
                             if (result.deletedCount > 0) {
                                 let message = `${result.deletedCount} elemento(s) eliminado(s) correctamente`;
                                 new Notyf({ duration: 3000 }).success(message);
 
                                 setTimeout(function() {
                                     location.reload();
                                 }, 3000);
                             } else {
                                 new Notyf({ duration: 3000 }).error("No se eliminó ningún elemento.");
                             }
                         }
                     }
                 },
                 error: function(xhr, status, error) {
                     console.error("Error Response:", xhr);
                     console.error("Status:", status);
                     console.error("Error:", error);
                     new Notyf({
                         duration: 3000
                     }).error('Por favor, intente nuevamente');
                 }
             });
         });
     }
 
     sendDataToEliminate(); // Configurar el evento click para eliminar
 });
 </script>
 

@endsection

@section('page_title')
Declaraciones
@endsection

@section('content')

<div class="content">

    <div class="page-headline">
        <h4 class="page-title">Declaraciones</h4>
        <!-- <button data-buttonmodal="import-template" class="cs-btn btn-outline-secundary sm-btn modal-btn">Añadir
                    declaración</button> -->
    </div>

    <ul class="nav nav-tabs cs-tabs" id="myTab" role="tablist">
        <li class="tab-item" role="presentation">
            <a class="tab-link {{ (request()->input("tab") === "s1" || ! request()->has("tab")) ? 'active' : '' }}"
                id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true">Retenci&oacute;n a t&iacute;tulo de ventas
            </a>
        </li>

        <li class="tab-item" role="presentation">
            <a class="tab-link {{ (request()->input("tab") === "s2") ? 'active' : '' }}" id="profile-tab"
                data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">Retenci&oacute;n a t&iacute;tulo de renta
            </a>
        </li>

        <li class="tab-item" role="presentation">
            <a class="tab-link {{ (request()->input("tab") === "s3") ? 'active' : '' }}" id="contact-tab"
                data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Industria y
                comercio
            </a>
        </li>

    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade {{ (request()->input("tab") === "s1" || ! request()->has("tab")) ? 'show active' : '' }}"
            id="home" role="tabpanel" aria-labelledby="home-tab">

            <div>

                {{ Form::open(['url' => route('backoffice.declarations.index'), "class" => "", "method" => "get"]) }}

                <div class="content-header">
                    <div class="table-actions">
                        <button class="btn-icon open-filter" type="button">Filtrar<i class="icon-filter"></i></button>
                        <button class="btn-icon table-action d-none deleteRows">
                            <i class="icon-trash"></i>
                        </button>
                        <div class="filter-container">
                            <div class="cs-field select">
                                {!! Form::label('year', 'Año', ['class' => 'control-label'])
                                !!}
                                <div class="select-container">
                                    {!! Form::select('year', $years, (request()->input("tab") ===
                                    "s1")?request()->input("year"):null, ['class' => 'form-control
                                    select-type', 'placeholder' => 'Seleccione...']) !!}
                                </div>
                            </div>
                            <div class="cs-field select">
                                {!! Form::label('period', 'Per&iacute;odo', ['class' =>
                                'control-label']) !!}
                                <div class="select-container">
                                    @if((int)request()->input("period"))
                                    {!! Form::select('period', $periods, (request()->input("tab")
                                    === "s1")?request()->input("period"):null, ['class' =>
                                    'form-control select-type input-period', 'placeholder' => 'Seleccione...']) !!}
                                    @else
                                    {!! Form::select('period', $periods, null, ['class' =>
                                    'form-control select-type input-period', 'placeholder' => 'Seleccione...']) !!}
                                    @endif
                                </div>
                                @if ($errors->has('period'))
                                <p class="text-danger">{!! $errors->first('period') !!}</p>
                                @endif
                            </div>
                            <div class="filter-actions">
                                <a href="{{ route("backoffice.declarations.index", ['tab' => 's1']) }}"
                                    class="cs-btn secundary-action sm-btn">Limpiar filtro</a>
                                    <input type="hidden" name="tab" value="s1"/>
                                <button class="cs-btn btn-blue sm-btn ml-auto" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>
                        <button style="margin-left: auto; margin-right: 15px;" class="btn-icon modal-btn" data-buttonmodal="declaracion-tab-1" type="button"
                            rel="tooltip" data-placement="top" title="Agregar declaración"
                            ><i class="icon-statement"></i></button>
                        <div class="table-search">
                            <div class="search-data-form">
                                <button class="search-btn"><i class="icon-search"></i></button>
                                <input type="text" placeholder="Buscar">
                            </div>
                        </div>

                </div>

                {{ Form::close() }}

                <!-- <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#s1Modal">
                                        Agregar declaraci&oacute;n
                                    </button> -->

                <!-- <a href="{{ route("backoffice.declarations.index", ['tab' => 's1']) }}"
                                        class="btn btn-secondary">
                                        <i class="fa fa-eraser"></i>
                                    </a> -->

                <div class="cs-modal-container" data-modal="declaracion-tab-1">
                    <div class="modal-shade"></div>
                    <div class="cs-modal sm-modal">
                        <div class="cs-modal-content">
                            <div class="modal_header">
                                <h5 class="m-title">Agregar declaración</h5>
                                <button class="close-modal"><i class="icon-close"></i></button>
                            </div>
                            {{ Form::open(['url' => route('backoffice.declarations.store'), "class" => "", "method" => "post"]) }}


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                        {!! Form::label('year', 'Año', ['class' =>
                                        'control-label']) !!}
                                       <div class="select-container">
                                       {!! Form::select('year', $years, request()->input("year"),
                                        ['class' => 'form-control select-type', 'placeholder' => 'Seleccione...']) !!}
                                       </div>
                                        @if ($errors->has('year'))
                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                        {!! Form::label('period', 'Per&iacute;odo', ['class' =>
                                        'control-label']) !!}
                                        <div class="select-container">
                                            {!! Form::select('period', $periods,
                                        request()->input("perido"), ['class' => 'form-control
                                        select-period', 'placeholder' => 'Seleccione...']) !!}
                                        </div>

                                        @if ($errors->has('period'))
                                        <p class="text-danger">{!! $errors->first('period') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field">
                                        {!! Form::label('form', '350 - Declaración de Retención en
                                        la Fuente', ['class' => 'control-label']) !!}
                                        {!! Form::text('form', null, ['class' => 'form-control', 'placeholder' => 'Info declaración'])
                                        !!}
                                        @if ($errors->has('form'))
                                        <p class="text-danger">{!! $errors->first('form') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field">
                                        {!! Form::label('nro', '490- Recibo oficial de pago de
                                        Impuestos Nacionales', ['class' => 'control-label']) !!}
                                        {!! Form::text('nro', null, ['class' => 'form-control', 'placeholder' => 'Info recibo']) !!}
                                        @if ($errors->has('nro'))
                                        <p class="text-danger">{!! $errors->first('nro') !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="cs-field field select">
                                        {!! Form::label('bank_id', 'Banco', ['class' =>
                                        'control-label']) !!}
                                        <div class="select-container">
                                            {!! Form::select('bank_id', $banks, null, ['class' =>
                                            'form-control select-type', 'placeholder' => 'Seleccione...']) !!}
                                        </div>
                                        @if ($errors->has('bank_id'))
                                        <p class="text-danger">{!! $errors->first('bank_id') !!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="cs-field field date">
                                        {!! Form::label('date_payment', 'Fecha pago', ['class' =>
                                        'control-label']) !!}
                                        {!! Form::text('date_payment', null, ['class' =>
                                        'form-control datepicker1']) !!}
                                        @if ($errors->has('date_payment'))
                                        <p class="text-danger">{!! $errors->first('date_payment')
                                            !!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-3">
                                    <input type="hidden" name="type" value="1" />
                                    <input type="hidden" name="period_type" value="1" />
                                    <input type="hidden" name="tab" value="s1"/>
                                    <button type="submit" class="cs-btn btn-blue ml-auto">Guardar</button>

                                </div>

                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table id="list-items-dc-1">
                        <thead>
                            <tr>
                                <th>
                                    <div class="cs-field" id="all-rowsd">
                                        <input type="checkbox">
                                    </div>
                                </th>
                               
                                <th class="sm-col">Año</th>
                                <th class="sm-col">Per&iacute;odo</th>
                                <th class="align-top" width="25%">350 - Declaración de Rete Fuente</th>
                                <th class="align-top" width="25%">490 - Recibo oficial de pago</th>
                                <th class="align-top">Fecha de pago</th>
                                <th class="align-top">Banco de pago</th>
                                <th class="align-top">Fecha emisi&oacute;n</th>
                                {{-- <th class="align-top">Opciones</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if($items_1->count())
                            @foreach($items_1 as $item)
                            <tr>
                                <td>
                                    <div class="cs-field">
                                        <input type="checkbox" class="check_rows_cs_filedsd">
                                    </div>
                                </td>
                                <td class="d-none">{{ $item->id }}</td>
                                <td>{{ $item->year }}</td>
                                <td>{{ getPeriod(1, $item->period) }}</td>
                                <td>{{ $item->form }}</td>
                                <td>{{ $item->nro }}</td>
                                <td>{{ $item->date_payment }}</td>
                                <td>{{ $item->bank->name }}</td>
                                <td>{{ $item->date_emission }}</td>
                                {{-- <td>
                                    <div class="table-row-actions">
                                        <a href="#" class="">
                                            <i class="icon-edit"></i></a>
                                        <button data-buttonmodal="delete-table-item" class="modal-btn"><i
                                                class="icon-trash"></i></button>
                                    </div>
                                </td> --}}

                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="9">No se encontraron registros...</td>
                            </tr>
                            @endif

                        </tbody>

                    </table>
                </div>
            </div>

        </div>

        <div class="tab-pane fade {{ (request()->input("tab") === "s2") ? 'show active' : '' }}" id="profile"
            role="tabpanel" aria-labelledby="profile-tab">

            <div>

                {{ Form::open(['url' => route('backoffice.declarations.index'), "class" => "", "method" => "get"]) }}
                <div class="content-header">
                    <div class="table-actions">
                        <button class="btn-icon open-filter" type="button">Filtrar<i class="icon-filter"></i></button>
                        <button class="btn-icon table-action d-none deleteRows">
                            <i class="icon-trash"></i>
                        </button>
                        <div class="filter-container">
                            <div class="cs-field select">
                                {!! Form::label('year', 'Año', ['class' => 'control-label']) !!}
                                <div class="select-container">
                                    {!! Form::select('year', $years, (request()->input("tab") ===
                                    "s2")?request()->input("year"):null, ['class' => 'form-control select-type',
                                    'placeholder' => 'Seleccione...']) !!}
                                </div>
                                @if ($errors->has('year'))
                                <p class="text-danger">{!! $errors->first('year') !!}</p>
                                @endif
                            </div>
                            <div class="cs-field select">
                                {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label'])
                                !!}
                                <div class="select-container">
                                    @if((int)request()->input("period"))
                                    {!! Form::select('period', $periods, (request()->input("tab") ===
                                    "s2")?request()->input("period"):null, ['class' => 'form-control select-type
                                    input-period', 'placeholder' => 'Seleccione...']) !!}
                                    @else
                                    {!! Form::select('period', $periods, null, ['class' => 'form-control
                                    select-type input-period', 'placeholder' => 'Seleccione...']) !!}
                                    @endif
                                </div>
                                @if ($errors->has('period'))
                                <p class="text-danger">{!! $errors->first('period') !!}</p>
                                @endif
                            </div>
                            <div class="filter-actions">
                                <a href="{{ route("backoffice.declarations.index", ['tab' => 's1']) }}"
                                    class="cs-btn secundary-action sm-btn">Limpiar filtro</a>
                                    <input type="hidden" name="tab" value="s2"/>
                                <button class="cs-btn btn-blue sm-btn ml-auto" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>
                    
                    <button style="    margin-left: auto;
                    margin-right: 15px;" class="btn-icon modal-btn" data-buttonmodal="declaracion-tab-2" type="button"
                            rel="tooltip" data-placement="top" title="Agregar declaración"
                            ><i class="icon-statement"></i></button>
                        <div class="table-search">
                            <div class="search-data-form">
                                <button class="search-btn"><i class="icon-search"></i></button>
                                <input type="text" placeholder="Buscar">
                            </div>
                        </div>
                </div>

                {{ Form::close() }}

                <div class="cs-modal-container" data-modal="declaracion-tab-2">
                    <div class="modal-shade"></div>
                    <div class="cs-modal sm-modal">
                        <div class="cs-modal-content">
                            <div class="modal_header">
                                <h5 class="m-title">Agregar declaración</h5>
                                <button class="close-modal"><i class="icon-close"></i></button>
                            </div>
                            {{ Form::open(['url' => route('backoffice.declarations.store'), "class" => "", "method" => "post"]) }}


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                        {!! Form::label('year', 'Año', ['class' =>
                                        'control-label']) !!}
                                       <div class="select-container">
                                       {!! Form::select('year', $years, request()->input("year"),
                                            ['class' => 'form-control select-type', 'placeholder' => 'Seleccione...'])
                                            !!}
                                       </div>
                                        @if ($errors->has('year'))
                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                        {!! Form::label('period', 'Per&iacute;odo', ['class' =>
                                        'control-label']) !!}
                                        <div class="select-container">
                                            {!! Form::select('period', $periods,
                                        request()->input("perido"), ['class' => 'form-control
                                        select-period', 'placeholder' => 'Seleccione...']) !!}
                                        </div>

                                        @if ($errors->has('period'))
                                        <p class="text-danger">{!! $errors->first('period') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field">
                                        {!! Form::label('form', '350 - Declaración de Retención en
                                        la Fuente', ['class' => 'control-label']) !!}
                                        {!! Form::text('form', null, ['class' => 'form-control', 'placeholder' => 'Info declaración'])
                                        !!}
                                        @if ($errors->has('form'))
                                        <p class="text-danger">{!! $errors->first('form') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field">
                                        {!! Form::label('nro', '490- Recibo oficial de pago de
                                        Impuestos Nacionales', ['class' => 'control-label']) !!}
                                        {!! Form::text('nro', null, ['class' => 'form-control', 'placeholder' => 'Info recibo']) !!}
                                        @if ($errors->has('nro'))
                                        <p class="text-danger">{!! $errors->first('nro') !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="cs-field field select">
                                        {!! Form::label('bank_id', 'Banco', ['class' =>
                                        'control-label']) !!}
                                        <div class="select-container">
                                            {!! Form::select('bank_id', $banks, null, ['class' =>
                                            'form-control select-type', 'placeholder' => 'Seleccione...']) !!}
                                        </div>
                                        @if ($errors->has('bank_id'))
                                        <p class="text-danger">{!! $errors->first('bank_id') !!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="cs-field field date">
                                        {!! Form::label('date_payment', 'Fecha pago', ['class' =>
                                        'control-label']) !!}
                                        {!! Form::text('date_payment', null, ['class' =>
                                        'form-control datepicker2']) !!}
                                        @if ($errors->has('date_payment'))
                                        <p class="text-danger">{!! $errors->first('date_payment')
                                            !!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-3">

                                    <input type="hidden" name="type" value="2" />
                                    <input type="hidden" name="period_type" value="1" />
                                    <input type="hidden" name="tab" value="s2" />

                                    <button type="submit" class="cs-btn btn-blue ml-auto">Guardar</button>

                                </div>

                            </div>



                            {{ Form::close() }}
                        </div>
                    </div>
                </div>


                <div class="table-container">
                    <table id="list-items-dc-2">
                        <thead>
                            <tr>
                                <th>
                                    <div class="cs-field" id="all-rowsd">
                                        <input type="checkbox">
                                    </div>
                                </th>
                                <th class="sm-col">Año</th>
                                <th class="sm-col">Per&iacute;odo</th>
                                <th class="align-top" width="25%">350 - Declaración de Rete Fuente</th>
                                <th class="align-top" width="25%">490 - Recibo oficial de pago</th>
                                <th class="align-top">Fecha de pago</th>
                                <th class="align-top">Banco de pago</th>
                                <th class="align-top">Fecha emisi&oacute;n</th>
                                {{-- <th>Opciones</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if($items_2->count())
                            @foreach($items_2 as $item)
                            <tr>
                                <td>
                                    <div class="cs-field">
                                        <input type="checkbox" class="check_rows_cs_filedsd">
                                    </div>
                                </td>
                                <td class="d-none">{{ $item->id }}</td>
                                <td>{{ $item->year }}</td>
                                <td>{{ getPeriod(1, $item->period) }}</td>
                                <td>{{ $item->form }}</td>
                                <td>{{ $item->nro }}</td>
                                <td>{{ $item->date_payment }}</td>
                                <td>{{ $item->bank->name }}</td>
                                <td>{{ $item->date_emission }}</td>
                                {{-- <td>
                                    <div class="table-row-actions">
                                        <a href="#" class="">
                                            <i class="icon-edit"></i></a>
                                        <button data-buttonmodal="delete-table-item" class="modal-btn"><i
                                                class="icon-trash"></i></button>
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="9">No se encontraron registros...</td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade {{ (request()->input("tab") === "s3") ? 'show active' : '' }}" id="contact"
            role="tabpanel" aria-labelledby="contact-tab">

            <div>


                {{ Form::open(['url' => route('backoffice.declarations.index'), "class" => "", "method" => "get"]) }}
                <div class="content-header">
                    <div class="table-actions">
                        <button class="btn-icon open-filter" type="button">Filtrar<i class="icon-filter"></i></button>
                        <button class="btn-icon table-action d-none deleteRows">
                            <i class="icon-trash"></i>
                        </button>
                        <div class="filter-container">
                            <div class="cs-field select">
                                {!! Form::label('year', 'Año', ['class' => 'control-label'])
                                !!}
                                <div class="select-container">
                                    {!! Form::select('year', $years, (request()->input("tab") ===
                                    "s3")?request()->input("year"):null, ['class' => 'form-control select-type',
                                    'placeholder' => 'Seleccione...']) !!}
                                </div>
                                @if ($errors->has('year'))
                                <p class="text-danger">{!! $errors->first('year') !!}</p>
                                @endif
                            </div>
                            <div class="cs-field select">
                                {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}

                                @php
                                $_periods = $periods_bimestral;

                                $_periods[-1] = "Todos el año";
                                @endphp
                                <div class="select-container">
                                    @if((int)request()->input("period"))
                                    {!! Form::select('period', $_periods, (request()->input("tab") ===
                                    "s3")?request()->input("period"):null, ['class' => 'form-control select-type
                                    input-period', 'placeholder' => 'Seleccione...']) !!}
                                    @else
                                    {!! Form::select('period', $_periods, null, ['class' => 'form-control
                                    select-type input-period', 'placeholder' => 'Seleccione...']) !!}
                                    @endif
                                </div>
                                @if ($errors->has('period'))
                                <p class="text-danger">{!! $errors->first('period') !!}</p>
                                @endif
                            </div>
                            <div class="filter-actions">
                                <a href="{{ route("backoffice.declarations.index", ['tab' => 's3']) }}"
                                    class="cs-btn secundary-action sm-btn">Limpiar filtro</a>
                                    <input type="hidden" name="tab" value="s3"/>
                                    
                                <button class="cs-btn btn-blue sm-btn ml-auto" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>
                        <button style="margin-left: auto; margin-right: 15px;"
                         class="btn-icon modal-btn" data-buttonmodal="declaracion-tab-3" type="button"
                            rel="tooltip" data-placement="top" title="Agregar declaración"
                            ><i class="icon-statement"></i></button>
                        <div class="table-search">
                            <div class="search-data-form">
                                <button class="search-btn"><i class="icon-search"></i></button>
                                <input type="text" placeholder="Buscar">
                            </div>
                        </div>

                </div>

                {{ Form::close() }}

                <div class="cs-modal-container" data-modal="declaracion-tab-3">
                    <div class="modal-shade"></div>
                    <div class="cs-modal sm-modal">
                        <div class="cs-modal-content">
                            <div class="modal_header">
                                <h5 class="m-title">Agregar declaración</h5>
                                <button class="close-modal"><i class="icon-close"></i></button>
                            </div>
                            {{ Form::open(['url' => route('backoffice.declarations.store'), "class" => "", "method" => "post"]) }}


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                        {!! Form::label('year', 'Año', ['class' =>
                                        'control-label']) !!}
                                       <div class="select-container">
                                       {!! Form::select('year', $years, request()->input("year"),
                                            ['class' => 'form-control select-type', 'placeholder' => 'Seleccione...'])
                                            !!}
                                       </div>
                                        @if ($errors->has('year'))
                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                        {!! Form::label('period', 'Per&iacute;odo', ['class' =>
                                        'control-label']) !!}
                                        <div class="select-container">
                                            {!! Form::select('period', $periods,
                                        request()->input("perido"), ['class' => 'form-control
                                        select-period', 'placeholder' => 'Seleccione...']) !!}
                                        </div>

                                        @if ($errors->has('period'))
                                        <p class="text-danger">{!! $errors->first('period') !!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field">
                                    {!! Form::label('declaration', 'Declaración',
                                            ['class' => 'control-label']) !!}
                                            {!! Form::text('declaration', null, ['class' =>
                                            'form-control']) !!}
                                            @if ($errors->has('declaration'))
                                            <p class="text-danger">{!! $errors->first('declaration') !!}
                                            </p>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="cs-field field select">
                                            {!! Form::label('municipality_id', 'Municipio', ['class' =>
                                            'control-label']) !!}
                                           <div class="select-container">
                                           {!! Form::select('municipality_id', $municipalities, null,
                                            ['class' => 'form-control select2']) !!}
                                           </div>
                                            @if ($errors->has('municipality_id'))
                                            <p class="text-danger">{!! $errors->first('municipality_id')
                                                !!}</p>
                                            @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="cs-field field select">
                                        {!! Form::label('bank_id', 'Banco', ['class' =>
                                        'control-label']) !!}
                                        <div class="select-container">
                                            {!! Form::select('bank_id', $banks, null, ['class' =>
                                            'form-control select-type', 'placeholder' => 'Seleccione...']) !!}
                                        </div>
                                        @if ($errors->has('bank_id'))
                                        <p class="text-danger">{!! $errors->first('bank_id') !!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="cs-field field date">
                                        {!! Form::label('date_payment', 'Fecha pago', ['class' =>
                                        'control-label']) !!}
                                        {!! Form::text('date_payment', null, ['class' =>
                                        'form-control datepicker3']) !!}
                                        @if ($errors->has('date_payment'))
                                        <p class="text-danger">{!! $errors->first('date_payment')
                                            !!}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-3">

                                    <input type="hidden" name="type" value="3" />
                                    <input type="hidden" name="period_type" value="1" />
                                    <input type="hidden" name="tab" value="s3" />

                                    <button type="submit" class="cs-btn btn-blue ml-auto">Guardar</button>

                                </div>

                            </div>

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>


                <div class="table-container">
                    <table id="list-items-dc-3">
                        <thead>
                            <tr>
                                <th>
                                    <div class="cs-field" id="all-rowsd">
                                        <input type="checkbox">
                                    </div>
                                </th>
                                <th class="sm-col">Año</th>
                                <th class="sm-col">Per&iacute;odo</th>
                                <th>Declaraci&oacute;n</th>
                                <th>Municipio</th>
                                <th>Fecha de emisi&oacute;n</th>
                                <th>Fecha pago</th>
                                {{-- <th>Opciones</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if($items_3->count())
                            @foreach($items_3 as $item)
                            <tr>
                                <td>
                                    <div class="cs-field">
                                        <input type="checkbox" class="check_rows_cs_filedsd">
                                    </div>
                                </td>
                                <td class="d-none">{{ $item->id }}</td>
                                <td>{{ $item->year }}</td>
                                <td>{{ getPeriod(2, $item->period) }}</td>
                                <td>{{ $item->declaration }}</td>
                                <td>{{ $item->municipality->name }}</td>
                                <td>{{ $item->date_emission }}</td>
                                <td>{{ $item->date_payment }}</td>
                                {{-- <td>
                                    <div class="table-row-actions">
                                        <a href="#" class="">
                                            <i class="icon-edit"></i></a>
                                        <button data-buttonmodal="delete-table-item" class="modal-btn"><i
                                                class="icon-trash"></i></button>
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">No se encontraron registros...</td>
                            </tr>
                            @endif

                        </tbody>

                    </table>
                </div>


            </div>

        </div>
    </div>

</div>

@endsection
