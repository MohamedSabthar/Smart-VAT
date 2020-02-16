@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('title','Register')

@section('sidebar')
@if (Auth::user()->role=='admin')
@include('admin.include.sidebar')
@else
@include('employee.include.sidebar')
@endif
@endsection

@section('header')
<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>
					<span class="h2 font-weight-bold mb-0">350,897</span>
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
						<i class="fas fa-chart-bar"></i>
					</div>
				</div>
			</div>
			<p class="mt-3 mb-0 text-muted text-sm">
				<span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
				<span class="text-nowrap">Since last month</span>
			</p>
		</div>
	</div>
</div>
<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
					<span class="h2 font-weight-bold mb-0">2,356</span>
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
						<i class="fas fa-chart-pie"></i>
					</div>
				</div>
			</div>
			<p class="mt-3 mb-0 text-muted text-sm">
				<span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
				<span class="text-nowrap">Since last week</span>
			</p>
		</div>
	</div>
</div>
<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
					<span class="h2 font-weight-bold mb-0">924</span>
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
						<i class="fas fa-users"></i>
					</div>
				</div>
			</div>
			<p class="mt-3 mb-0 text-muted text-sm">
				<span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
				<span class="text-nowrap">Since yesterday</span>
			</p>
		</div>
	</div>
</div>

<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
					<span class="h2 font-weight-bold mb-0">49,65%</span>
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-info text-white rounded-circle shadow">
						<i class="fas fa-percent"></i>
					</div>
				</div>
			</div>
			<p class="mt-3 mb-0 text-muted text-sm">
				<span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
				<span class="text-nowrap">Since last month</span>
			</p>
		</div>
	</div>
</div>

<div class="container-fluid d-flex align-items-center">
	{{-- Alert notifications --}}
	<div class="col">
		@if (session('status'))
		<div class="alert alert-success alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Success!</strong>{{session('status')}}
				<a href="#" class="btn btn-sm btn-primary mr-4 add-buissness">{{__('menu.Add Buissness')}}</a>
			</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		{{-- alert only displayed; if the page redirected by registration request --}}
		@if (url()->previous()==route('vat-payer-registration'))
		<div class="alert alert-info alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Need to Assign-vat categories!</strong><a
					href="#registerPayer" class="btn btn-sm btn-primary mx-3">Click me</a></span>
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
				{{-- <a href="#" class="btn btn-sm btn-primary mx-3 update-info">view</a> --}}
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

<div class="row">
	<div class="col">

		<div class="card shadow">
			<div class="card-header bg-transparent">
<<<<<<< HEAD
				<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Register VAT Payer')}}</span></h3>
=======
			<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Register VAT Payer')}}</span></h3>
