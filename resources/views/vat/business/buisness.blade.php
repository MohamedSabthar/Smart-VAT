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
					<h5 class="card-title text-uppercase text-muted mb-0">Buisness Tax payers</h5>
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
<div class="row">
	<div class="col">

		<div class="card shadow">
			<div class="card-header bg-white border-0">
				<div class="row align-items-center">
					<div class="col-8">
						<h3 class="mb-0">Business Tax Payers</h3>
					</div>
					<div class="col-4 text-right">
						<button class="btn btn-icon btn-3 btn-success text-white" data-toggle="tooltip"
						 data-placement="right" title="Click here to register new payer to business VAT category" 
					onclick="javascript:window.open('{{route('register-vat-payer')}}','_self')">
							<span><i class="fas fa-user-plus"></i></span>
							<span class="btn-inner--text">Register</span>
						</button>
					</div>
				</div>
			</div>

			<div class="table-responsive py-4">
				<table id="example" class="table  px-5">
					<thead class="thead-light">
						<tr>
							<th>{{__('menu.User ID')}}</th>
							<th>{{__('menu.VAT Payer Name')}}</th>
							<th>{{__('menu.Address')}}</th>
							<th>{{__('menu.Email')}}</th>
							<th>{{__('menu.Registerd By')}}</th>
							<th></th>

						</tr>
					</thead>
					<thead id="search_inputs">
						<tr>
							<th><input type="text" class="form-control form-control-sm" id="searchId"
									placeholder="{{__('menu.Search User ID')}}" /></th>
							<th><input type="text" class="form-control form-control-sm" id="searchName"
									placeholder="{{__('menu.Search Name')}}" /></th>
							<th><input type="text" class="form-control form-control-sm" id="searchAddress"
									placeholder="{{__('menu.Search Address')}}" /></th>
							<th><input type="text" class="form-control form-control-sm" id="searchEmail"
									placeholder="{{__('menu.Search Email')}}" /></th>
							<th><input type="text" class="form-control form-control-sm" id="searchAdmin"
									placeholder="{{__('menu.Search Admin')}}" /></th>

						</tr>
					</thead>
					<tbody>

						@foreach ($payers as $payer)
						<tr>
							<td>{{$payer->nic}}</th>
							<td>{{$payer->full_name}}</td>
							<td>{{$payer->address}}</td>
							<td>{{$payer->email}}</td>
							<td>{{$payer->user->name}}</td>

							<td class="text-right">
								<div class="dropdown">
									<a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="{{route('vat-payer-profile')}}">View profile</a>
									</div>

								</div>
							</td>


						</tr>
						@endforeach


					</tbody>
					<thead class="thead-light">
						<tr>
							<th>{{__('menu.User ID')}}</th>
							<th>{{__('menu.VAT Payer Name')}}</th>
							<th>{{__('menu.Address')}}</th>
							<th>{{__('menu.Email')}}</th>
							<th>{{__('menu.Registerd By')}}</th>
							<th></th>
						</tr>
					</thead>

				</table>
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
        $('#searchName').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });
            $('#searchId').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            $('#searchAddress').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
            });
            $('#searchEmail').on( 'keyup', function () { 
            table
                .columns( 3 )
                .search( this.value )
                .draw();
            });
            $('#searchAdmin').on( 'keyup', function () { 
            table
                .columns( 4 )
                .search( this.value )
                .draw();
            });

      } );

</script>
@endpush