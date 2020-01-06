@extends('layouts.app')

@section('title','Employee Profile')

@section('sidebar')
@include('admin.include.sidebar')
@endsection

@section('header')

<div class="container-fluid d-flex align-items-center">
	{{-- Alert notifications --}}
	<div class="col">
		<h1 class="display-2 text-white text-uppercase">{{$employee->name}}'{{__('menu.s Profile')}}</h1>
		<p class="text-white mt-0 mb-5">{{__('menu.Role')}} : <span class="text-uppercase">{{$employee->role}}</span>
		</p>
		@if (session('status'))
		<div class="alert alert-success alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Success!</strong>{{session('status')}}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		{{-- alert only displayed; if the page redirected by registration request --}}
		@if (url()->previous()==route('register'))
		<div class="alert alert-info alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Need to Assign-vat categories!</strong><a
					href="#assignVat" class="btn btn-sm btn-primary mx-3">Click me</a></span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
		@elseif($errors->any())
		<div class="alert alert-danger alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2">
				<strong class="mx-1">Error!</strong>
				Data you entered is/are incorrect
				<a href="#" class="btn btn-sm btn-primary mx-3 update-info">view</a>
			</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>
	{{-- end of Alert notifications --}}
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
			<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
				<div class="d-flex justify-content-between">
					<a href="#" class="btn btn-sm btn-success mr-4 update-info">Update info</a>

				</div>
			</div>
			<div class="card-body pt-0 pt-md-4">
				<div class="text-center pt-6">
					<form action="{{route('promote-to-admin')}}" method="POST" id="promote">
						@csrf
						@method('put')
						<input hidden name="id" value="{{$employee->id}}">
					</form>

					<div class="h5 font-weight-300">
						<button class="btn btn-default" data-toggle="modal" onclick="javascript:event.preventDefault()"
							data-target="#confirm-promotion">PROMOTE AS ADMIN</button>
					</div>

					<h3>{{__('menu.Name')}} : {{$employee->name}}</h3>
					<div class="h5 font-weight-300">
						<i class="far fa-user"></i>{{__('menu.Username')}} : {{$employee->userName}}
					</div>

					<div>
						<i class="far fa-id-card"></i>{{__('menu.NIC')}} : {{$employee->nic}}
					</div>

					<hr class="my-4">

					<div class="h5 mt-4">
						<i class="fas fa-at"></i> {{__('menu.E-Mail')}} : <a href="#">{{$employee->email}}</a>
					</div>
					<div>
						<i class="fas fa-phone"></i> {{__('menu.Phone No')}} : {{$employee->phone}}
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- Confirmation modal --}}
	<div class="modal fade" id="confirm-promotion" tabindex="-1" role="dialog" aria-labelledby="modal-default"
		aria-hidden="true">
		<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<h1 class="modal-title" id="modal-title-default">Confirmation !</h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you wish promote {{$employee->name}} as Admin?
					</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" onclick="javascript:location.reload()">Cancel</button>
					<button type="button" class="btn  btn-primary ml-auto" data-dismiss="modal"
						onclick="javascript:document.getElementById('promote').submit();">Confirm</button>
				</div>

			</div>
		</div>
	</div>
	{{-- end of Confirmation modal --}}

	<div class="col-xl-8 order-xl-1">
		<div class="card bg-secondary shadow">
			<div class="card-header bg-white border-0">
				<div class="row align-items-center">
					<div class="col-8">
						<h3 class="mb-0 text-uppercase">{{$employee->name}} '{{__('menu.s details')}}</h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div id="update-data">
					{{-- Employee details form --}}
					<form method="POST" id="employee-details-form"
						action="{{route('update-employee',['id'=>$employee->id])}}">
						<h6 class="heading-small text-muted mb-4">{{__('menu.Update employee information')}}</h6>
						@csrf
						@method('put')
						<div class="form-group row pt-3">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Name')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('name') is-invalid  @enderror" type="text"
									value="{{old('name',$employee->name)}}" id="name" name="name">
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
									value="{{old('userName',$employee->userName)}}" id="userName" name="userName">
								@error('userName')
								<span class="invalid-feedback" role="alert">
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
									value="{{old('email',$employee->email)}}" id="email" name="email">
								@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-week-input"
								class="col-md-2 col-form-label form-control-label">{{__('menu.NIC')}}</label>
							<div class="col-md-10">
								<input class="form-control @error('nic') is-invalid @enderror" type="text"
									value="{{old('nic',$employee->nic)}}" id="nic" name="nic">
								@error('nic')
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
									value="{{old('phone',$employee->phone)}}" id="phone" name="phone">
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
										<p>Are you sure you wish to Update the details of {{$employee->name}} ?
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

				<h6 class="heading-small text-muted mb-4">{{__('menu.Assigned VAT categories')}}</h6>
				{{-- Assign VAT categories form --}}
				<form id="assign-vat-categories-form" action="{{route('assign-vat')}}" method="POST">
					@csrf
					<input name="id" id="id" value="{{$employee->id}}" hidden>
					<div class="row">
						@foreach ($vats as $vat)
						<div class="col-lg-5 d-flex">
							<div class="ml-4 d-inline-block">
								<label class="custom-toggle">
									{{-- if vat is already assigned to employee then mark it as checked --}}
									<input id="{{$vat->id}}" name="{{$vat->id}}" type="checkbox"
										{!!in_array($vat->id,$assignedVats) ? 'checked':'' !!} value="{{$vat->id}}">
									<span class="custom-toggle-slider rounded-circle"></span>
								</label>
							</div>
							<div class="px-2 d-inline-block">{{$vat->name}}</div>
						</div>
						@endforeach
					</div>
					<div class="form" form-group>
						<button class="btn btn-primary float-right" data-toggle="modal"
							onclick="javascript:event.preventDefault()"
							data-target="#confirm-assign-vat">{{__('menu.Assign')}}</button>
					</div>

					{{-- Confirmation modal --}}
					<div class="modal fade" id="confirm-assign-vat" tabindex="-1" role="dialog"
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
									<p>Are you sure you wish to reassign new Vat categories to {{$employee->name}} ?
									</p>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link"
										onclick="javascript:location.reload()">Cancel</button>
									<button type="button" class="btn  btn-primary ml-auto" data-dismiss="modal"
										onclick="javascript:document.getElementById('assign-vat-categories-form').submit();">Confirm</button>
								</div>

							</div>
						</div>
					</div>
					{{-- end of Confirmation modal --}}
				</form>
				{{-- end of Assign VAT categories form --}}
			</div>
		</div>
	</div>
</div>

@endsection

@push('script')
<script>
	$(document).ready(function() {
		$("#update-data").hide();
		$(".update-info").click(function(){
			$("#update-data").slideToggle();
			$("#name").focus();
		})
      } );
</script>
@endpush