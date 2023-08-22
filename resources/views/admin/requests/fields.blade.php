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
    {!! Form::label('sectional', 'Seccional', ['class' => 'control-label']) !!}
    {!! Form::text('sectional', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('sectional'))
        <p class="text-danger">{!! $errors->first('sectional') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('type', 'Tipo', ['class' => 'control-label']) !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('type'))
        <p class="text-danger">{!! $errors->first('type') !!}</p>
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
    {!! Form::label('email', 'Correo Electr&oacute;nico', ['class' => 'control-label']) !!}
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

<input type="hidden" name="status" value="{{ $item->status }}" />