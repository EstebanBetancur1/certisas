@extends('layouts.backoffice')

@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css" />
@endsection

@section('js')
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js">
</script>

<style>
    #list-items input[type='text'] {
        color: #575757;
        background-color: #fff;
        border: 1px solid #d8e1e1;
        height: calc(1.142857em + .714286rem + 2px);
        padding: .357143rem .6429rem;
        font-size: 1rem;
        line-height: 1.142857;
        border-radius: .2rem
    }

    .btn-tickets .fa {
        color: #f7bd00;
    }

</style>

<script>
    $(function () {
        $('.period-type').on("change", function () {
            periodoCombo($(this).val());
        });

        $('.select-type').on("change", function () {
            if ($(this).val() === "3") {
                $(".select-city").removeAttr("disabled");
            } else {
                $(".select-city").attr("disabled", "disabled");
            }
        });

        var table = $('#list-items').DataTable({
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
            table.search($(this).val()).draw();
        });
    });

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
@endsection

@section('page_title')
Mis Certificados
@endsection


@section('content')

<div class="content">
    <div>
        <h4 class="page-title"> Mis Certificados </h4>
        <!-- <a href="{{ route('backoffice.account.dashboard') }}" class="btn btn-secondary">Volver</a> -->

        <div class="content-header">
            <div class="table-actions">
                <button class="btn-icon open-filter">Filtrar<i class="icon-filter"></i></button>
                <button class="btn-icon table-action d-none"><i class="icon-trash"></i></button>
                {{ Form::open(['url' => route('backoffice.emissions.my.certificates'), "class" => "filter-container", "method" => "get"]) }}

                <div class="cs-field select">
                    {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                    <div class="select-container">
                        {!! Form::select('type', [
                        "1" => "Certificado de retenci&oacute;n a t&iacute;tulo de ventas",
                        "2" => "Certificado de retenci&oacute;n a t&iacute;tulo de renta",
                        "3" => "Certificado de industria y comercio"
                        ], request()->input("type"), ['placeholder' => 'Seleccione...', 'class'=>'select-type']) !!}
                    </div>
                    @if ($errors->has('type'))
                    <p class="text-danger">{!! $errors->first('type') !!}</p>
                    @endif

                </div>
                <div class="cs-field select">
                    {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                    <div class="select-container">
                        {!! Form::select('year', $years, request()->input("year"), ['placeholder' => 'Seleccione...'])
                        !!}
                    </div>
                    @if ($errors->has('year'))
                    <p class="text-danger">{!! $errors->first('year') !!}</p>
                    @endif

                </div>
                <div class="cs-field select">
                    {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}

                    @if((int)request()->input("city"))
                        <div class="select-container">
                            {!! Form::select('city', $cities, request()->input("city"), ['class' => 'select-city',
                            'placeholder' => 'Seleccione...']) !!}
                        </div>
                    @else
                        <div class="select-container">
                            {!! Form::select('city', $cities, null, ['class' => 'select-city', 'placeholder' =>
                            'Seleccione...',
                            'disabled' => 'disabled']) !!}
                        </div>
                    @endif

                    @if ($errors->has('city_id'))
                    <p class="text-danger">{!! $errors->first('city_id') !!}</p>
                    @endif

                </div>
                <div class="filter-actions">
                    <a href="{{ route("backoffice.emissions.my.certificates") }}"
                        class="cs-btn secundary-action sm-btn">Limpiar filtro</a>
                    <button class="cs-btn btn-blue sm-btn ml-auto" type="submit">Filtrar</button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="table-search">
                <form action="" class="search-data-form">
                    <button class="search-btn"><i class="icon-search"></i></button>
                    <input type="text" placeholder="Buscar">
                </form>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table id="list-items">
            <thead>
                <tr>
                    <th>
                        <div class="cs-field" id="all-rows"><input type="checkbox"></div>
                    </th>
                    <th class="sm-col">Nit</th>
                    <th class="big-col">Emisor</th>
                    <th>Periodo</th>
                    <th>Fecha emision</th>
                    <th class="sm-col text-center">Opciones</th>
                </tr>
                {{-- <tr>
                    <th></th>
                    <th>Nit</th>
                    <th class="big-col">Emisor</th>
                    <th>Periodo</th>
                    <th class="sm-col"></th>
                </tr> --}}
            </thead>
            <tbody>
                {{-- <tr>
                    <td>
                        <div class="cs-field"><input type="checkbox" class="table-checkbox-row"></div>
                    </td>
                    <td>
                        <div class="company-name">
                            <p>Some interesting example company name</p>
                        </div>
                    </td>
                    <td>Algo cool aquí</td>
                    <td>Algo cool aquí</td>
                    <td>
                        <div class="table-row-actions">
                        <button><i class="icon-file-pdf"></i></button>
                            <button><i class="icon-file-excel"></i></button>
                            <button><i class="icon-alert"></i></button>
                        </div>
                    </td>
                </tr> --}}
                @if($items->count())
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="cs-field"><input type="checkbox" class="table-checkbox-row"></div>
                        </td>
                        <td>{{ $item->agent_nit }}</td>
                        <td>{{ $item->agent_name }}</td>
                        <td>{{ ((int)$item->period_type === 1 || (int)$item->period_type === 2)?getPeriod($item->period_type, $item->period):"Todo el " . $item->year  }}
                        <td>{{ $item->created_at }}</td>

                        </td>
                        <td class="text-center">
                            <div class="table-row-actions">
                                <a target="_blank"
                                    href="{{ route("backoffice.emissions.declaration", ["id" => $item->id]) }}">
                                    <i class="icon-file-pdf"></i>
                                </a>
                                <a target="_blank"
                                    href="{{ route("backoffice.emissions.my.certificates.export", ["id" => $item->id]) }}">
                                    <i class="icon-file-excel"></i>
                                </a>
                                <!-- <a href="{{ route("backoffice.tickets.emission", ["id" => $item->id]) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Crear Ticket">
                                    <i class="icon-alert" aria-hidden="true"></i>
                                </a> -->
                                <button type="button" data-buttonmodal="ticket-certify{{$item->agent_nit}}{{ $item->id }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Crear Ticket" class=" modal-btn">
                                    <i class="icon-alert" aria-hidden="true"></i>
                                </button>
                                {{-- <a href="{{ route("backoffice.tickets.emission", ["id" => $item->id]) }}" class="btn btn-sm btn-secondary btn-tickets" data-bs-toggle="tooltip" data-bs-placement="top" title="Crear Ticket"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> </a> --}}
                            </div>
                        </td>
                    </tr>
                    <div class="cs-modal-container" data-modal="ticket-certify{{$item->agent_nit}}{{ $item->id }}">
                        <div class="modal-shade"></div>
                        <div class="cs-modal sm-modal">
                            <div class="cs-modal-content">
                                <div class="modal_header">
                                  <h4 class="m-title">Crear ticket</h4>
                                  <button class="close-modal"><i class="icon-close"></i></button>
                                </div>
                                <p>Ticket para: {{$item->agent_name}}</p>
                                <form method="post" enctype="multipart/form-data" action="{{ route("backoffice.tickets.sendtikect") }}" 
                                >
                                    @csrf
                                  <div class="cs-field field">
                                      <label for="">Asunto</label>
                                      <input type="text" placeholder="Motivo del ticket" name="subject" readonly 
                                    value="@if($item->type === 1)CERTIFICADO DE RETENCI&Oacute;N A T&Iacute;TULO DE VENTAS {{ datetimeFormat($item->created_at, 'Y') }} @if($item->period_type === 1)Mensual {{ $item->period }}@endif @if($item->period_type === 1 || $item->period_type === 2)({{ getPeriod($item->period_type, $item->period) }}) @endif @if($item->period_type === 3)(Anual)@endif @elseif($item->type === 2)CERTIFICADO DE RETENCI&Oacute;N A T&Iacute;TULO DE RENTA @if($item->period_type === 1)Mensual {{ $item->period }} @endif @if($item->period_type === 1 || $item->period_type === 2) ({{ getPeriod($item->period_type, $item->period) }})@endif @if($item->period_type === 3)(Anual) @endif @elseif($item->type === 3)CERTIFICADO DE INDUSTRIA Y COMERCIO @if($item->period_type === 1)Mensual {{ $item->period }} @endif @if($item->period_type === 1 || $item->period_type === 2)({{ getPeriod($item->period_type,$item->period) }})@endif @if($item->period_type === 3)(Anual)
                                    @endif @endif">
                                  </div>
                                  <div class="cs-field field">
                                        <label for="our-rut" class="bold">Archivos de evidencia</label>
                                        <input type="file">
                                  </div>
                
                                  <div class="cs-field field">
                                      <label for="">Mensaje</label>
                                      <textarea name="message" id=""  rows="3" placeholder="Deja un mensaje"></textarea>
                                  </div>
                                  <input type="hidden" name="receiver_id" value="{{$item->company_id}}">
                                    <input type="hidden" name="user_id" value="{{$item->user_id}}">
                                    <input type="hidden" name="emission_id" value="{{$item->id}}">
                                  <button class="cs-btn btn-blue ml-auto ">Enviar ticket</button>
                                </form>
                
                            </div>
                        </div>
                </div>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5">No se encontraron registros</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>




    <!-- <div class="row">

        <div class="col-12">

            <div class="block">

                <div class="block-content">

                    {{ Form::open(['url' => route('backoffice.emissions.my.certificates'), "class" => "", "method" => "get"]) }}
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                                {!! Form::select('type', ["1" => "Certificado de retenci&oacute;n a t&iacute;tulo de
                                ventas", "2" => "Certificado de retenci&oacute;n a t&iacute;tulo de renta", "3" =>
                                "Certificado de industria y comercio"], request()->input("type"), ['class' =>
                                'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('type'))
                                <p class="text-danger">{!! $errors->first('type') !!}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control',
                                'placeholder' => '- Seleccione']) !!}
                                @if ($errors->has('year'))
                                <p class="text-danger">{!! $errors->first('year') !!}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}

                                @if((int)request()->input("city"))
                                {!! Form::select('city', $cities, request()->input("city"), ['class' => 'form-control
                                select-city', 'placeholder' => '- Seleccione']) !!}
                                @else
                                {!! Form::select('city', $cities, null, ['class' => 'form-control select-city',
                                'placeholder' => '- Seleccione', 'disabled' => 'disabled']) !!}
                                @endif

                                @if ($errors->has('city_id'))
                                <p class="text-danger">{!! $errors->first('city_id') !!}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group" style="padding-top: 25px">
                                <div class="btn-group">
                                    <button type="submit" class="cs-btn btn-blue sm-btn">
                                        Buscar
                                    </button>
                                    <a href="{{ route("backoffice.emissions.my.certificates") }}" class="icon-btn"><i
                                            class="icon-erase"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">

                            <div class="form-group" style="padding-top: 25px">
                                @if($items->count())
                                <a target="_blank"
                                    href="{{ route("backoffice.emissions.my.certificates.export.all", ["emissions" => json_encode($emissions)]) }}"
                                    class="btn btn-success">
                                    <i class="fa fa-file-excel-o"></i> Exportar detalle
                                </a>
                                @endif
                            </div>

                        </div>

                    </div>

                    {{ Form::close() }}

                    <hr />

                    <table id="list-items" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10%">Nit</th>
                                <th>Emisor</th>
                                <th width="15%">Periodo</th>
                                <th width="12%">Opciones</th>
                            </tr>
                            <tr>
                                <th width="10%">Nit</th>
                                <th>Emisor</th>
                                <th width="15%">Periodo</th>
                                <th width="12%"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($items->count())
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $item->agent_nit }}</td>
                                <td>{{ $item->agent_name }}</td>
                                <td>{{ ((int)$item->period_type === 1 || (int)$item->period_type === 2)?getPeriod($item->period_type, $item->period):"Todo el " . $item->year  }}
                                </td>
                                <td class="text-center">
                                    <a target="_blank"
                                        href="{{ route("backoffice.emissions.declaration", ["id" => $item->id]) }}"
                                        class="btn btn-sm btn-primary"> <i class="fa fa-file-pdf-o"></i> </a>
                                    <a target="_blank"
                                        href="{{ route("backoffice.emissions.my.certificates.export", ["id" => $item->id]) }}"
                                        class="btn btn-sm btn-success"> <i class="fa fa-file-excel-o"></i> </a>
                                    <a href="{{ route("backoffice.tickets.emission", ["id" => $item->id]) }}"
                                        class="btn btn-sm btn-secondary btn-tickets" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Crear Ticket"> <i
                                            class="fa fa-exclamation-triangle" aria-hidden="true"></i> </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No se encontraron registros</td>
                            </tr>
                            @endif

                        </tbody>

                    </table>


                </div>
            </div>

        </div>

    </div> -->
</div>



@endsection
