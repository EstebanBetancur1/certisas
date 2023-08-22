<div class="form-group">
    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('name'))
        <p class="text-danger">{!! $errors->first('name') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('nit', 'Nit', ['class' => 'control-label']) !!}
    {!! Form::text('nit', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('nit'))
        <p class="text-danger">{!! $errors->first('nit') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('dv', 'DV', ['class' => 'control-label']) !!}
    {!! Form::text('dv', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('dv'))
        <p class="text-danger">{!! $errors->first('dv') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('sectional', 'Direcci&oacute;n de seccional', ['class' => 'control-label']) !!}
    {!! Form::select('sectional', $sectionals, null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
    @if ($errors->has('sectional'))
        <p class="text-danger">{!! $errors->first('sectional') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('type', 'Tipo', ['class' => 'control-label']) !!}
    {!! Form::select('type', [1 => 'Jur&iacute;dico', 2 => 'Natural'], null, ['class' => 'form-control', 'placeholder' => '- Seleccione']) !!}
    @if ($errors->has('type'))
        <p class="text-danger">{!! $errors->first('type') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('city', 'Ciudad', ['class' => 'control-label']) !!}
    {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('city'))
        <p class="text-danger">{!! $errors->first('city') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('address', 'Direcci&oacute;n', ['class' => 'control-label']) !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('address'))
        <p class="text-danger">{!! $errors->first('address') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('email', 'Correo de la empresa', ['class' => 'control-label']) !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('email'))
        <p class="text-danger">{!! $errors->first('email') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('phone', 'Tel&eacute;fono', ['class' => 'control-label']) !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('phone'))
        <p class="text-danger">{!! $errors->first('phone') !!}</p>
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
    {!! Form::label('activities', 'Actividades', ['class' => 'control-label']) !!}
    {!! Form::text('activities', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('activities'))
        <p class="text-danger">{!! $errors->first('activities') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('status', 'Estado', ['class' => 'control-label']) !!}
    {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('status'))
        <p class="text-danger">{!! $errors->first('status') !!}</p>
    @endif
</div>