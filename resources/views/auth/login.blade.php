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
					<img src="{{ asset('assets/img/brand/white.png')}}" />
				</a>
			</div>
		</nav>
		{{-- Header  --}}
		<div class="header bg-gradient-primary py-7 py-lg-8">
			<div class="container">
				<div class="header-body text-center mb-7">
					<div class="row justify-content-center">
						<div class="col-lg-5 col-md-6">
							<h1 class="text-white">Welcome to Smart-VAT!</h1>
							<p class="text-lead text-light">VAT automation.</p>
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
		{{-- Page content  --}}
		<div class="container mt--8 pb-5">
			<div class="row justify-content-center">
				<div class="col-lg-5 col-md-7">
					<div class="card bg-secondary shadow border-0">
						<div class="card-body px-lg-5 py-lg-5">

							{{-- Login form --}}
							<form method="POST" action="{{ route('login') }}">
								@csrf

								<div class="form-group @error('userName') has-danger @enderror mb-3">
									<div class="input-group input-group-alternative">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-single-02"></i></span>
										</div>
										<input name="userName" class="form-control" placeholder="{{ __('Username') }}"
											value="{{ old('userName')}}" type="text">
									</div>
									@error('userName')
									<span class="invalid-feedback" style="display:block" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

								<div class="form-group @error('password') has-danger @enderror">
									<div class="input-group input-group-alternative">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
										</div>
										<input name="password" class="form-control" placeholder="{{ __('Password') }}"
											type="password">
									</div>
									@error('password')
									<span class="invalid-feedback" style="display:block" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

								<div class="row">
									<div class="col">
										<div class="custom-control custom-control-alternative custom-checkbox">
											<input class="custom-control-input" id=" customCheckLogin" type="checkbox"
												name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
											<label class="custom-control-label" for=" customCheckLogin">
												<span class="text-muted">{{ __('Remember me') }}</span>
											</label>
										</div>
									</div>
									<div class="col">
										<div class="text-right text-sm">
											<a href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
										</div>
									</div>
								</div>


								<div class="text-center">
									<button type="submit" class="btn  btn-primary mt-3">{{ __('Sign in') }}</button>
								</div>
							</form>
						</div>
					</div>
					<div class="row mt-3">
					</div>
				</div>
			</div>
		</div>


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

	</div>
	{{-- Core --}}
	<script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
	{{-- Argon JS --}}
	<script src="{{ asset('assets/js/argon-dashboard.min.js?v=1.1.0')}}"></script>

</body>

</html>