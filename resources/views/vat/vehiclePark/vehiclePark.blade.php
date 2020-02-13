@extends('layouts.app')

@section('title','Vehicle Park Tax')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						Vehicle Park Tax payers
					</h3>
					{{-- <span class=" font-weight-bold mb-0">924</span> --}}
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
						<i class="fas fa-users"></i>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						Latest Payments
					</h3>
					{{-- <span class="h2 font-weight-bold mb-0">2,356</span> --}}
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
						<i class="fas fa-chart-pie"></i>
					</div>
				</div>
			</div>

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

<div class="col-xl-3 col-lg-6" 
    {{-- onclick="javascript:window.open(`{{route('vehicle-park-generate-report')}}`,'_self')" --}}
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">Report Generation</h3>
					{{-- <span class="h2 font-weight-bold mb-0">2,356</span> --}}
				</div>
				<div class="col-auto">
					<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
						<i class="fas fa-chart-pie"></i>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection

@section('pageContent')
  {{-- Tables --}}

<div class="row mt-5">
  <div class="col-xl-6 mb-5 mb-xl-0">
	<div class="card shadow">
	  <div class="card-header border-0">
		<div class="row align-items-center">
		  <div class="col">
			<h3 class="mb-0">Amounts allocated for parks Inside Fort</h3>
		  </div>
			<div class="col-6 text-right">
				<button class="btn btn-sm btn-primary text-white" data-toggle="tooltip"
					data-placement="right" title="Click to view assigned ticketing officers"
					onclick="javascript:window.open('{{route('vehicle-park-ticketing-officers')}}','_self')">
					{{-- <span><i class="fas fa-user-plus"></i></span> --}}
					<span class="btn-inner--text">Officers Assigned</span>
				</button>
			</div>
		</div>
	  </div>
	  <div class="card-header border-0">
		<div class="row align-items-center">
			<div class="col-7 text-right">
				<button class="btn btn-sm btn-success text-white" data-toggle="tooltip"
					data-placement="right" title="Click to view payments"
					onclick="javascript:window.open('{{route('vehicle-park-vehicleParkPayments')}}','_self')">
					{{-- <span><i class="fas fa-user-plus"></i></span> --}}
					<span class="btn-inner--text">View Payments</span>
				</button>
			</div>
		</div>
	  </div>
	  <div class="table-responsive">
		<!-- table for vahicle park inside Fort -->
		<table class="table align-items-center table-flush">
		  <thead class="thead-light">
			<tr>
			  <th scope="col">vehicle</th>
			  <th scope="col">01 Hour</th>
			  <th scope="col">1-6 Hours</th>
			  <th scope="col">Day</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row">Bicycle</th>
			  <td>5/=</td>
			  <td>10/=</td>
			  <td>50/=</td>
			</tr>
			<tr>
			  <td>Motor Bike</td>
			  <td>10/=</td>
			  <td>50/=</td>
			  <td>150/=</td>
			</tr>
			<tr>
			  <td>Three Wheel</td>
			  <td>20/=</td>
			  <td>100/=</td>
			  <td>250/=</td>
			</tr>
			<tr>
			  <td>Van and Car</td>
			  <td>30/=</td>
			  <td>250/=</td>
			  <td>500/=</td>
			</tr>
			<tr>
			  <td>Lorry, Truck and Other</td>
			  <td>200/=</td>
			  <td>500/=</td>
			  <td>1,500/=</td>
			</tr>
			<tr>
				<td>School Van</td>
				<td>100/=</td>
				<td>200/=</td>
				<td>500/=</td>
			  </tr>
		  </tbody>
		</table>
	  </div>
	</div>
  </div>

	<div class="col-xl-6 mb-5 mb-xl-0">
	  <div class="card shadow">
		<div class="card-header border-0">
		  <div class="row align-items-center">
			<div class="col">
			  <h3 class="mb-0">Amounts allocated for parks outside Fort</h3>
			</div>
			<div class="col-6 text-right">
			  <button class="btn btn-sm btn-primary text-white" data-toggle="tooltip"
				  data-placement="right" title="Click to view assigned ticketing officers"
				  onclick="javascript:window.open('{{route('vehicle-park-ticketing-officers')}}','_self')">
				  {{-- <span><i class="fas fa-user-plus"></i></span> --}}
				  <span class="btn-inner--text">Officers Assigned</span>
			  </button>
		  </div>
		  </div>
		</div>
		<div class="card-header border-0">
			<div class="row align-items-center">
				<div class="col-7 text-right">
					<button class="btn btn-sm btn-success text-white" data-toggle="tooltip"
						data-placement="right" title="Click to view payments"
						onclick="javascript:window.open('{{route('vehicle-park-vehicleParkPayments')}}','_self')">
						{{-- <span><i class="fas fa-user-plus"></i></span> --}}
						<span class="btn-inner--text">View Payments</span>
					</button>
				</div>
			</div>
		  </div>
		<div class="table-responsive">
		  <!-- table for vahicle park inside Fort -->
		  <table class="table align-items-center table-flush">
			<thead class="thead-light">
			  <tr>
				<th scope="col">vehicle</th>
				<th scope="col">01 Hour</th>
				<th scope="col">1-6 Hours</th>
				<th scope="col">Day</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<th scope="row">Bicycle</th>
				<td>5/=</td>
				<td>10/=</td>
				<td>15/=</td>
			  </tr>
			  <tr>
				<td>Motor Bike</td>
				<td>10/=</td>
				<td>50/=</td>
				<td>20/=</td>
			  </tr>
			  <tr>
				<td>Three Wheel</td>
				<td>15/=</td>
				<td>25/=</td>
				<td>35/=</td>
			  </tr>
			  <tr>
				<td>Van and Car</td>
				<td>20/=</td>
				<td>40/=</td>
				<td>70/=</td>
			  </tr>
			  <tr>
				<td>Lorry, Truck and Other</td>
				<td>40/=</td>
				<td>80/=</td>
				<td>140/=</td>
			  </tr>
			  <tr>
				  <td>School Van</td>
				  <td>100/=</td>
				  <td>200/=</td>
				  <td>500/=</td>
				</tr>
			</tbody>
		  </table>
		</div>
	  </div>
	</div>
@endsection

@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function() {

        var id = '#industrial_payer_table';                      //data table id
        var table = $(id).DataTable({
          "pagingType": "full_numbers",
          "sDom": '<'+
          '<"row"'+
          '<"col-sm-12 col-md-6 px-md-5"l>'+
          '<"col-sm-12 col-md-6 px-md-5"f>'+
          '>'+
          '<"py-2"t>'+
          '<"row"'+
          '<"py-3 col-sm-12 col-md-6 px-md-5"i>'+
          '<"py-3 col-sm-12 col-md-6 px-md-5 px-sm-3"p>>'+
          '>'
        });            //table object
 
        $(id+'_length select').removeClass('custom-select custom-select-sm'); //remove default classed from selector
        

</script>
@endpush