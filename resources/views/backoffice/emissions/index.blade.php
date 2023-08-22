@extends('layouts.backoffice')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $(function () {

            $('.select-city').select2();

            $('.select-type').on("change", function(){
                periodTypeCombo($(this).val());

                if($(this).val() === "3"){
                    $(".select-city").removeAttr("disabled");
                }else{
                    $(".select-city").attr("disabled", "disabled");
                }
            }); 

            $('.select-period-type').on("change", function(){
                periodoCombo($(this).val());
            });

            $('.datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format:'yyyy-mm-dd'
            });

        });

        function periodTypeCombo(option){

            if(option === ""){

                $(".select-period-type").attr("disabled", "disabled");
                $(".select-period-type").html("<option>- Seleccione</option>");

                return;
            }

            $(".select-period").attr("disabled", "disabled");
            $(".select-period").html("<option>- Seleccione</option>");

            $.ajax({
                type: "GET",
                data: {},
                url: '{{ route("backoffice.emissions.combo.period_type") }}?o='+option,
                dataType: 'html',
                success: function (result){
                    result = eval('(' + result + ')');

                    if(result.status !== undefined){
                        if(result.status === 'ok'){

                            if(result.html === "empty"){
                                $(".select-period-type").attr("disabled", "disabled");
                                $(".select-period-type").html("<option>- Seleccione</option>");
                            }else{
                                $(".select-period-type").removeAttr("disabled");
                                $(".select-period-type").html(result.html);
                            }
                        }
                    }
                },
                error: function(){
                    new Notyf({delay:3000}).error('Por favor, intente nuevamente');
                }
            });
        }

        function periodoCombo(option){

            if(option === ""){
                $(".select-period").attr("disabled", "disabled");
                $(".select-period").html("<option>- Seleccione</option>");
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
                                $(".select-period").attr("disabled", "disabled");
                                $(".select-period").html("<option>- Seleccione</option>");
                            }else{
                                $(".select-period").removeAttr("disabled");
                                $(".select-period").html(result.html);
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
    Generar Emisiones
@endsection

@section('content')

    <div class="content">

        <div class="row">
            
            <div class="col-12">

                <div class="block">

                    <div class="block-content">

                        <div class="row">
                            <div class="col-6">
                                {{ Form::open(['url' => route('backoffice.emissions.index'), "class" => "", "method" => "get"]) }}

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                                                {!! Form::select('type', ["1" => "Certificado de retenci&oacute;n a t&iacute;tulo de ventas", "2" => "Certificado de retenci&oacute;n a t&iacute;tulo de renta", "3" => "Certificado de industria y comercio"], request()->input("type"), ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                                @if ($errors->has('type'))
                                                    <p class="text-danger">{!! $errors->first('type') !!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                                {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                                                @if ($errors->has('year'))
                                                    <p class="text-danger">{!! $errors->first('year') !!}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">

                                                {!! Form::label('period_type', 'Tipo per&iacute;odo', ['class' => 'control-label']) !!}
                                                @if((int)request()->input("period_type"))
                                                    {!! Form::select('period_type', $periodsType, request()->input("period_type"), ['class' => 'form-control period-type select-period-type', 'placeholder' => '- Seleccione']) !!}
                                                @else
                                                    {!! Form::select('period_type', $periodsType, request()->input("period_type"), ['class' => 'form-control period-type select-period-type', 'placeholder' => '- Seleccione', 'disabled' => 'disabled']) !!}
                                                @endif

                                                @if ($errors->has('period_type'))
                                                    <p class="text-danger">{!! $errors->first('period_type') !!}</p>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('period', 'Per&iacute;odo', ['class' => 'control-label']) !!}

                                                @if((int)request()->input("period"))
                                                    {!! Form::select('period', $periods, request()->input("period"), ['class' => 'form-control select-period', 'placeholder' => '- Seleccione']) !!}
                                                @elseif((string)request()->input("period") === "all")
                                                    {!! Form::select('period', ["all" => "Enero a Diciembre"], "all", ['class' => 'form-control select-period', 'placeholder' => '- Seleccione']) !!}
                                                @else
                                                    {!! Form::select('period', $periods, null, ['class' => 'form-control select-period', 'placeholder' => '- Seleccione', 'disabled' => 'disabled']) !!}
                                                @endif

                                                @if ($errors->has('period'))
                                                    <p class="text-danger">{!! $errors->first('period') !!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {!! Form::label('city', 'Ciudad', ['class' => 'control-label']) !!}

                                                @if((int)request()->input("city"))
                                                    {!! Form::select('city', $cities, request()->input("city"), ['class' => 'form-control select-city', 'placeholder' => '- Seleccione']) !!}
                                                @else
                                                    {!! Form::select('city', $cities, null, ['class' => 'form-control select-city', 'placeholder' => '- Seleccione', 'disabled' => 'disabled']) !!}
                                                @endif

                                                @if ($errors->has('city'))
                                                    <p class="text-danger">{!! $errors->first('city') !!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if(count($providers))
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {!! Form::label('provider', 'Proveedor', ['class' => 'control-label']) !!}

                                                    {!! Form::select('provider', $options, request()->input("provider"), ['class' => 'form-control']) !!}

                                                    @if ($errors->has('provider'))
                                                        <p class="text-danger">{!! $errors->first('provider') !!}</p>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        Buscar
                                                    </button>
                                                    <a href="{{ route("backoffice.emissions.index") }}" class="btn btn-secondary">
                                                        <i class="fa fa-eraser"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        @if(count($providers))

                                            <div class="col-lg-9">

                                                <div class="form-group">

                                                    <div class="btn-group">
                                                        {!! Form::text('date_emission', null, ['class' => 'form-control datepicker', 'placeholder' => 'Fecha de emisi&oacute;n']) !!}
                                                        @if ($errors->has('date_emission'))
                                                            <p class="text-danger">{!! $errors->first('date_emission') !!}</p>
                                                        @endif

                                                        <button type="submit" name="action" value="emit" class="btn btn-success">Emitir</button>
                                                    </div>

                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                {{ Form::close() }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
