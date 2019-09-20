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
                            <td><a href="{{route('vat-payer-business-list')}}">Maintaining a place for the sale of Sweet meats</a></td>    
                        </tr>
                        <tr>
                            <td>02</td>
                            <td><a href="{{route('vat-payer-business-list')}}">Bulk Storage of Sweet meats, Biscuits, for wholesale distribution</a></td>   
                        </tr>
                        <tr>
                            <td>03</td>
                            <td><a href="{{route('vat-payer-business-list')}}">Sale of cooked /processed food</a></td>  
                        </tr>
                        <tr>
                            <td>04</td>
                            <td><a href="{{route('vat-payer-business-list')}}">Packing, storage or sale of Tea</a></td>            
                        </tr>
                        <tr>
                            <td>05</td>
                            <td><a href="{{route('vat-payer-business-list')}}">Storage and sale or distribution of milk powder or Biscuits</a></td>   
                        </tr>
                    </tbody>
                </table>
            </div>
                    <div class="card-header bg-transparent">
                        <h4 class="mb-0"><span class="text-uppercase">{{__('menu.Add new Business')}}</span></h4>
                        <div class="card-body">

				<form method="POST" action="{{route('register')}}">
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
						<label for="example-search-input"
							class="col-md-2 col-form-label form-control-label">{{__('menu.Business Name')}}</label>
						<div class="col-md-10">
							<input class="form-control @error('userName') is-invalid @enderror" type="text"
								value="{{old('userName')}}" id="userName" name="userName">
							@error('userName')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
                    </div>
                    <div class="form-group row">
						<label for="example-search-input"
							class="col-md-2 col-form-label form-control-label">{{__('menu.Business')}}</label>
						<div class="col-md-10">
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
						<label for="example-search-input"
							class="col-md-2 col-form-label form-control-label">{{__('menu.Business Address')}}</label>
						<div class="col-md-10">
							<input class="form-control @error('userName') is-invalid @enderror" type="text"
								value="{{old('userName')}}" id="userName" name="userName">
							@error('userName')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
                    </div>
					
					
					
					
					<div class="form-group">
						<input class=" btn btn-primary float-right" type="submit" value="submit">
					</div>

				</form>
			</div>
                  
                  
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
        $('#searchaAssesmentNo').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            

      } );

</script>
@endpush