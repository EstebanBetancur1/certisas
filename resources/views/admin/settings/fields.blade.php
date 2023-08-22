<div class="form-group">
    {!! Form::label('project', 'Nombre del Proyecto', ['class' => 'control-label']) !!}
    {!! Form::text('project', null, ['class' => 'form-control', 'placeholder' => 'Ej: Dinnovos']) !!}
    @if ($errors->has('project'))
        <p class="text-danger">{!! $errors->first('project') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('route_login_panel', 'Ruta Panel', ['class' => 'control-label']) !!}
    {!! Form::text('route_login_panel', null, ['class' => 'form-control', 'placeholder' => 'Ej: panel']) !!}
    @if ($errors->has('route_login_panel'))
        <p class="text-danger">{!! $errors->first('route_login_panel') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('email_notification', 'E-mail Notificaciones', ['class' => 'control-label']) !!}


        <div class="input-group">
                {!! Form::text('email_notification', null, ['class' => 'form-control', 'placeholder' => 'Ej: user@gmail.com']) !!}
                <div class="input-group-append">
                        <a href="{{ route('admin.settings.email.test') }}" class="btn btn-warning">Probar</a>
                </div>
        </div>

    @if ($errors->has('email_notification'))
        <p class="text-danger">{!! $errors->first('email_notification') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('maintenance_mode', '&iquest;Mantenimiento?', ['class' => 'control-label']) !!}
    {!! Form::select('maintenance_mode', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('maintenance_mode'))
        <p class="text-danger">{!! $errors->first('maintenance_mode') !!}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('coming_soon_mode', '&iquest;Activar p&aacute;gina pr&oacute;ximamente?', ['class' => 'control-label']) !!}
    {!! Form::select('coming_soon_mode', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('coming_soon_mode'))
        <p class="text-danger">{!! $errors->first('coming_soon_mode') !!}</p>
    @endif
</div>