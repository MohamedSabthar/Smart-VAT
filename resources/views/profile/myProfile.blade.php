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
							<img src="{{asset('assets/img/theme/girl.png')}}" class="rounded-circle">
						</a>
					</div>
				</div>
			</div>

			<div class="card-body pt-0 pt-md-4">
				<div class="text-center pt-9">



					<h3>{{__('menu.Name')}} : {{Auth::user()->name}}</h3>
					<div class="h5 font-weight-300">
						<i class="far fa-user"></i>{{__('menu.Username')}} : {{Auth::user()->userName}}
					</div>

					<div>
						<i class="far fa-id-card"></i>{{__('menu.NIC')}} : {{Auth::user()->nic}}
					</div>

					<hr class="my-4">

					<div class="h5 mt-4">
						<i class="fas fa-at"></i> {{__('menu.E-Mail')}} : <a href="#">{{Auth::user()->email}}</a>
					</div>
					<div>
						<i class="fas fa-phone"></i> {{__('menu.Phone No')}} : {{Auth::user()->phone}}
					</div>
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

				</div>
			</div>
			<div class="card-body">
				<div id="update-data">
					{{-- Employee details form --}}
					<form method="POST" id="employee-details-form"
						action="{{route('update-profile',['id'=>Auth::user()->id])}}">
						<h6 class="heading-small text-muted mb-4">{{__('menu.Update employee information')}}</h6>
						@csrf
						@method('put')
						<div class="form-group row pt-3">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Name')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('name') is-invalid  @enderror" type="text"
									value="{{old('name',Auth::user()->name)}}" id="name" name="name">
								@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-search-input"
								class="col-md-2 col-form-label form-control-label">{{__('menu.Username')}}</label>
							<div class="col-md-10">
								<input class="form-control @error('userName') is-invalid @enderror" type="text"
									value="{{old('userName',Auth::user()->userName)}}" id="userName" name="userName"
									readonly @error('userName') <span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-email-input"
								class="col-md-2 col-form-label form-control-label">{{__('menu.Email')}}</label>
							<div class="col-md-10">
								<input class="form-control @error('email') is-invalid @enderror" type="email"
									value="{{old('email',Auth::user()->email)}}" id="email" name="email">
								@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-time-input"
								class="col-md-2 col-form-label form-control-label">{{__('menu.Phone No')}}</label>
							<div class="col-md-10">
								<input class="form-control @error('phone') is-invalid @enderror" type="text"
									value="{{old('phone',Auth::user()->phone)}}" id="phone" name="phone">
								@error('phone')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group">
							<button class="btn btn-primary float-right" data-toggle="modal"
								onclick="javascript:event.preventDefault()"
								data-target="#confirm-update-employee">{{__('menu.Update')}}</button>
						</div>

						{{-- Confirmation modal --}}
						<div class="modal fade" id="confirm-update-employee" tabindex="-1" role="dialog"
							aria-labelledby="modal-default" aria-hidden="true">
							<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
								<div class="modal-content">

									<div class="modal-header">
										<h1 class="modal-title" id="modal-title-default">Confirmation !</h1>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Are you sure you wish to Update the details of {{Auth::user()->name}} ?
										</p>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link"
											onclick="javascript:location.reload()">Cancel</button>
										<button type="button" class="btn  btn-primary ml-auto" data-dismiss="modal"
											onclick="javascript:document.getElementById('employee-details-form').submit();">Confirm</button>
									</div>

								</div>
							</div>
						</div>
						{{-- end of Confirmation modal --}}
					</form>
					{{-- end of Employee details form --}}
					<hr class="my-4 mt-7">
				</div>



				<form method="POST" action="{{ route('password.change',['userId'=>Auth::user()->id]) }}"
					id="change-password">
					@csrf

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
							<button class="btn btn-primary float-right" data-toggle="modal"
								onclick="javascript:event.preventDefault()" data-target="#confirm-password-change">
								{{ __('Reset Password') }}
							</button>

						</div>
				</form>


				{{-- Confirmation modal --}}
				<div class="modal fade" id="confirm-password-change" tabindex="-1" role="dialog"
					aria-labelledby="modal-default" aria-hidden="true">
					<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<h1 class="modal-title" id="modal-title-default">Confirmation !</h1>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Are you sure! Do you wish change the current password ?
								</p>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link"
									onclick="javascript:location.reload()">Cancel</button>
								<button type="button" class="btn  btn-primary ml-auto" data-dismiss="modal"
									onclick="javascript:document.getElementById('change-password').submit();">Confirm</button>
							</div>

						</div>
					</div>
				</div>
				{{-- end of Confirmation modal --}}
			</div>

		</div>


	</div>

</div>
</div>

@endsection