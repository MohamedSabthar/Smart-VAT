@extends('layouts.app')

@section('title','Business Tax')
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
					<h5 class="card-title text-uppercase text-muted mb-0">Payment List</h5>
					<span class=" font-weight-bold mb-0">924</span>
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

@endsection

@section('pageContent')
<div class="pt-5">
	<div class="row">
		<div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
			<div class="card card-profile shadow">
				<div class="row justify-content-center">
					<div class="col-lg-3 order-lg-2">
						<div class="card-profile-image">
							<a href="#">
								<img src="../assets/img/theme/business.jpg" class="rounded-circle">
							</a>
						</div>
					</div>
				</div>
				<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
					<div class="d-flex justify-content-between">
						<a href="#" class="btn btn-sm btn-default float-right">Message</a>
					</div>
				</div>
				<div class="card-body pt-0 pt-md-4">
					<div class="test-left pt-5">
						<h3 class="d-inline">Business Name : </h3> {{$businessTaxShop->shop_name}}
						<div class="pt-1">
							<h3 class="d-inline">Address : </h3> {{$businessTaxShop->address}}
						</div>

						<div class="pt-1">
							<h3 class="d-inline"> Registration No. : </h3> {{$businessTaxShop->registration_no}}
						</div>

						<div class="pt-1">
							<h3 class="d-inline"> Phone No : </h3> {{$businessTaxShop->phone}}
						</div>


					</div>

				</div>
			</div>
		</div>



		<div class="col">

			<div class="card shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Payment List</h3>
						</div>
					</div>
				</div>

				<div class="table-responsive py-4">
					<table id="example" class="table  px-5">
						<thead class="thead-light">
							<tr>
								<th>{{__('menu.Assesment No.')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th>{{__('menu.Annual Amount')}}</th>
								<th>{{__('menu.Arrears')}}</th>

							</tr>
						</thead>
						<thead id="search_inputs">
							<tr>
								<th><input type="text" class="form-control form-control-sm" id="searchAssesmentNo"
										placeholder="{{__('menu.Search Assesment No.')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchPaymentDate"
										placeholder="{{__('menu.Search Payment date')}}" /></th>

							</tr>
						</thead>
						<tbody>

							{{-- @foreach ($businessTaxPayments as $businessTaxPayment)
							<tr>
							<td>{{$businessTaxPayment->assesmentNo}}</th>
							<td>{{$businessTaxPayment->payment_Date}}</td>
							<td>{{$businessTaxPayment->amount}}</td>
							<td>{{$businessTaxPayment->arrears}}</td>


							</tr>
							@endforeach --}}


						</tbody>
						<thead class="thead-light">
							<tr>
								<th>{{__('menu.Assesment No.')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th>{{__('menu.Annual Amount')}}</th>
								<th>{{__('menu.Arrears')}}</th>
							</tr>
						</thead>

					</table>
				</div>
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
        
        //individulat column search
        $('#searchAssesmentNo').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            $('#searchPaymentDate').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });
      } );

</script>
@endpush