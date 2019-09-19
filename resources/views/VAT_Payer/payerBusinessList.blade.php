@extends('layouts.app')

@section('title','Payer Business List')

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
						<h3 class="mb-0">{{__('menu.VAT Payer Business List')}}</h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form>
               
            <div class="table-responsive py-4">
                <table id="example" class="table  px-5">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.Assesment No.')}}</th>
                            <th>{{__('menu.Business ')}}</th>
                           
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchaAssesmentNo."
                                    placeholder="{{__('menu.Search Assesment No.')}}" /></th>
                           
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><a href="{{route('vat-payer-businessPayment-list')}}">Herrod Chandler</a></td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            
                        </tr>
                        <tr>
                            <td><a href="{{route('vat-payer-business-list')}}">Herrod Chandler</a></td>
                            <td>Integration Specialist</td>
                            <td>New York</td>
                            <td>61</td>
                            <td>2012/12/02</td>
                            <td>$372,000</td>
                        </tr>
                        <tr>
                            <td><a href="{{route('vat-payer-business-list')}}">Herrod Chandler</a></td>
                            <td>Sales Assistant</td>
                            <td>San Francisco</td>
                            <td>59</td>
                            <td>2012/08/06</td>
                            <td>$137,500</td>
                        </tr>
                        <tr>
                            <td>Rhona Davidson</td>
                            <td>Integration Specialist</td>
                            <td>Tokyo</td>
                            <td>55</td>
                            <td>2010/10/14</td>
                            <td>$327,900</td>
                        </tr>
                        <tr>
                            <td>Colleen Hurst</td>
                            <td>Javascript Developer</td>
                            <td>San Francisco</td>
                            <td>39</td>
                            <td>2009/09/15</td>
                            <td>$205,500</td>
                        </tr>
                        <tr>
                            <td>Sonya Frost</td>
                            <td>Software Engineer</td>
                            <td>Edinburgh</td>
                            <td>23</td>
                            <td>2008/12/13</td>
                            <td>$103,600</td>
                        </tr>
                        {{-- @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->id}}</th>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->userName}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->admin->name}}</td>

                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="{{route('employee-profile',['id'=>$employee->id])}}">View profile</a>
                                </div>

                            </div>
                        </td>


                        </tr>
                        @endforeach --}}


                    </tbody>
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.User ID')}}</th>
                            <th>{{__('menu.Employee Name')}}</th>
                            <th>{{__('menu.Username')}}</th>
                            <th>{{__('menu.Email')}}</th>
                            <th>{{__('menu.Registerd By')}}</th>
                            <th></th>
                        </tr>
                    </thead>

                </table>
            </div>
            <div class="card-header bg-transparent">
				<h4 class="mb-0"><span class="text-uppercase">Add new Business</span></h4>
            </div>
            <div class="form-group">
						<input class=" btn btn-primary float-right" type="submit">
					</div>
					
				</form>
				
			</div>

		</div>


	</div>

</div>


@endsection