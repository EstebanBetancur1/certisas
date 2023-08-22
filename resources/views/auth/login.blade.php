@extends('layouts.auth')
@section('content')
    <div class="login-title">
        <h3 class="black">{{__('Sign In')}}</h3>
    </div>
    <form action="{{ route('auth.user.login.verify') }}" id="login-form" method="post">
        <div class="cs-field field">
          <label for="login-username" class="bold">{{__('E-Mail Address')}}</label>
          <input type="text" placeholder="{{__('Enter your email')}}" id="login-username" name="email" required>
        </div>
        <div class="cs-field field">
          <label for="login-password" class="bold">{{__('Password')}}</label>
          <input type="password" placeholder="{{__('Enter your password')}}" id="login-password" name="password" required>
        </div>
        @csrf
        <button type="submit" class="login-enviar cs-btn btn-blue">{{__('Login')}}</button>
    </form>
@endsection
@section('js_header')<script defer src="{{mix('/js/login.js')}}"></script>@endsection
