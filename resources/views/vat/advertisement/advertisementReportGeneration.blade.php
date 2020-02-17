@extends('layouts.app')

@section('title','Advertisement Report Generation')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">


@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection


@section('pageContent')

<div class="row">
	<div class="col">


		<div class="card shadow">
			<div class="card-header bg-transparent">
				<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Generate Advertisement Report')}}</span></h3>
			</div>


			<div class="card-body ">

				@if (session('status'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
					<span class="alert-inner--text"><strong>Success!</strong>{{session('status')}}</span>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif

				<form method="POST" action="{{route('advertisement-report-view')}}">
					@csrf
					<div class="form-group row">
						<label for="example-text-input" class="col-md-2 col-form-label form-control-label "
							id="startDate" name="startDate">{{__('menu.Start Date')}}</label>
						<div class="input-group input-group-alternative">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
							</div>
							<input name="startDate"
								class="form-control datepicker @error('startDate') is-invalid  @enderror"
								placeholder="Select date" type="date" value="06/20/2019">
							@error('startDate')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-md-2 col-form-label form-control-label " id="endDate"
							name="endDate">{{__('menu.End Date')}}</label>
						<div class="input-group input-group-alternative">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
							</div>
							<input name="endDate"
								class="form-control datepicker @error('endDate') is-invalid  @enderror"
								placeholder="Select date" type="date" value="06/20/2019">
							@error('endDate')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					<div class="form-group">
						{{-- <input class=" btn btn-primary float-right" type="submit">  --}}
						<button type="submit" class="btn btn-primary" name="TaxReport" value="TaxReport">{{__('menu.Tax Report')}}</button>
						
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
<script src="{{asset('js/select2.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endpush