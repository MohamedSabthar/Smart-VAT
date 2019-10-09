@extends('layouts.app')

@section('title','Business Report Generation')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">

@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection


@section('pageContent')
<div class="row">
	<div class="col">

		<div class="card shadow">
			<div class="card-header bg-white border-0">
				<div class="row align-items-center">
					<div class="col-8">
						<h3 class="mb-0">Business Tax Report Generation</h3>
					</div>
					<div class="col-4 text-right">
						<a class="btn btn-icon btn-success text-white" href="{{route('register-vat-payer')}}">
							<span><i class="fas fa-user-plus"></i></span>
							<span class="btn-inner--text">Generate</span>
						</a>
					</div>
				</div>
			</div>

			<div class="table-responsive py-4">
				{{-- Business VAT payers table --}}
				<table id="business_payer_table" class="table  px-5">
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
										<a class="dropdown-item"
											href="{{route('business-profile',['id'=>$payer->id])}}">View profile</a>
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
				{{-- end of Business VAT payers table --}}
			</div>
		</div>
	</div>
</div>
@endsection
