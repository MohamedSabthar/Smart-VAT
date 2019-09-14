@extends('layouts.app')

@section('title','Dashboard')

@section('sidebar')
@include('admin.include.sidebar')
@endsection

@section('header')

<div class="container-fluid d-flex align-items-center">
	<div class="col">
		<h1 class="display-2 text-white text-uppercase">{{$employee->name}}'s Profile</h1>
		<p class="text-white mt-0 mb-5">Role : <span class="text-uppercase">{{$employee->role}}</span></p>
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
					<h3>Name : {{$employee->name}}</h3>
					<div class="h5 font-weight-300">
						<i class="far fa-user"></i> Username : {{$employee->userName}}
					</div>

					<div>
						<i class="far fa-id-card"></i> NIC : {{$employee->nic}}
					</div>

					<hr class="my-4">

					<div class="h5 mt-4">
						<i class="fas fa-at"></i> E-Mail : <a href="#">{{$employee->email}}</a>
					</div>
					<div>
						<i class="fas fa-phone"></i> Phone No : {{$employee->phone}}
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
						<h3 class="mb-0 text-uppercase">{{$employee->name}}'s details</h3>
					</div>
					<div class="col-4 text-right">
						<a href="#" class="btn btn-sm {!! $employee->status ? 'btn-danger' : 'btn-success' !!}">
							{!! $employee->status ? 'Block' : 'Unblock' !!}
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form method="POST" action="{{route('update-employee',['id'=>$employee->id])}}">
					<h6 class="heading-small text-muted mb-4"> Update mployee information</h6>
					@csrf
					@method('put')
					<div class="form-group row pt-3">
						<label for="example-text-input" class="col-md-2 col-form-label form-control-label ">Name</label>
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
							class="col-md-2 col-form-label form-control-label">Username</label>
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
							class="col-md-2 col-form-label form-control-label">Email</label>
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
						<label for="example-week-input" class="col-md-2 col-form-label form-control-label">NIC</label>
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
						<label for="example-time-input" class="col-md-2 col-form-label form-control-label">Phone
							No</label>
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
						<input class=" btn btn-primary float-right" value="Update" type="submit">
					</div>
				</form>
				<hr class="my-4 mt-7">
				<!-- Address -->
				<h6 class="heading-small text-muted mb-4">Assigned VAT categories</h6>
				<form id="assignVat" action="{{route('assign-vat')}}" method="POST">
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
					<div class="form-group">
						<input class=" btn btn-primary float-right" value="Assign" type="submit">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection