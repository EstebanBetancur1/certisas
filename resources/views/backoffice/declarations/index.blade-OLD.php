@extends('layouts.backoffice')

@section('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    {{-- <style>
        .select2.select2-container{
            width: 100%!important;
        }
    </style> --}}

@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $(function () {

            // $('.select2').select2();

            $('.period-type').on("change", function(){
                periodoCombo($(this).val());
            });

            $('.datepicker1').datepicker({
                uiLibrary: 'bootstrap4',
                format:'yyyy-mm-dd'
            });

            $('.datepicker2').datepicker({
                uiLibrary: 'bootstrap4',
                format:'yyyy-mm-dd'
            });

            $('.datepicker3').datepicker({
                uiLibrary: 'bootstrap4',
                format:'yyyy-mm-dd'
            });
        });

        function periodoCombo(option){

            if(option === ""){
                $(".input-period").attr("disabled", "disabled");
                $(".input-period").html("<option>- Seleccione</option>");
                return;
            }

            $.ajax({
                type: "GET",
                data: {},
                url: '{{ route("backoffice.emissions.combo") }}?o='+option,
                dataType: 'html',
                success: function (result){
                    result = eval('(' + result + ')');

                    if(result.status !== undefined){
                        if(result.status === 'ok'){

                            if(result.html === "empty"){
                                $(".input-period").attr("disabled", "disabled");
                                $(".input-period").html("<option>- Seleccione</option>");
                            }else{
                                $(".input-period").removeAttr("disabled");
                                $(".input-period").html(result.html);
                            }
                        }
                    }
                },
                error: function(){
                    new Notyf({delay:3000}).error('Por favor, intente nuevamente');
                }
            });
        }

    </script>
@endsection

@section('page_title')
    Declaraciones
@endsection

