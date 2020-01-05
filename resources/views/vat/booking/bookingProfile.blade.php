@extends('layouts.app')

@section('title','Booking Profile')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')

<div class="col-xl-3 col-lg-6">
	<div class="card card-stats mb-4 mb-xl-0">
		{{-- <div id="#card" class="card-body" style="cursor:pointer" onclick="javascript:window.open('/','_self')"> --}}
		<div id="#card" class="card-body">
			<div class="row">
				<div class="col">
					<h5 cla ss="card-title text-uppercase text-muted mb-0">Traffic</h5>
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


<div class="col-xl-3 col-lg-6"
	onclick="javascript:window.open(`{{route('trash-booking',['id'=>$vatPayer->id])}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						<center>Restore Booking</center>
					</h3>

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

<div class="container-fluid d-flex align-items-center">
	{{-- Alert notifications --}}
	<div class="col mt-5">
		@if (session('status'))
		<div class="alert alert-success alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Success!</strong>{{session('status')}}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@if(url()->previous()==route('payer-registration',['requestFrom'=>'booking']))
		<div class="alert alert-primary alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2">
				Click here to add new booking
				<a href="#" class="btn btn-sm btn-success mx-4 add-buissness">{{__('menu.[+] Buissness')}}</a>

				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
		</div>
		@endif
		@elseif($errors->any())
		<div class="alert alert-danger alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2">
				<strong class="mx-1">{{__('menu.Error!')}}</strong>
				{{__('menu.Data you entered is/are incorrect')}}
				<a href="#" class="btn btn-sm btn-primary mx-3 update-info add-buissness">{{__('menu.view')}}</a>
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
			<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
				<div class="d-flex justify-content-between">
					<a href="#" class="btn btn-sm btn-success mr-4 add-buissness">{{__('menu.[+] Buissness')}}</a>
				</div>
			</div>
			<div class="card-body pt-0 pt-md-4">
				<div class="text-left pt-5">
					<h3 class="d-inline">{{__('menu.Name')}} : </h3> {{ucwords($vatPayer->full_name)}}
					<div class="pt-1">
						<h3 class="d-inline">{{__('menu.Address')}} : </h3> {{$vatPayer->address}}
					</div>

					<div class="pt-1">
						<h3 class="d-inline">{{__('menu.NIC')}} : </h3> {{$vatPayer->nic}}
					</div>

					<hr class="my-4">

					<div class=" mt-4">
						<h3 class="d-inline">{{__('menu.E-Mail')}} : </h3> {{$vatPayer->email}} <a href="#"></a>
					</div>
					<div class="pt-1">
						<h3 class="d-inline">{{__('menu.Phone No')}} : </h3> {{$vatPayer->phone}}
					</div>


				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-8 order-xl-1">
		<div class="card bg-secondary shadow mb-5 hide" id="shop-rent-registration">
			<div class="card-header bg-white border-0">
				<div class="row align-items-center">
					<div class="col-8">
						<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Add New Booking')}}</span></h3>
					</div>

				</div>
			</div>
			<div class="card-body">
				{{--Shop rent registration form --}}
				<form method="POST" action="{{route('booking-register',['id'=> $vatPayer->id])}}">
					@csrf
					<div class="form-group row pt-3">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Booking Place')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('bookingPlace') is-invalid  @enderror" type="text"
								value="{{old('bookingPlace')}}" id="bookingPlace" name="bookingPlace" autofocus>
							@error('bookingPlace')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Event')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('event') is-invalid  @enderror"
								type="text" value="{{old('event')}}" id="event"
								name="event">
							@error('event')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Booking Date')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('date') is-invalid  @enderror"
								type="text" value="{{old('date')}}" id="date"
								name="date">
							@error('date')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Key Money')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('keyMoney') is-invalid  @enderror"
								type="text" value="{{old('keyMoney')}}" id="keyMoney"
								name="keyMoney">
							@error('keyMoney')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
				   


					<div class="form-group row">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Time Duration')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('time') is-invalid  @enderror"
								type="text" value="{{old('time')}}" id="time"
								name="time">

							<span class="invalid-feedback" id="invalidtime" role="alert">
							</span>
							@error('time')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Additional Time')}}</label>
						<div class="col-md-10 ">
							<input class="form-control @error('addtTime') is-invalid  @enderror" type="text"
								value="{{old('addtTime')}}" id="addtTime" name="addtTime">
							@error('addtTime')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					
					<div class="form-group">
						<input class=" btn btn-primary float-right" value="{{__('menu.Submit')}}" type="submit">
					</div>


				</form>
				{{-- end of shop registration form --}}
			</div>
		</div>

		<div class="card shadow">
			<div class="card-header bg-white border-0">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="mb-0">
							<span class="text-uppercase">{{$vatPayer->first_name}}
								'{{__('menu.Payment History')}}</span>
						</h3>
						<hr class="mt-4 mb-0">
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					{{-- shops table --}}
					<table id="shop_rent_table" class="table">
						<thead class="thead-light">
							<tr>
								<th style="width:250px;">{{__('menu.Assesment No.')}}</th>
								<th style="width:300px;">{{__('menu.Shop Name')}}</th>
								<th>{{__('menu.Shop Phone')}}</th>
								<th></th>
							</tr>
						</thead>
						<thead id="search_inputs">
							<tr>
								<th><input type="text" class="form-control form-control-sm" id="searchaAssesmentNo"
										placeholder="{{__('menu.Search Assesment No.')}}" />
								</th>
								<th><input type="text" class="form-control form-control-sm" id="searchBuisness"
										placeholder="{{__('menu.Search Shop Name')}}" />
								</th>
								<th><input type="text" class="form-control form-control-sm" id="searchPhone"
										placeholder="{{__('menu.Search Phone')}}" />
								</th>


							</tr>
                        </thead>
                        <tbody>
							@foreach ($vatPayer->booking as $booking)
							<tr>
								<td class="text-center">{{$booking->id}}</td>
								<td>{{$booking->shop_name}}</td>
								<td>{{$booking->phone}}</td>
								<td class="text-right">
									<div class="dropdown">
										<a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
											data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
											<a class="dropdown-item"
												href="{{route('booking-payments',['shop_id'=>$booking->id])}}">
												{{__('menu.View Payments')}}</a>
											
											<form
												action="{{route('remove-booking',['shop_id'=>$booking->id])}}"
												method="POST">
												@csrf
												@method('delete')
												<input type="submit" value="{{__('menu.Remove Buisness')}}"
													class="dropdown-item">
											</form>
										</div>

									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					 
						<thead class="thead-light">
							<tr>
								<th>{{__('menu.Assesment No.')}}</th>
								<th>{{__('menu.Shop Name')}}</th>
								<th>{{__('menu.Shop Phone')}}</th>
								<th></th>
							</tr>
						</thead>
					</table>
					{{-- end of Business shops table --}}
				</div>
			</div>
		</div>
	</div>
