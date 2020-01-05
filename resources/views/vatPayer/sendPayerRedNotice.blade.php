@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('title','Send Email')

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
@endsection
@section('pageContent')

<div class="row">
	<div class="col">

		<div class="card shadow">
			<div class="card-header bg-transparent">
				<h3 class="mb-0"><span class="text-uppercase">Genarating Red Notice for the over due payments</span></h3>
			</div>
			
			<div class="card-body ">
			   
					<form method="POST" action="#">
							@csrf
							<div class="form-group row pt-3">
								<label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
									{{__('menu.Name')}}</label>
								<div class="col-md-10 ">
									<input class="form-control @error('name') is-invalid  @enderror" type="text"
										value="{{old('name','Tharushi')}}" id="name" name="name">
									@error('name')
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


                            <div class="form-group row pt-3">
                                    <label for="example-text-input"
                                        class="col-md-2 col-form-label form-control-label ">{{__('menu.Address')}}</label>
                                    <div class="col-md-10 ">
                                        <input class="form-control @error('street') is-invalid  @enderror" type="text"
                                            value="{{old('adress')}}" id="adress" name="address">
                                        @error('adress')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                            </div>

  
                            <div class="form-group">
                                    <input class=" btn btn-primary float-right" type="Send">
                            </div>
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
	$(document).ready(function() {
        var id = '#example';                      //data table id
        var table = $(id).DataTable({
          "pagingType": "full_numbers"
        });            //table object
        $(id+'_filter').addClass('pr-5');         //adding padding to table elements
        $(id+'_info').addClass('pl-5');
        $(id+'_paginate').addClass('pr-5');
        $(id+'_length').addClass('pl-5')
        $(id+'_length select').removeClass('custom-select custom-select-sm'); //remove default classed from selector
        
        $('#searchName').on( 'keyup', function () { //individulat column search
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
      } );
</script>
@endpush


				{{-- @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                         <ul>
                            @foreach($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul> 
                    </div>
                @endif  --}}