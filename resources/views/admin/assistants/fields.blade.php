<div class="form-group">
    {!! Form::label('full_name', 'Nombre Completo', ['class' => 'control-label']) !!}
    {!! Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => 'Nombre Completo']) !!}
    @if ($errors->has('full_name'))
        <p class="text-danger">{!! $errors->first('full_name') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('email', 'Correo Electr&oacute;nico', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'user@gmail.com']) !!}
    @if ($errors->has('email'))
        <p class="text-danger">{!! $errors->first('email') !!}</p>
    @endif
</div>

@if(isset($item) && (int)$item->is_admin === 1)
    <input type="hidden" name="status" value="{{ $item->status }}" />
@else
    <div class="form-group">
        {!! Form::label('status', 'Estado', ['class' => 'control-label']) !!}
        {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control']) !!}
        @if ($errors->has('status'))
            <p class="text-danger">{!! $errors->first('status') !!}</p>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('role', 'Rol', ['class' => 'control-label']) !!}
        {!! Form::select('role', $roles, (isset($roleSelected) && $roleSelected)?$roleSelected->name:null, ['class' => 'form-control']) !!}
        @if ($errors->has('role'))
            <p class="text-danger">{!! $errors->first('role') !!}</p>
        @endif
    </div>
@endif

<div class="form-group">
    {!! Form::label('password', 'Clave', ['class' => 'control-label']) !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
    @if ($errors->has('password'))
        <p class="text-danger">{!! $errors->first('password') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Clave Confirmaci&oacute;n', ['class' => 'control-label']) !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    @if ($errors->has('password_confirmation'))
        <p class="text-danger">{!! $errors->first('password_confirmation') !!}</p>
    @endif
</div>