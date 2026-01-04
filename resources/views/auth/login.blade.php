{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('layouts.auth.app')
@section('title')
    Login
@endsection
@section('content')
    <div class="row g-0">
        <div class="col-xxl-3 col-lg-4 col-md-5">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a class="d-block auth-logo">
                                    <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp" height="28"> <span
                                        class="logo-txt">Login Apps</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center mb-4">
                                    <h5 class="mb-0">Selamat Datang <br> CHR Eagle Media Informatika</h5>
                                </div>
                                <form class="mt-4 pt-2" action="index.html">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Password</label>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="">
                                                    <a href="auth-recoverpw.html" class="text-muted">Lupa Password</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" name="password" class="form-control" placeholder="Enter password"
                                                aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-check">
                                                <label class="form-check-label" for="remember-check">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Belum memiliki akun ? <a href="auth-register.html"
                                            class="text-primary fw-semibold"> Daftar Sekarang </a> </p>
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> Eagle Media Informatika
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xxl-9 col-lg-8 col-md-7">
            <div class="auth-bg pt-md-5 p-4 d-flex">
                <div class="bg-overlay bg-primary"></div>
                <ul class="bg-bubbles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
