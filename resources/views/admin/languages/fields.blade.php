<div class="form-group">
    {!! Form::label('title', 'T&iacute;tulo', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'T&iacute;tulo del registro']) !!}
    @if ($errors->has('title'))
        <p class="text-danger">{!! $errors->first('title') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('lang', 'Etiqueta', ['class' => 'control-label']) !!}
    {!! Form::text('lang', null, ['class' => 'form-control', 'placeholder' => 'es']) !!}
    @if ($errors->has('lang'))
        <p class="text-danger">{!! $errors->first('lang') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('status', 'Estado', ['class' => 'control-label']) !!}
    {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('status'))
        <p class="text-danger">{!! $errors->first('status') !!}</p>
    @endif
</div>