@extends('layouts.app')

@section('title','Dashboard')

@section('sidebar')
@if (Auth::user()->role=='admin')
@include('admin.include.sidebar')
@else
@include('employee.include.sidebar')
@endif
@endsection

@section('header')

<div class="container-fluid d-flex align-items-center">

	<div class="col">
		<h1 class="display-2 text-white">Welcome {{Auth::user()->name}}</h1>
		<p class="text-white mt-0 mb-5">Access level : <span class="text-uppercase">{{Auth::user()->role}}</span>
		</p>
		@if (session('status'))
		<div class="alert alert-success alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Success!</strong>{{session('status')}}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>

</div>
@endsection

@section('pageContent')
<div class="row ">
	<div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
		<div class="card card-profile shadow">
			<div class="row justify-content-center">
				<div class="col-lg-3 order-lg-2">
					<div class="card-profile-image">
						<a href="#">
							<img src="../assets/img/theme/girl.png" class="rounded-circle">
						</a>
					</div>
				</div>
			</div>
			<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
				<div class="d-flex justify-content-between">
					<a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
					<a href="#" class="btn btn-sm btn-default float-right">Message</a>
				</div>
			</div>
			<div class="card-body pt-0 pt-md-4">
				<div class="row">
					<div class="col">
						<div class="card-profile-stats d-flex justify-content-center mt-md-5">
							<div>
								<span class="heading">22</span>
								<span class="description">Friends</span>
							</div>
							<div>
								<span class="heading">10</span>
								<span class="description">Photos</span>
							</div>
							<div>
								<span class="heading">89</span>
								<span class="description">Comments</span>
							</div>
						</div>
					</div>
				</div>
				<div class="text-center">
					<h3>
						Jessica Jones<span class="font-weight-light">, 27</span>
					</h3>
					<div class="h5 font-weight-300">
						<i class="ni location_pin mr-2"></i>Bucharest, Romania
					</div>
					<div class="h5 mt-4">
						<i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
					</div>
					<div>
						<i class="ni education_hat mr-2"></i>University of Computer Science
					</div>
					<hr class="my-4">
					<p>Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and
						records all
						of his own music.</p>
					<a href="#">Show more</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-8 order-xl-1">
		<div class="card bg-secondary shadow">
			<div class="card-header bg-white border-0">
				<div class="row align-items-center">
					<div class="col-8">
						<h3 class="mb-0">My account</h3>
					</div>
					<div class="col-4 text-right">
						<a href="#!" class="btn btn-sm btn-primary">Settings</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form>
					<h6 class="heading-small text-muted mb-4">User information</h6>
					<div class="pl-lg-4">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group focused">
									<label class="form-control-label" for="input-username">Username</label>
									<input type="text" id="input-username" class="form-control form-control-alternative"
										placeholder="Username" value="lucky.jesse">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label" for="input-email">Email address</label>
									<input type="email" id="input-email" class="form-control form-control-alternative"
										placeholder="jesse@example.com">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group focused">
									<label class="form-control-label" for="input-first-name">First name</label>
									<input type="text" id="input-first-name"
										class="form-control form-control-alternative" placeholder="First name"
										value="Lucky">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group focused">
									<label class="form-control-label" for="input-last-name">Last name</label>
									<input type="text" id="input-last-name"
										class="form-control form-control-alternative" placeholder="Last name"
										value="Jesse">
								</div>
							</div>
						</div>
					</div>
					<hr class="my-4">
					<!-- Address -->
					<h6 class="heading-small text-muted mb-4">Contact information</h6>
					<div class="pl-lg-4">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group focused">
									<label class="form-control-label" for="input-address">Address</label>
									<input id="input-address" class="form-control form-control-alternative"
										placeholder="Home Address"
										value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" type="text">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group focused">
									<label class="form-control-label" for="input-city">City</label>
									<input type="text" id="input-city" class="form-control form-control-alternative"
										placeholder="City" value="New York">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group focused">
									<label class="form-control-label" for="input-country">Country</label>
									<input type="text" id="input-country" class="form-control form-control-alternative"
										placeholder="Country" value="United States">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label class="form-control-label" for="input-country">Postal code</label>
									<input type="number" id="input-postal-code"
										class="form-control form-control-alternative" placeholder="Postal code">
								</div>
							</div>
						</div>
					</div>
				</form>
				<form method="POST" action="{{ route('password.change',['userId'=>Auth::user()->id]) }}">
					@csrf
					<hr class="my-4">
					<!-- Description -->
					<h6 class="heading-small text-muted mb-4">Change Password</h6>
					<!-- Description -->
					<div class="pl-lg-4">

						<div class=" form-group row">
							<label for="password"
								class="col-md-3 col-form-label form-control-label">{{ __('password') }}</label>

							<div class="col-md-9">
								<input id="password" type="password"
									class="form-control @error('password') is-invalid @enderror" name="password"
									required>

								@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>


						<div class="form-group row">
							<label for="new_password"
								class="col-md-3 col-form-label form-control-label">{{ __('New Password') }}</label>

							<div class="col-md-9">
								<input id="new_password" type="password"
									class="form-control @error('new_password') is-invalid @enderror" name="new_password"
									required>

								@error('new_password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="new_password-confirm"
								class="col-md-3 col-form-label form-control-label">{{ __('Confirm Password') }}</label>

							<div class="col-md-9">
								<input id="new_password-confirm" type="password" class="form-control"
									name="new_password_confirmation" required>
							</div>
						</div>


						<div class="form-group  ">
							<button type="submit" class="btn btn-primary float-right">
								{{ __('Reset Password') }}
							</button>

						</div>
				</form>
			</div>

		</div>


	</div>

</div>
</div>

@endsection