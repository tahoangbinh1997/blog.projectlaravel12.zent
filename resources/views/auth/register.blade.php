@extends('layouts.app')

@section('header')
    <title>Đăng kí</title>
@endsection

{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@section('content1')
    <form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
        @csrf
        <span class="login100-form-title p-b-43">
            Register to continue
        </span>


        <div class="wrap-input100 validate-input" data-validate = "Valid name is required">
            <input class="input100 {{ old('name') ? 'has-val':'' }}" type="text" name="name" value="{{ old('name') }}">
            <span class="focus-input100"></span>
            <span class="label-input100">Name</span>
        </div>
        @if($errors->has('name')) 
            <span style="color: red;position: relative;bottom: 6px;">{{ $errors->first('name') }}</span>
        @endif
        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100 {{ old('email') ? 'has-val':'' }}" type="text" name="email" value="{{ old('email') }}">
            <span class="focus-input100"></span>
            <span class="label-input100">Email</span>
        </div>
        @if($errors->has('email')) 
            <span style="color: red;position: relative;bottom: 6px;">{{ $errors->first('email') }}</span>
        @endif
        <div class="wrap-input100 validate-input" data-validate = "Valid username is required">
            <input class="input100 {{ old('username') ? 'has-val':'' }}" type="text" name="username" value="{{ old('username') }}">
            <span class="focus-input100"></span>
            <span class="label-input100">Username</span>
        </div>
        @if($errors->has('username')) 
            <span style="color: red;position: relative;bottom: 6px;">{{ $errors->first('username') }}</span>
        @endif

        <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100 {{ old('password') ? 'has-val':'' }}" type="password"  name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
        </div>
        @if ($errors->has('password'))
            <span style="color: red;position: relative;bottom: 6px;">{{ $errors->first('password') }}</span>
        @endif
        <div class="wrap-input100 validate-input" data-validate = "Confirm Password is required">
            <input class="input100 {{ old('password') ? 'has-val':'' }}" type="password"  name="password_confirmation">
            <span class="focus-input100"></span>
            <span class="label-input100">Confirm Password</span>
        </div>

        <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div>
                <a href="{{ route('password.request') }}" class="txt1">
                    Forgot Password?
                </a>
            </div>
        </div>


        <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                Register
            </button>
        </div>
    </form>
@endsection