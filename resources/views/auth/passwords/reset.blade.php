@extends('layouts.auth')

@section('content')
    <form id="reset-password-form" method="POST" action="{{ route('password.request') }}" novalidate aria-label="{{ __('Reset Password') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="reset-email" class="col-form-label text-md-right">{{__('E-Mail Address')}}</label>
            <input id="reset-email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="reset-password" class="col-form-label text-md-right">{{__('Password')}}</label>
            <input id="reset-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="reset-password_confirmation" class="col-form-label text-md-right">{{__('Confirm Password')}}</label>
            <input id="reset-password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>
        <div class="alert alert-info d-none"><span class="icofont-spin icofont-spinner-alt-2 me-2"></span><span>{{__('Loading...')}}</span></div>
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                {{__('Reset Password')}}
            </button>
        </div>
    </form>
@endsection
@section('js')<script src="{{mix('/js/reset-password.js')}}"></script>@endsection
