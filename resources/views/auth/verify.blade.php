<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{{-- CSRF Token --}}
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- Favicon --}}
	<link href="{{ asset('assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
	{{-- Fonts --}}
	<link href="{{ asset('assets/css/open-sans.css') }}" rel="stylesheet">
	{{-- Icons --}}
	<link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
	<link href="{{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
	{{-- CSS Files --}}
	<link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.0')}}" rel="stylesheet" />
	@stack('css')
	@if (Session::get('locale')==='si')
	<style>
		thead>tr>th {
			font-size: 1rem !important;

		}

		.notification-title {
			font-size: .9rem !important;
		}
	</style>
	@endif
	<title>
		Verification
	</title>
</head>

<body>
	<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
		<div class="container-fluid">

			{{-- Toggler --}}
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
				aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			{{-- Brand --}}
			<a class="navbar-brand pt-0" href="../index.html">
				<img src="{{ asset('assets/img/brand/blue.png') }}" class="navbar-brand-img" alt="...">
			</a>

			{{-- User --}}
			<ul class="nav align-items-center d-md-none">
				<li class="nav-item dropdown">
					<a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
						<div class="media align-items-center">
							<span class="avatar avatar-sm rounded-circle">
								<img alt="Image placeholder" src="{{ asset('assets/img/theme/girl.png')}}">
							</span>
						</div>
					</a>
					<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
						<div class=" dropdown-header noti-title">
							<h6 class="text-overflow m-0 notification-title">{{ Auth::user()->role }}</h6>
						</div>
						<a href="{{route('my-profile')}}" class="dropdown-item">
							<i class="ni ni-single-02"></i>
							<span>{{__('menu.My profile')}}</span>
						</a>

						<a href="{!! App::getLocale()=='en' ? '/language/si' : '/language/en' !!}"
							class="dropdown-item">
							<i class="ni ni-settings-gear-65"></i>
							<span>{{ __('menu.Language') }}</span>
						</a>

						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
							<i class="ni ni-user-run"></i>
							<span>{{__('menu.Logout')}}</span>
						</a>
					</div>
				</li>
			</ul>

			{{-- Collapse --}}
			<div class="collapse navbar-collapse" id="sidenav-collapse-main">
				{{-- Collapse header --}}
				<div class="navbar-collapse-header d-md-none">
					<div class="row">
						<div class="col-6 collapse-brand">
							<a href="#">
								<img src="{{asset('assets/img/brand/blue.png')}}" alt="profile pic">
							</a>
						</div>
						<div class="col-6 collapse-close">
							<button type="button" class="navbar-toggler" data-toggle="collapse"
								data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
								aria-label="Toggle sidenav">
								{{-- close button --}}
								<span></span>
								<span></span>
								{{-- endof close button --}}
							</button>
						</div>
					</div>
				</div>

				{{-- Navigation --}}
				<ul class="navbar-nav">
					@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
					@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')

				</ul>


			</div>

		</div>
	</nav>


	<div class="main-content" id="main-content">

		{{-- Top-Navbar --}}
		<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
			<div class="container-fluid">
				{{-- Brand --}}
				<a class="h4 mb-0 text-white  d-none d-md-inline-block" href="javascript:history.back()">
					<span> <i class="ni ni-bold-left"></i></span>
				</a>

				{{-- User --}}
				<ul class="navbar-nav align-items-center d-none d-md-flex">
					<li class="nav-item dropdown">
						<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
							<div class="media align-items-center">
								<span class="avatar avatar-sm rounded-circle">
									<img alt="profile pic" src="{{ asset('assets/img/theme/girl.png') }}">
								</span>
								<div class="media-body ml-2 d-lg-block">
									<span class="mb-0  font-weight-bold">
										{{ Auth::user()->userName }}
									</span>
								</div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
							<div class=" dropdown-header noti-title">
								<h6 class="text-overflow m-0 notification-title">
									{{ __('menu.'.Auth::user()->role) }}
								</h6>
							</div>
							<a href="{{route('my-profile')}}" class="dropdown-item">
								<i class="ni ni-single-02"></i>
								<span>{{__('menu.My profile')}}</span>
							</a>
							<a href="{!! App::getLocale()=='en' ? '/language/si' : '/language/en' !!}"
								class="dropdown-item">
								<i class="ni ni-settings-gear-65"></i>
								<span>{{ __('menu.Language') }}</span>
							</a>


							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
						  document.getElementById('logout-form').submit();">
								<i class="ni ni-user-run"></i>
								<span>{{__('menu.Logout')}}</span>
							</a>




							{{-- logout post --}}
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
				</ul>

			</div>
		</nav>
		{{-- End of Top-Navbar --}}

		{{-- Header --}}
		<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
			<div class="container-fluid">
				<div class="header-body">
					{{-- Card stats --}}
					<div class="row">

						@yield('header')

					</div>
				</div>
			</div>
		</div>
		{{-- End of header --}}

		{{-- Page content --}}
		<div class="container-fluid mt--7">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="card">
							<div class="card-header">{{ __('Verify Your Email Address') }}</div>

							<div class="card-body">
								@if (session('resent'))

								<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
									<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
									<span class="alert-inner--text mx-2">
										<strong class="mx-1">Success!</strong>
										{{ __('A fresh verification link has been sent to your email address.') }}

									</span>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								@endif

								{{ __('Before proceeding, please check your email for a verification link.') }}
								{{ __('If you did not receive the email') }}, <a
									href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
							</div>
						</div>
					</div>
				</div>
			</div>




			{{-- Footer --}}
			<footer class="footer pt-9">
				<div class="row align-items-center justify-content-xl-between">
					<div class="col-xl-6">
						<div class="copyright text-center text-xl-left text-muted">
							&copy; 2019 <a href="#" class="font-weight-bold ml-1" target="_blank">Ē-Crew</a>
						</div>
					</div>
				</div>
			</footer>
			{{-- End of Footer --}}

		</div>
		{{-- End of Page content --}}

	</div>








	{{-- Core --}}
	<script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>