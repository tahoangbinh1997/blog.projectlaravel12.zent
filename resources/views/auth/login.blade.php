@extends('layouts.app')

@section('header')
    <title>Đăng nhập</title>
@endsection

@section('content1')
    <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
        @csrf
        <span class="login100-form-title p-b-43">
            Login to continue
        </span>


        <div class="wrap-input100 validate-input" data-validate = "Usename of email is required">
            <input class="input100 {{ old('email') ? 'has-val':'' }}" type="text" name="email" value="{{ old('email') }}">
            <span class="focus-input100"></span>
            <span class="label-input100">Email of Username</span>
        </div>
        @if($errors->has('email')) 
            <span style="color: red;position: relative;bottom: 6px;">{{ $errors->first('email') }}</span>
        @endif


        <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100 {{ old('password') ? 'has-val':'' }}" type="password"  name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
        </div>

        <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div class="contact100-form-checkbox">
                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="label-checkbox100" for="ckb1">
                    Remember me
                </label>
            </div>

            <div>
                <a href="{{ route('password.request') }}" class="txt1">
                    Forgot Password?
                </a>
            </div>
        </div>


        <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                Login
            </button>
        </div>

        <div class="text-center p-t-46 p-b-20">
            <a href="{{ route('register') }}">Register</a>
            <span class="txt2">
                or sign up using
            </span>
        </div>

        <div class="login100-form-social flex-c-m">
            <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
                <i class="fa fa-facebook-f" aria-hidden="true"></i>
            </a>

            <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
        </div>
    </form>
@endsection

