@extends('layouts.auth')

@section('content')

    <form action="{{ route('auth.request.register.create') }}" method="post">

        @csrf

        <div class="block block-themed block-rounded block-shadow">
            <div class="block-header bg-primary-light">
                <h3 class="block-title" style="font-size: 16px; margin-bottom: 10px;font-weight: bold;">Solicitud a: {!! str_limit($company->name, 12) !!}</h3>

                <!--
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
                -->

            </div>
            <div class="block-content">
                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-fullname">Nombre completo</label>
                        <input type="text" class="form-control" id="signup-fullname" name="full_name" placeholder="">
                        @if ($errors->has('full_name'))
                            <span class="text-danger" role="alert">
							<strong>{{ $errors->first('full_name') }}</strong>
						</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-fullname">Correo Electr&oacute;nico</label>
                        <input type="email" class="form-control" id="signup-email" name="email" placeholder="">
                        @if ($errors->has('email'))
                            <span class="text-danger" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-phone">Tel&eacute;fono</label>
                        <input type="text" class="form-control" id="signup-phone" name="phone" placeholder="">
                        @if ($errors->has('phone'))
                            <span class="text-danger" role="alert">
							<strong>{{ $errors->first('phone') }}</strong>
						</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-password">Contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="signup-password" name="password" placeholder="********">
                        @if ($errors->has('password'))
                            <span class="text-danger" role="alert">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="signup-password-confirm">Confirmaci&oacute;n de contrase&ntilde;a</label>
                        <input type="password" class="form-control" id="signup-password-confirm" name="password_confirmation" placeholder="********">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger" role="alert">
							<strong>{{ $errors->first('password_confirmation') }}</strong>
						</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 text-right">
                        <input type="hidden" name="company_id" value="{{ $company->id }}" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus mr-10"></i> Registrarme
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection