@extends('Admin.auth.layouts.app')

@section('content')
<div class="h-100">
    <div class="h-100 no-gutters row">
        <div class="d-none d-lg-block col-lg-6">
            <div class="slider-light">
                <div class="slick-slider">
                    <div>
                        <div class="position-relative h-100 d-flex justify-content-center align-items-center"
                            tabindex="-1">
                            <div class="slide-img-bg" style="background-image:url('{{ asset('assets/images/login-banner.jpg') }}') !important; position: absolute;
                                            left: 0;
                                            top: 0;
                                            width: 100%;
                                            height: 100%;
                                            background-size: cover;
                                            opacity: .5;
                                            z-index: 10;
                                            background-size: cover;
                                            ">
                            </div>
                            <div class="slider-content">
                                <h3>All about your vehicle care</h3>
                                <p>One palce for vehicle
                                    service....
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-6">
            <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                <div class="app-logo"><img src="{{ asset('assets/images/login-logo.png') }}" /></div>
                <h4 class="mb-0 margin-top">
                    <span>Sign in to your admin account.</span>
                </h4>
                <div class="divider row"></div>
                <div>
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail" class>Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="examplePassword" class>Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="position-relative form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <div class="divider row"></div>
                        <div class="d-flex align-items-center">
                            <div class="ml-auto">
                                {{-- @if (Route::has('password.request')) --}}
                                <a class="btn btn-link" href="{{ route('admin.forget.password.get') }}">
                                    Forgot Your Password?
                                </a>
                                {{-- @endif --}}

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
