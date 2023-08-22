<div class="form-group">
    {!! Form::label('title', "T&iacute;tulo - {$lang}", ['class' => 'control-label']) !!}
    {!! Form::text("title", null, ['class' => 'form-control', 'placeholder' => '']) !!}
    @if ($errors->has('title'))
        <p class="text-danger">{!! $errors->first('title') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('content', "Contenido - {$lang}", ['class' => 'control-label']) !!}
    {!! Form::textarea("content", null, ['class' => "form-control editor-{$lang}", 'placeholder' => '']) !!}
    @if ($errors->has('content'))
        <p class="text-danger">{!! $errors->first('content') !!}</p>
    @endif
</div>
