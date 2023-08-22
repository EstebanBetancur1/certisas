<div class="form-group">
    {!! Form::label('status', 'Estado', ['class' => 'control-label']) !!}
    {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('status'))
        <p class="text-danger">{!! $errors->first('status') !!}</p>
    @endif
</div>