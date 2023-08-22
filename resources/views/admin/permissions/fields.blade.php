<div class="form-group">
    {!! Form::label('title', 'T&iacute;tulo a mostrar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'T&iacute;tulo del permiso']) !!}
        @if ($errors->has('title'))
            <p class="text-danger">{!! $errors->first('title') !!}</p>
        @endif
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Permiso', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'solo-lectura', 'readonly' => 'readonly']) !!}
        @if ($errors->has('name'))
            <p class="text-danger">{!! $errors->first('name') !!}</p>
        @else
            <p class="text-info">Todo en min&uacute;scula y sin espacios</p>
        @endif
    </div>
</div>