</div>




@endsection

@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>
<script>
	$(document).ready(function() {


      



        var id = '#shop_rent_table';                      //data table id
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
        $('#searchBuisness').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
        });
        $('#searchPhone').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
        });
        //toggle transition for buisness registration form
        $("#shop-rent-registration").hide();
        $(".add-buissness").on('click',function(){
            $("#shop-rent-registration").slideToggle("slow");
        });
        $('#type').select2({
            placeholder: "Select industrial type here",
            allowClear: true,
        });
        $('#annualAssesmentAmount').blur(function(){
            var assessmentAmmount = $(this).val()
           if(!$.isNumeric(assessmentAmmount)){
            $(this).addClass('is-invalid')
            $('#invalidAnnualAssesmentAmount').removeClass('d-none')
            $('#invalidAnnualAssesmentAmount>strong').text("{{__('menu.Invalid Assesment Amount')}}")
            
           }else{
               $(this).removeClass('is-invalid')
               $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $('#type').select2({
                placeholder: "Select industrial type here",
            allowClear: true,
            ajax: {
                url: "{{route('get-industrial-types')}}",
                dataType: 'json',
                type:"POST",
                delay: 250,
                data: function (params) {
                        return {
                            assessmentAmmount : assessmentAmmount,
                            search: params.term,
                            
                        };
                },
                processResults: function (data) {
                    
                     return {
                         results:$.map(data.results, function (obj) {
                            return {id:obj.id,text:obj.description}
                    })
                    }
                     
                },
                cache: true
            },        
            });
           }
        })
            
    } );
</script>
@endpush