@section('content')

    <div class="content">

        <!--
        <div class="row">
            <div class="col-md-8">
                <h2>
                    Declaraciones
                </h2>
            </div>
            <div class="col-md-4 text-right">

            </div>
        </div>
        -->

        <div class="row">

            <div class="col-12">

                <div class="block">

                    <div class="block-content">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ (request()->input("tab") === "s1" || ! request()->has("tab")) ? 'active' : '' }}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Retenci&oacute;n a t&iacute;tulo de ventas</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ (request()->input("tab") === "s2") ? 'active' : '' }}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Retenci&oacute;n a t&iacute;tulo de renta</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ (request()->input("tab") === "s3") ? 'active' : '' }}" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Industria y comercio</a>
                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade {{ (request()->input("tab") === "s1" || ! request()->has("tab")) ? 'show active' : '' }}" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <div style="padding-top: 20px;">

                                        <div class="row">

                                            <div class="col-7">

                                                {{ Form::open(['url' => route('backoffice.declarations.index'), "class" => "", "method" => "get"]) }}
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <div class="form-group">
                                                                {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                                {!! Form::select('year', $years, (request()->input("tab") === "s1")?request()->input("year"):null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                                @if ($errors->has('year'))
                                                                    <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-5">
                                                            <div class="form-group">
                                                                {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}

                                                                @if((int)request()->input("period"))
                                                                    {!! Form::select('period', $periods,  (request()->input("tab") === "s1")?request()->input("period"):null, ['class' => 'form-control select-type input-period', 'placeholder' => '- Seleccione']) !!}
                                                                @else
                                                                    {!! Form::select('period', $periods, null, ['class' => 'form-control select-type input-period', 'placeholder' => '- Seleccione']) !!}
                                                                @endif

                                                                @if ($errors->has('period'))
                                                                    <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group" style="padding-top: 25px">

                                                                <input type="hidden" name="tab" value="s1"/>

                                                                <button type="submit" class="btn btn-primary">
                                                                    Filtrar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{ Form::close() }}

                                            </div>

                                            <div class="col-lg-4">

                                                <div class="form-group" style="padding-top: 25px">

                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#s1Modal">
                                                        Agregar declaraci&oacute;n
                                                    </button>

                                                    <a href="{{ route("backoffice.declarations.index", ['tab' => 's1']) }}" class="btn btn-secondary">
                                                        <i class="fa fa-eraser"></i>
                                                    </a>

                                                </div>

                                                <div class="modal fade" id="s1Modal" tabindex="-1" aria-labelledby="docModal" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">

                                                      <div class="modal-header">

                                                        <h5 class="modal-title" id="exampleModalLabel">Agregar declaraci&oacute;n</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>

                                                      </div>

                                                      <div class="modal-body text-left">

                                                        {{ Form::open(['url' => route('backoffice.declarations.store'), "class" => "", "method" => "post"]) }}

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                                        {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                                        @if ($errors->has('year'))
                                                                            <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}
                                                                        {!! Form::select('period', $periods, request()->input("perido"), ['class' => 'form-control select-period', 'placeholder' => '- Seleccione']) !!}
                                                                        @if ($errors->has('period'))
                                                                            <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        {!! Form::label('form', '350 - Declaración de Retención en la Fuente', ['class' => 'control-label']) !!}
                                                                        {!! Form::text('form', null, ['class' => 'form-control']) !!}
                                                                        @if ($errors->has('form'))
                                                                            <p class="text-danger">{!! $errors->first('form') !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        {!! Form::label('nro', '490- Recibo oficial de pago  de Impuestos Nacionales', ['class' => 'control-label']) !!}
                                                                        {!! Form::text('nro', null, ['class' => 'form-control']) !!}
                                                                        @if ($errors->has('nro'))
                                                                            <p class="text-danger">{!! $errors->first('nro') !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        {!! Form::label('bank_id', 'Banco', ['class' => 'control-label']) !!}

                                                                        {!! Form::select('bank_id', $banks, null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}

                                                                        @if ($errors->has('bank_id'))
                                                                            <p class="text-danger">{!! $errors->first('bank_id') !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        {!! Form::label('date_payment', 'Fecha pago', ['class' => 'control-label']) !!}
                                                                        {!! Form::text('date_payment', null, ['class' => 'form-control datepicker1']) !!}
                                                                        @if ($errors->has('date_payment'))
                                                                            <p class="text-danger">{!! $errors->first('date_payment') !!}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-6">

                                                                    <input type="hidden" name="type" value="1"/>
                                                                    <input type="hidden" name="period_type" value="1"/>
                                                                    <input type="hidden" name="tab" value="s1"/>

                                                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                                                </div>
                                                            </div>

                                                        {{ Form::close() }}

                                                      </div>

                                                    </div>
                                                  </div>
                                                </div>

                                            </div>

                                        </div>

                                    <hr />

                                    <table id="list-items" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="align-top">A&ntilde;o</th>
                                            <th class="align-top">Per&iacute;odo</th>
                                            <th class="align-top" width="25%">350 - Declaración de Rete Fuente</th>
                                            <th class="align-top" width="25%">490 - Recibo oficial de pago</th>
                                            <th class="align-top">Fecha de pago</th>
                                            <th class="align-top">Banco de pago</th>
                                            <th class="align-top">Fecha de emisi&oacute;n</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($items_1->count())
                                                @foreach($items_1 as $item)
                                                    <tr>
                                                        <td>{{ $item->year }}</td>
                                                        <td>{{ getPeriod(1, $item->period) }}</td>
                                                        <td>{{ $item->form }}</td>
                                                        <td>{{ $item->nro }}</td>
                                                        <td>{{ $item->date_payment }}</td>
                                                        <td>{{ $item->bank->name }}</td>
                                                        <td>{{ $item->date_emission }}</td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7">No se encontraron registros...</td>
                                                </tr>
                                            @endif

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                            <div class="tab-pane fade {{ (request()->input("tab") === "s2") ? 'show active' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <div style="padding-top: 20px;">

                                    <div class="row">

                                        <div class="col-7">

                                            {{ Form::open(['url' => route('backoffice.declarations.index'), "class" => "", "method" => "get"]) }}
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                            {!! Form::select('year', $years, (request()->input("tab") === "s2")?request()->input("year"):null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                            @if ($errors->has('year'))
                                                                <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}

                                                            @if((int)request()->input("period"))
                                                                {!! Form::select('period', $periods,  (request()->input("tab") === "s2")?request()->input("period"):null, ['class' => 'form-control select-type input-period', 'placeholder' => '- Seleccione']) !!}
                                                            @else
                                                                {!! Form::select('period', $periods, null, ['class' => 'form-control select-type input-period', 'placeholder' => '- Seleccione']) !!}
                                                            @endif

                                                            @if ($errors->has('period'))
                                                                <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group" style="padding-top: 25px">

                                                            <input type="hidden" name="tab" value="s2"/>

                                                            <button type="submit" class="btn btn-primary">
                                                                Filtrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}

                                        </div>

                                        <div class="col-lg-4">

                                            <div class="form-group" style="padding-top: 25px">

                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#s2Modal">
                                                    Agregar declaraci&oacute;n
                                                </button>

                                                <a href="{{ route("backoffice.declarations.index", ['tab' => 's2']) }}" class="btn btn-secondary">
                                                    <i class="fa fa-eraser"></i>
                                                </a>

                                            </div>

                                            <div class="modal fade" id="s2Modal" tabindex="-1" aria-labelledby="docModal" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">

                                                  <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Agregar declaraci&oacute;n</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                  </div>

                                                  <div class="modal-body text-left">

                                                    {{ Form::open(['url' => route('backoffice.declarations.store'), "class" => "", "method" => "post"]) }}

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                                    {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                                    @if ($errors->has('year'))
                                                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}
                                                                    {!! Form::select('period', $periods, request()->input("perido"), ['class' => 'form-control select-period', 'placeholder' => '- Seleccione']) !!}
                                                                    @if ($errors->has('period'))
                                                                        <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('form', '350 - Declaración de Retención en la Fuente', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('form', null, ['class' => 'form-control']) !!}
                                                                    @if ($errors->has('form'))
                                                                        <p class="text-danger">{!! $errors->first('form') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('nro', '490- Recibo oficial de pago  de Impuestos Nacionales', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('nro', null, ['class' => 'form-control']) !!}
                                                                    @if ($errors->has('nro'))
                                                                        <p class="text-danger">{!! $errors->first('nro') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    {!! Form::label('bank_id', 'Banco', ['class' => 'control-label']) !!}

                                                                    {!! Form::select('bank_id', $banks, null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}

                                                                    @if ($errors->has('bank_id'))
                                                                        <p class="text-danger">{!! $errors->first('bank_id') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    {!! Form::label('date_payment', 'Fecha pago', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('date_payment', null, ['class' => 'form-control datepicker2']) !!}
                                                                    @if ($errors->has('date_payment'))
                                                                        <p class="text-danger">{!! $errors->first('date_payment') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">

                                                                <input type="hidden" name="type" value="2"/>
                                                                <input type="hidden" name="period_type" value="1"/>
                                                                <input type="hidden" name="tab" value="s2"/>

                                                                <button type="submit" class="btn btn-primary">Guardar</button>

                                                            </div>
                                                        </div>

                                                    {{ Form::close() }}

                                                  </div>

                                                </div>
                                              </div>
                                            </div>

                                        </div>

                                    </div>

                                    <hr />

                                    <table id="list-items" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="align-top">A&ntilde;o</th>
                                            <th class="align-top">Per&iacute;odo</th>
                                            <th class="align-top" width="25%">350 - Declaración de Rete Fuente</th>
                                            <th class="align-top" width="25%">490 - Recibo oficial de pago</th>
                                            <th class="align-top">Fecha de pago</th>
                                            <th class="align-top">Banco de pago</th>
                                            <th class="align-top">Fecha de emisi&oacute;n</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($items_2->count())
                                                @foreach($items_2 as $item)
                                                    <tr>
                                                        <td>{{ $item->year }}</td>
                                                        <td>{{ getPeriod(1, $item->period) }}</td>
                                                        <td>{{ $item->form }}</td>
                                                        <td>{{ $item->nro }}</td>
                                                        <td>{{ $item->date_payment }}</td>
                                                        <td>{{ $item->bank->name }}</td>
                                                        <td>{{ $item->date_emission }}</td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7">No se encontraron registros...</td>
                                                </tr>
                                            @endif

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                            <div class="tab-pane fade {{ (request()->input("tab") === "s3") ? 'show active' : '' }}" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                                <div style="padding-top: 20px;">

                                    <div class="row">

                                        <div class="col-7">

                                            {{ Form::open(['url' => route('backoffice.declarations.index'), "class" => "", "method" => "get"]) }}
                                                <div class="row">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                            {!! Form::select('year', $years, (request()->input("tab") === "s3")?request()->input("year"):null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                            @if ($errors->has('year'))
                                                                <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}

                                                            @php
                                                                $_periods = $periods_bimestral;

                                                                $_periods[-1] = "Todos el año";
                                                            @endphp

                                                            @if((int)request()->input("period"))
                                                                {!! Form::select('period', $_periods,  (request()->input("tab") === "s3")?request()->input("period"):null, ['class' => 'form-control select-type input-period', 'placeholder' => '- Seleccione']) !!}
                                                            @else
                                                                {!! Form::select('period', $_periods, null, ['class' => 'form-control select-type input-period', 'placeholder' => '- Seleccione']) !!}
                                                            @endif

                                                            @if ($errors->has('period'))
                                                                <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group" style="padding-top: 25px">

                                                            <input type="hidden" name="tab" value="s3"/>

                                                            <button type="submit" class="btn btn-primary">
                                                                Filtrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}

                                        </div>

                                        <div class="col-lg-4">

                                            <div class="form-group" style="padding-top: 25px">

                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#s3Modal">
                                                    Agregar declaraci&oacute;n
                                                </button>

                                                <a href="{{ route("backoffice.declarations.index", ['tab' => 's3']) }}" class="btn btn-secondary">
                                                    <i class="fa fa-eraser"></i>
                                                </a>

                                            </div>

                                            <div class="modal fade" id="s3Modal" tabindex="-1" aria-labelledby="docModal" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">

                                                  <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Agregar declaraci&oacute;n</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                  </div>

                                                  <div class="modal-body text-left">

                                                    {{ Form::open(['url' => route('backoffice.declarations.store'), "class" => "", "method" => "post"]) }}

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                                    {!! Form::select('year', $years, null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                                    @if ($errors->has('year'))
                                                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}
                                                                    {!! Form::select('period', $_periods, null, ['class' => 'form-control select-period', 'placeholder' => '- Seleccione']) !!}
                                                                    @if ($errors->has('period'))
                                                                        <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('declaration', 'Declaraci&oacute;n', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('declaration', null, ['class' => 'form-control']) !!}
                                                                    @if ($errors->has('declaration'))
                                                                        <p class="text-danger">{!! $errors->first('declaration') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    {!! Form::label('municipality_id', 'Municipio', ['class' => 'control-label']) !!}
                                                                    {!! Form::select('municipality_id', $municipalities, null, ['class' => 'form-control select2']) !!}
                                                                    @if ($errors->has('municipality_id'))
                                                                        <p class="text-danger">{!! $errors->first('municipality_id') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    {!! Form::label('bank_id', 'Banco', ['class' => 'control-label']) !!}

                                                                    {!! Form::select('bank_id', $banks, null, ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}

                                                                    @if ($errors->has('bank_id'))
                                                                        <p class="text-danger">{!! $errors->first('bank_id') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    {!! Form::label('date_payment', 'Fecha pago', ['class' => 'control-label']) !!}
                                                                    {!! Form::text('date_payment', null, ['class' => 'form-control datepicker3']) !!}
                                                                    @if ($errors->has('date_payment'))
                                                                        <p class="text-danger">{!! $errors->first('date_payment') !!}</p>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">

                                                                <input type="hidden" name="type" value="3"/>
                                                                <input type="hidden" name="period_type" value="1"/>
                                                                <input type="hidden" name="tab" value="s3"/>

                                                                <button type="submit" class="btn btn-primary">Guardar</button>

                                                            </div>
                                                        </div>

                                                    {{ Form::close() }}

                                                  </div>

                                                </div>
                                              </div>
                                            </div>

                                        </div>

                                    </div>

                                    <hr />

                                    <table id="list-items" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>A&ntilde;o</th>
                                            <th>Per&iacute;odo</th>
                                            <th>Declaraci&oacute;n</th>
                                            <th>Municipio</th>
                                            <th>Fecha de emisi&oacute;n</th>
                                            <th>Fecha de pago</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($items_3->count())
                                                @foreach($items_3 as $item)
                                                    <tr>
                                                        <td>{{ $item->year }}</td>
                                                        <td>{{ getPeriod(2, $item->period) }}</td>
                                                        <td>{{ $item->declaration }}</td>
                                                        <td>{{ $item->municipality->name }}</td>
                                                        <td>{{ $item->date_emission }}</td>
                                                        <td>{{ $item->date_payment }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6">No se encontraron registros...</td>
                                                </tr>
                                            @endif

                                        </tbody>

                                    </table>

                                </div>

                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
