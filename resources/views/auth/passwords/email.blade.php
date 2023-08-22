@extends('layouts.auth')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('auth.password.email') }}" aria-label="{{ __('Reset Password') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="col-form-label text-md-right">Su E-mail</label>

            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                Recuperar clave
            </button>
        </div>
    </form>

@endsection
