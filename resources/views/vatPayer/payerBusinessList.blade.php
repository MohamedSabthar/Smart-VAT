@extends('layouts.app')

@section('title','Dashboard')

@section('sidebar')
@include('admin.include.sidebar')
@endsection

@section('header')

<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        {{-- <div id="#card" class="card-body" style="cursor:pointer" onclick="javascript:window.open('/','_self')"> --}}
        <div id="#card" class="card-body">
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
    {{-- <div id="#card" class="card-body" style="cursor:pointer" onclick="javascript:window.open('/','_self')"> --}}
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
<div class = "pt-5">
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
					
					<div class="h5 font-weight-300">
						
					</div>

					<div>
						
					</div>

					<hr class="my-4">

					<div class="h5 mt-4">
						
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
                    <h3 class="mb-0"><span class="text-uppercase">{{__('menu.VAT Payer Business List')}}</span></h3>
					</div>
					
				</div>
			</div>
			<div class="card-body">
				<form method="POST" action="{{route('register')}}">
					<h4 class="heading-small text-muted mb-4">{{__('menu.Add new Business')}}</h4>
					@csrf					
					<div class="form-group row pt-3">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">{{__('menu.Assesment No.')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('name') is-invalid  @enderror" type="text"
								value="{{old('name')}}" id="name" name="name">
							@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">{{__('menu.Annual Assesment Amount')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('name') is-invalid  @enderror" type="text"
								value="{{old('name')}}" id="name" name="name">
							@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">{{__('menu.Business Name')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('name') is-invalid  @enderror" type="text"
								value="{{old('name')}}" id="name" name="name">
							@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">{{__('menu.Business')}}</label>
						<div class="col-md-10 ">	
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('menu.Select Business')}}
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Maintaining a place for the sale of Sweet meats</a></li>
                                <li><a href="#">Sale of cooked /processed food</a></li>
                                <li><a href="#">Packing, storage or sale of Tea</a></li>
                            </ul>
                        </div>
						</div>
					</div>
					<div class="form-group row">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">{{__('menu.Business Address')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('name') is-invalid  @enderror" type="text"
								value="{{old('name')}}" id="name" name="name">
							@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group">
						<input class=" btn btn-primary float-right" value="Submit" type="submit">
					</div>
				</form>
				<hr class="my-4 mt-7">		
             </div>

            <!-- business list -->
                <div class="card-body">
                <form id="assignVat" action="">
                    <h4 class="heading-small text-muted mb-4"> Business List</h4>
                <div class="table-responsive">
                <table id="example" class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.Assesment No.')}}</th>
                            <th>{{__('menu.Business Name')}}</th>  
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchaAssesmentNo"
                                    placeholder="{{__('menu.Assesment No.')}}" /></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td><a href="{{route('payment-list')}}">Maintaining a place for the sale of Sweet meats</a></td>    
                        </tr>
                        <tr>
                            <td>02</td>
                            <td><a href="{{route('payment-list')}}">Bulk Storage of Sweet meats, Biscuits, for wholesale distribution</a></td>   
                        </tr>
                        <tr>
                            <td>03</td>
                            <td><a href="{{route('payment-list')}}">Sale of cooked /processed food</a></td>  
                        </tr>
                        <tr>
                            <td>04</td>
                            <td><a href="{{route('payment-list')}}">Packing, storage or sale of Tea</a></td>            
                        </tr>
                        <tr>
                            <td>05</td>
                            <td><a href="{{route('payment-list')}}">Storage and sale or distribution of milk powder or Biscuits</a></td>   
                        </tr>
                    </tbody>
                </table>
            </div>
          
            </form>    
			  </div>	    
		</div>
	</div>
</div>
</div>

@endsection