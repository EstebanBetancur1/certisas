<div class="form-group">
    {!! Form::label('nit', 'Nit', ['class' => 'control-label']) !!}
    {!! Form::text('nit', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('nit'))
        <p class="text-danger">{!! $errors->first('nit') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('name'))
        <p class="text-danger">{!! $errors->first('name') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('doc', 'Nro. Documento', ['class' => 'control-label']) !!}
    {!! Form::text('doc', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('doc'))
        <p class="text-danger">{!! $errors->first('doc') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('date', 'Fecha', ['class' => 'control-label']) !!}
    {!! Form::text('date', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('date'))
        <p class="text-danger">{!! $errors->first('date') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('tax', 'Impuesto', ['class' => 'control-label']) !!}
    {!! Form::text('tax', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('tax'))
        <p class="text-danger">{!! $errors->first('tax') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('rate', 'Tarifa', ['class' => 'control-label']) !!}
    {!! Form::text('rate', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('rate'))
        <p class="text-danger">{!! $errors->first('rate') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('year_process', 'A&ntilde;o proceso', ['class' => 'control-label']) !!}
    {!! Form::text('year_process', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('year_process'))
        <p class="text-danger">{!! $errors->first('year_process') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('month_process', 'Mes proceso', ['class' => 'control-label']) !!}
    {!! Form::text('month_process', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('month_process'))
        <p class="text-danger">{!! $errors->first('month_process') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('concept', 'Concepto', ['class' => 'control-label']) !!}
    {!! Form::text('concept', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('concept'))
        <p class="text-danger">{!! $errors->first('concept') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('type', 'Tipo de impuesto', ['class' => 'control-label']) !!}
    {!! Form::select('type', ["1" => "Rete fuente", "2" => "Rete ICA", "3" => "Rete IVA"], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
    @if ($errors->has('type'))
        <p class="text-danger">{!! $errors->first('type') !!}</p>
    @endif
</div>

@if(isset($item) && (int)$item->type === 2)
    <div class="div-select-city"> 
        <div class="form-group">
            {!! Form::label('city_id', 'Ciudad', ['class' => 'control-label']) !!}
            {!! Form::select('city_id', $cities, null, ['class' => 'form-control companies-select2', 'placeholder' => '- Seleccione']) !!}
            @if ($errors->has('city_id'))
                <p class="text-danger">{!! $errors->first('city_id') !!}</p>
            @endif
        </div>
    </div>
@endif

<div class="form-group">
    {!! Form::label('type_template', 'Tipo de plantilla', ['class' => 'control-label']) !!}
    {!! Form::select('type_template', ["1" => "Mensual", "2" => "Bimestral", "3" => "Anual"], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
    @if ($errors->has('type_template'))
        <p class="text-danger">{!! $errors->first('type_template') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('status', 'Estado', ['class' => 'control-label']) !!}
    {!! Form::select('status', ["1" => "Activo", "0" => "Inactivo"], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
    @if ($errors->has('status'))
        <p class="text-danger">{!! $errors->first('status') !!}</p>
    @endif
</div>
