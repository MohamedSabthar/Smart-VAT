<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Smart-VAT Login
    </title>
    {{-- Favicon --}}
    <link href="{{ asset('assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    {{-- Icons --}}
    <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
    <link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
    {{-- CSS Files --}}
    <link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.0')}}" rel="stylesheet" />
</head>

<body class="bg-default">
    <div class="main-content">
        {{-- Navbar --}}
        <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
            <div class="container px-4">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/img/brand/white.png')}}" style="width: auto; height:2.5rem;" />
                </a>
            </div>
        </nav>
        {{-- end of Navbar --}}

        {{-- Header  --}}
        <div class="header bg-gradient-primary py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Welcome to</h1>
                            <img src="{{ asset('assets/img/brand/white.png')}}" style="width: auto; height:5rem;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        {{-- end of Header --}}

        {{-- Page content  --}}
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            {{-- Reset password form --}}
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    <div class="col-md-7">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email"
                                            autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-7">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-7">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-7 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            {{-- end of Reset password form --}}
                        </div>
                    </div>
                    <div class="row mt-3">
                    </div>
                </div>
            </div>
        </div>
        {{-- end of Page content --}}

        {{-- Footer --}}
        <footer class="pt-9">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            © 2019 <a href="#" class="font-weight-bold ml-1" target="_blank">E-Crew</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {{-- end of Footer --}}
    </div>
    {{-- Core --}}
    <script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    {{-- Argon JS --}}
    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=1.1.0')}}"></script>

</body>

</html>