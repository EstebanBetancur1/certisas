<div class="row nofill-outline">


    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('nit', 'Nit', ['class' => 'control-label']) !!}
            {!! Form::text('nit', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('nit'))
        <p class="text-danger">{!! $errors->first('nit') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('name'))
        <p class="text-danger">{!! $errors->first('name') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('doc', 'Nro. Documento', ['class' => 'control-label']) !!}
            {!! Form::text('doc', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('doc'))
        <p class="text-danger">{!! $errors->first('doc') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('date', 'Fecha', ['class' => 'control-label']) !!}
            {!! Form::text('date', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('date'))
        <p class="text-danger">{!! $errors->first('date') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('tax', 'Impuesto', ['class' => 'control-label']) !!}
            {!! Form::text('tax', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('tax'))
        <p class="text-danger">{!! $errors->first('tax') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('rate', 'Tarifa', ['class' => 'control-label']) !!}
            {!! Form::text('rate', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('rate'))
        <p class="text-danger">{!! $errors->first('rate') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('year_process', 'A&ntilde;o proceso', ['class' => 'control-label']) !!}
            {!! Form::text('year_process', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('year_process'))
        <p class="text-danger">{!! $errors->first('year_process') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('period_process', 'Mes proceso', ['class' => 'control-label']) !!}
            {!! Form::select('period_process', $months, (isset($item) && $item)?$item->period_process:null, ['class' => 'form-control']) !!}
        </div>

        @if ($errors->has('month_process'))
        <p class="text-danger">{!! $errors->first('month_process') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('concept', 'Concepto', ['class' => 'control-label']) !!}
            {!! Form::text('concept', null, ['class' => 'form-control', 'placeholder' => '']) !!}
        </div>

        @if ($errors->has('concept'))
        <p class="text-danger">{!! $errors->first('concept') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
            <div class="select-container">
                {!! Form::select('type', ["1" => "Rete fuente", "2" => "Rete ICA", "3" => "Rete IVA"], null, [ 'placeholder' => '- Seleccione']) !!}
            </div>
        </div>

        @if ($errors->has('type'))
        <p class="text-danger">{!! $errors->first('type') !!}</p>
        @endif
    </div>

    @if(isset($item) && (int)$item->type === 2)
    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}
            <div class="select-container">
                {!! Form::select('city_id', $cities, null, ['class' => ' companies-select-3', 'placeholder' => '-
                Seleccione']) !!}
            </div>
        </div>


        @if ($errors->has('city_id'))
        <p class="text-danger">{!! $errors->first('city_id') !!}</p>
        @endif
    </div>
    @endif

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('period_type', 'Tipo de plantilla', ['class' => 'control-label']) !!}
            <div class="select-container">
                 {!! Form::select('period_type', ["1" => "Mensual", "2" => "Bimestral", "3" => "Anual"], null, ['placeholder' => '- Seleccione']) !!}
            </div>
        </div>
        
       
        @if ($errors->has('period_type'))
        <p class="text-danger">{!! $errors->first('period_type') !!}</p>
        @endif
    </div>

    <div class="col-md-6">
        <div class="cs-field field">
            {!! Form::label('status', 'Estado', ['class' => 'control-label']) !!}
            <div class="select-container">
                {!! Form::select('status', ["1" => "Activo", "0" => "Inactivo"], null, [ 'placeholder'
        => '- Seleccione']) !!}
            </div>
        </div>
        
        
        @if ($errors->has('status'))
        <p class="text-danger">{!! $errors->first('status') !!}</p>
        @endif
    </div>
</div>
