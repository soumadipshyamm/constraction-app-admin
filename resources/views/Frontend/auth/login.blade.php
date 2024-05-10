@extends('Frontend.layouts.app')
@section('login-active', 'active')
@section('title', __('Login'))
@push('styles')
    <style>
        .error {
            color: red;
        }
    </style>
@endpush
@section('content')

    <section class="log-in">
        <div class="row no-gutters  justify-content-end">
            <div class="col-sm-12 col-md-5">
                <div class="log-in-content">
                    <h4>LOG IN</h4>
                    <P>"Company employees access secure services via login, ensuring privacy and enabling personalized
                        interactions on the platform."</P>
                    <form method="POST" action="{{ route('company.loginPost') }}" data-url="{{ route('company.loginPost') }}"
                        class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                        @csrf
                        <input type="email" class="form-control" id="email" name="email"
                            aria-describedby="emailHelp" placeholder="Email Id." required value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                        @endif

                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required value="{{ old('password') }}">
                        @if ($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                        @endif
                        <a class="btn btn-link" href="{{ route('company.forget.password.get') }}">
                            Forgot Your Password?
                        </a>
                        <button type="submit" class="btn btn-primary">Log In </button>
                    </form>
                    <h5>Don't Have Account ? <a href="{{ route('company.registration') }}">Registration</a></h5>
                </div>
            </div>
            <div class=" col-sm-12 col-md-7">
                <div class="lapto-image">
                    <img src="{{ asset('assets/images/login-image.png') }}" alt="">
                </div>
            </div>

        </div>
    </section>
@endsection
@push('scripts')
@endpush
