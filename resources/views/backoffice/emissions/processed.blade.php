@extends('layouts.backoffice')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css"/>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>

    <style>
        #list-items input[type='text']{
            color: #575757;
            background-color: #fff;
            border: 1px solid #d8e1e1;
             height:calc(1.142857em + .714286rem + 2px);
             padding:.357143rem .6429rem;
             font-size:1rem;
             line-height:1.142857;
             border-radius:.2rem
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            $('.period-type').on("change", function(){
                periodoCombo($(this).val());
            });

            $('.select-type').on("change", function(){
                if($(this).val() === "3"){
                    $(".select-city").removeAttr("disabled");
                }else{
                    $(".select-city").attr("disabled", "disabled");
                }
            }); 

            $('#list-items thead tr:nth-child(2) th').each( function () {
                var title = $(this).text();

                if(title){
                    $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
                }
                
            } );

            $('#list-items').DataTable({
                ordering: false,
                language: {
                    search: "Buscar: ",
                    lengthMenu:    "Mostrar _MENU_ registros por fila",
                    info:           "Mostrando _START_ a _END_ de _TOTAL_ elementos",
                    emptyTable:     "No se encontraron registros",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Pr&oacute;ximo",
                        last:       "Ultimo"
                    }
                },

                initComplete: function () {
                    // Apply the search
                    this.api().columns().every( function () {
                        var that = this;
         
                        $( 'input', this.header() ).on( 'keyup change clear', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                }
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
    Emisiones Generadas
@endsection

@section('content')

    <div class="content">

         <div class="row">
            <div class="col-md-8">
                <h2>
                    Listado
                </h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('backoffice.emissions.index') }}" class="btn btn-success">Generar emisiones</a>
            </div>
        </div>

        <!--
        <div class="row">
            <div class="col-md-8">
                <h2>
                    Emisiones Generadas
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

                        {{ Form::open(['url' => route('backoffice.emissions.processed'), "class" => "", "method" => "get"]) }}
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="form-group">
                                    {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
                                    {!! Form::select('type', ["1" => "Certificado de retenci&oacute;n a t&iacute;tulo de ventas", "2" => "Certificado de retenci&oacute;n a t&iacute;tulo de renta", "3" => "Certificado de industria y comercio"], request()->input("type"), ['class' => 'form-control select-type', 'placeholder' => '- Seleccione']) !!}
                                    @if ($errors->has('type'))
                                        <p class="text-danger">{!! $errors->first('type') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    {!! Form::label('year', 'A&ntilde;o', ['class' => 'control-label']) !!}
                                    {!! Form::select('year', $years, request()->input("year"), ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
                                    @if ($errors->has('year'))
                                        <p class="text-danger">{!! $errors->first('year') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-2"> 
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}
                                    
                                    @if((int)request()->input("city"))
                                        {!! Form::select('city', $cities, request()->input("city"), ['class' => 'form-control select-city', 'placeholder' => '- Seleccione']) !!}
                                    @else
                                        {!! Form::select('city', $cities, null, ['class' => 'form-control select-city', 'placeholder' => '- Seleccione', 'disabled' => 'disabled']) !!}
                                    @endif

                                    @if ($errors->has('city_id'))
                                        <p class="text-danger">{!! $errors->first('city_id') !!}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group" style="padding-top: 32px">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">
                                            Buscar
                                        </button>
                                        <a href="{{ route("backoffice.emissions.processed") }}" class="btn btn-secondary">
                                            <i class="fa fa-eraser"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{ Form::close() }}

                        <hr />

                        <div class="table-container">
                            <table id="list-items" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">Nit</th>
                                    <th>Proveedor</th>
                                    <th width="15%">Periodo</th>
                                    <th width="9%">Opciones</th>
                                </tr>
                                <tr>
                                    <th width="10%">Nit</th>
                                    <th>Proveedor</th>
                                    <th width="15%">Periodo</th>
                                    <th width="9%"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($items->count())
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->provider_nit }}</td>
                                            <td>{{ $item->provider_name }}</td>
                                            <td>{{ ((int)$item->period_type === 1 || (int)$item->period_type === 2)?getPeriod($item->period_type, $item->period):"Todo el " . $item->year  }}</td>
                                            <td class="text-center">
                                                <a target="_blank" href="{{ route("backoffice.emissions.declaration", ["id" => $item->id]) }}" class="btn btn-sm btn-primary"> <i class="fa fa-file-pdf-o"></i> </a>
                                                <a onclick="return confirm('Desea enviar una alerta al proveedor?')" href="{{ route("backoffice.emissions.send.alert", ["id" =>  $item->id]) }}" class="btn btn-sm btn-secondary"> <i class="fa fa-envelope-o"></i> </a>
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

            </div>

        </div>
    </div>

@endsection