>>>>>>> 882797ab908ae01f64ac7d6e188aa0eb3e963f31
			</div>

			<div class="card-body bg-secondary ">

				{{--VAT payers Registration form  --}}
				<form method="POST" action="{{route('vat-payer-registration',['requestFrom'=>$requestFrom])}}"
					onsubmit="return confirm-register-business(this)">
					@csrf

					<div class="form-group row  pt-3">
						<label for="example-week-input"
							class="col-md-2 col-form-label form-control-label">{{__('menu.NIC')}}</label>
						<div class="col-md-10">
							<input class="form-control @error('nic') is-invalid @enderror" type="text"
								value="{{old('nic')}}" id="nic" name="nic">
							<span id="error_nic" class="invalid-feedback" role="alert">

							</span>
							@error('nic')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
							{{__('menu.First Name')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('first_name') is-invalid  @enderror" type="text"
								value="{{old('first_name')}}" id="first_name" name="first_name">
							@error('first_name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="example-search-input" class="col-md-2 col-form-label form-control-label">
							{{__('menu.Middle Name')}}</label>
						<div class="col-md-10">
							<input class="form-control @error('middle_name') is-invalid @enderror" type="text"
								value="{{old('middle_name')}}" id="middle_name" name="middle_name">
							@error('middle_name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="example-search-input" class="col-md-2 col-form-label form-control-label">
							{{__('menu.Last Name')}}</label>
						<div class="col-md-10">
							<input class="form-control @error('last_name') is-invalid @enderror" type="text"
								value="{{old('last_name')}}" id="last_name" name="last_name">
							@error('last_name')
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
								value="{{old('email')}}" id="email" name="email">
							@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="example-time-input" class="col-md-2 col-form-label form-control-label">
							{{__('menu.Phone No')}}</label>
						<div class="col-md-10">
							<input class="form-control @error('phone') is-invalid @enderror" type="text"
								value="{{old('phone')}}" id="phone" name="phone">
							@error('phone')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row pt-3">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Door No.')}}</label>

						<div class="col-md-10 ">
							<input class="form-control @error('doorNo') is-invalid  @enderror" type="text"
								value="{{old('doorNo')}}" id="doorNo" name="doorNo">
							@error('doorNo')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row pt-3">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Street')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('street') is-invalid  @enderror" type="text"
								value="{{old('street')}}" id="street" name="street">
							@error('street')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row pt-3">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.City')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('city') is-invalid  @enderror" type="text"
								value="{{old('city')}}" id="city" name="city">
							@error('city')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>


					<!-- button with onclick event that triggers the form validation. If the form is valid, triggers click of second button -->
					<div class="form-group">
						<button type="submit" id="register" value="Submit" class="btn btn-primary float-right"
<<<<<<< HEAD
							onclick="if(formIsValid() $('#triggerModal').click();)">{{__('menu.Register')}}</button>
=======
					onclick="if(formIsValid() $('#triggerModal').click();)">{{__('menu.Register')}}</button>
>>>>>>> 882797ab908ae01f64ac7d6e188aa0eb3e963f31
					</div>

					<!-- hidden submit button -->
					<div class="form-group">
						<button type="submit" id="triggerModal" hidden value="Submit" class="btn btn-info btn-lg"
							data-toggle="modal" data-target="#confirm-register-business">Submit2</button>
					</div>

					{{-- Confirmation modal for adding business for the registered VAT payer--}}
					<div class="modal fade" id="confirm-register-business" tabindex="-1" role="dialog"
						aria-labelledby="modal-default" aria-hidden="true">
						<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
							<div class="modal-content">

								<div class="modal-header">
									<h1 class="modal-title" id="modal-title-default">{{__('menu.Confirmation !')}}</h1>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div class="modal-body">
									<strong>{{__('menu.This VAT payer is alredy registered')}}</strong>
									<p>{{__('menu.Are you wish to add a New Business/Payment ?')}} </p>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link"
										onclick="javascript:location.reload()">{{__('menu.Cancel')}}</button>
									<a href="" id="redirect" class="btn  btn-primary ml-auto">{{__('menu.Yes')}}</a>
								</div>

							</div>
						</div>
					</div>
					{{-- End of confirmation modal --}}
				</form>

			</div>


		</div>
	</div>
</div>

@endsection

@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>


<script>
	$(document).ready(function(){

		$('#nic').blur(function(){
			var error_nic = '';
			var nic = " ";
			var nic = $('#nic').val();       //geting nic textbox value (id=nic) to nic variable
			var _token = $('input[name="_token"]').val();

			if(nic)
			{

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
	
				});
			var formdata = {'nic':nic}
				console.log(formdata);
				
				$.ajax({
				url:"{{ route('nic_available.check') }}", 
				method:"POST",
				data: formdata,
				success:function(result)
				{
					console.log(result);
					
					if(result.data == 'not_unique')
					{
						$('#nic').addClass('is-invalid');
						$('#error_nic').html('<strong>NIC already available</strong>');
						$('#redirect').attr("href","/{{ app('request')->requestFrom }}/profile/"+result.id);
						$('#confirm-register-business').modal('show');
						$('#register').attr('disabled', true);
					}
				}
			});
			}
			else{
				// disabling registration 
				$('#error').addClass('has-error');
				$('#register').attr('disabled', 'disabled');  
			}

		});
	});
</script>

@endpush