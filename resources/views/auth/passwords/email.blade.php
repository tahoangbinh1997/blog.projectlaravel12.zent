@extends('layouts.app')

@section('header')
    <title>Lấy lại mật khẩu</title>
@endsection

@section('content1')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <span class="login100-form-title p-b-43">
            Reset Password
        </span>


        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100 {{ old('email') ? 'has-val':'' }}" type="text" name="email" value="{{ old('email') }}">
            <span class="focus-input100"></span>
            <span class="label-input100">Email</span>
        </div>
        @if($errors->has('email')) 
            <span style="color: red;position: relative;bottom: 6px;">{{ $errors->first('email') }}</span>
        @endif

        <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
                Send Password Reset Link
            </button>
        </div>

    </form>
@endsection

{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
