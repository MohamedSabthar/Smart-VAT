@extends('layouts.app')

@section('title','Booking Payment')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-3 col-lg-6" onclick="javascript:window.open(`{{route('booking')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-center text-muted mb-0">
						Booking Tax payers
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

<div class="col-xl-3 col-lg-6"
	onclick="javascript:window.open(`{{route('entertainment-generate-ticket-report')}}`,'_self')"
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

<div class="col-xl-3 col-lg-6"
	onclick="javascript:window.open(`{{route('entertainment-performance-tax',['id'=>app('request')->id])}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h4 class="card-title text-uppercase text-muted mb-0">
						Performance payments
					</h4>
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


<div class="col-xl-3 col-lg-6"
	onclick="javascript:window.open(`{{route('entertainment-ticket-trash-payment',['id'=>app('request')->id])}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						Restore Pyament
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
		@elseif($errors->any())
		<div class="alert alert-danger alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2">
				<strong class="mx-1">{{__('menu.Error!')}}</strong>
				{{__('menu.Data you entered is/are incorrect')}}
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
<div class="pt-5">
	<div class="row">

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
						<a href="#" class="btn btn-sm btn-success mr-4 veiw-history">{{__('menu.View history')}}</a>
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

			{{-- payment history card --}}
			<div class="card shadow mb-5" id="payment-history">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">{{__('menu.Payment History')}}</h3>
							<hr class="mt-4 mb-0">

						</div>
					</div>
				</div>

				<div class="table-responsive py-4">
					{{-- booking tax payments table --}}
					<table id="entertainment_payments_table" class="table  px-5">
						<thead class="thead-light">
							<tr>
								<th>{{__('menu.Receipt No.')}}</th>
								<th>{{__('menu.Place')}}</th>
								<th>{{__('menu.Booking Date')}}
								<th>{{__('menu.Returned Payment')}}</th>
								<th>{{__('menu.Final Payment')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th></th>

							</tr>
						</thead>
						<thead id="search_inputs">
							<tr>
								<th><input type="text" class="form-control form-control-sm" id="searchAssesmentNo"
										placeholder="{{__('menu.Search Assesment No.')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchPlace"
										placeholder="{{__('menu.Search Palce')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchBookingDate"
										placeholder="{{__('menu.Search Date')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchReturnedPayment"
										placeholder="{{__('menu.Search Returnded Payments')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchFinalPayment"
										placeholder="{{__('menu.Search Payment')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchPaymentDate"
										placeholder="{{__('menu.Search Payment date')}}" /></th>
								<th></th>
							</tr>
						</thead>
						<tbody>

						</tbody>
						<thead class="thead-light">
							<tr>
							<th>{{__('menu.Receipt No.')}}</th>
								<th>{{__('menu.Place')}}</th>
								<th>{{__('menu.Booking Date')}}
								<th>{{__('menu.Returned Payment')}}</th>
								<th>{{__('menu.Final Payment')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th></th>

							</tr>
						</thead>

					</table>
					{{-- end of booking TAX payments table --}}
				</div>
			</div>
			{{-- end of payment history card --}}

			{{-- Add new booking --}}
	  	<div class="card bg-secondary shadow mb-5 hide">	
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Add new booking payment')}}</span>
							</h3>
						</div>

				</div>
	   	</div>		
        <div class="card-body">
			<form method="POST" action="{{route('receive-entertainment-payments',['id'=> $vatPayer->id])}}"
						id="ticket-payment-form">
						@csrf
					<div class="form-group row">
						<label for="business-type"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Event Venue')}}</label>
						<div class="col-md-10">

							<select id="type" name="type" class="form-control @error('type') is-invalid  @enderror">
								<option value=""></option>
								{{-- only for testing need to implement Ajax searchBuisness --}}
								@foreach ($bookingTaxType as $type)
									<option value="{{$type->id}}" @if(old('type')==$type->id) selected
										@endif>{{$type->description}} 
									</option>
									@endforeach
							</select>
							@error('type')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>

					{{-- Confirmation modal for adding business for the registered VAT payer--}}
				<div class=" modal fade" id="confirm-quick-payments" tabindex="-1" role="dialog"
					aria-labelledby="modal-default" aria-hidden="true">
					<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
						<div class="modal-content">

							<div class="modal-header">
								<h1 class="modal-title" id="modal-title-default">Confirmation !</h1>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<div class="modal-body">

								<p>Confirmation needed to accept payments!</p>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link"
									onclick="javascript:location.reload()">Cancel</button>
								<button type="button" id="redirect" class="btn  btn-primary ml-auto"
									onclick="javascript:document.getElementById('booking-profile').submit();">{{__('menu.Confirm')}}</button>
							</div>

						</div>
					</div>
				</div>
				{{-- End of confirmation modal --}}

				
				<div class="row">
					<div class="col-xl-4 order-xl-2 mb-5 mb-xl-0 mt-md-5" id="payer-details"></div>
					{{-- dynamicaly adding payer details --}}
					<div class="col-lg-8 col-12 mt-md-5" id="shop-details"></div>
					{{-- dynamicaly adding payer details --}}
				</div>
					
			</form>
			</div>
	    </div>	
			{{--end of add new booking --}}

		</div>
	</div>
</div>



@endsection

@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function() {

        var id = '#entertainment_payments_table';                      //data table id
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
            
            $('#searchAddress').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });

            $('#searchQuotedTickets').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
            });

            $('#searchTicketPrice').on( 'keyup', function () { 
            table
                .columns( 3 )
                .search( this.value )
                .draw();
            });
            $('#searchReturnTickets').on( 'keyup', function () { 
            table
                .columns( 4 )
                .search( this.value )
                .draw();
            });
            

           
            $('#searchReturnedPayment').on( 'keyup', function () { 
            table
                .columns( 5 )
                .search( this.value )
                .draw();
            });
            $('#searchPayment').on( 'keyup', function () { 
            table
                .columns( 6 )
                .search( this.value )
                .draw();
            });
            $('#searchPaymentDate').on( 'keyup', function () { 
            table
                .columns( 7 )
                .search( this.value )
                .draw();
            }); 
        
        $('#type').select({
                placeholder: "Select booking type here",
                allowClear: true,
            ajax: {
                url: "{{route('get-booking-types')}}",
                dataType: 'json',
                type:"POST",
                delay: 250,
                data: function (params) {
                        return {
                            
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

			var _token = $('meta[name="csrf-token"]').attr('content');

		$('#type').keyup(function(e){
            if (e.keyCode != 16 && e.keyCode != 32){
							$('#shop-details tbody').html('');
        
			var nic = $('#type').val();

            $('#payer-details').html('')
            $('#shop-details').html('')
                			
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token,
                }
            });
				
            $.ajax({
                url:"{{ route('check-business-payments') }}", 
                method:"POST",
                data: {'type':type},
                success:function(result){
                    console.log(result);
                    if(result.payerDetails==null ){
                        $('#type').addClass('is-invalid');
                        type!='' ? $('#error_nic').html('<strong>NIC not mached</strong>') 
                                : $('#error_nic').html('<strong>Please enter the NIC</strong>');
                        $('#payer-details').html('');
						$('#shop-details').html('')
                    }
                    else{
                        $('#type').removeClass('is-invalid');
                        $('#error_nic').html('');
						$('#shop-details').html('')
                        // console.log(result.payerDetails)
												$('#payer-details').html(`
												
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
				<div class="pt-7">
					<div class='pt-3'><h3 class='d-inline'>Name :</h3> ${result.payerDetails.full_name} </div>
                            <div class='pt-1'><h3 class='d-inline'>Address :</h3> ${result.payerDetails.address} </div>
                            <div class='pt-1'><h3 class='d-inline'>Phone No :</h3> ${result.payerDetails.phone} </div>
                            <div class='pt-1'><h3 class='d-inline'>E-mail :</h3> ${result.payerDetails.email} </div>
                           
		</div>
	</div>
                            `);

                        var i = 0
                        $('#shop-details').append(
                            `<div class="table-responsive">
                                <div class="card px-3">
                                    <form method='POST' action="{{route('business-quick-payments')}}" id="business-quick-payments">
                                        @csrf
                                        <table class="my-3 table align-items-center  ">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Shop Name</th>
                                                    <th scope="col">Due Ammount</th>
                                                    <th scope="col">Status</th>  
                                                </tr>
                                            </thead>
																				<tbody class="list"></tbody>
																				</table>
																				<button class="btn btn-primary btn-lg btn-block mb-3 accept-btn"" data-toggle="modal"
						onclick="javascript:event.preventDefault()"
						data-target="#confirm-quick-payments">{{__('menu.Add')}}</button>								</form>
																		
																	</div>
																</div>`
																);
												var nullToken = 0;
                        result.payerDetails.buisness.forEach(element => {
                            // console.log(element)
                            // $('#shop-details').append(`${element.shop_name} ${result.duePayments[i]==null ? 'not paid' : 'paid' } </br>`)
														
														$('#shop-details tbody').append(`
                                <tr>
                                    <td scope="row"> ${element.shop_name} </td>
                                    <td> ${result.duePaymentValue[i].toLocaleString('en',{ minimumFractionDigits: 2 })} </td>
                                    <td class='d-flex px-3'> 
                                        <input  name=${element.id} type="checkbox" ${ result.duePayments[i]!=null ? 'checked disabled' :'' } 
                                        <label>${ result.duePayments[i]==null ? '' :'paid' }</label>
                                    </td>
																</tr>`);
																if(result.duePayments[i]==null) nullToken=1;
                            i++;
												});
												// console.log(nullToken)
												if(nullToken==0) $('.accept-btn').attr("disabled", true);
                    }
                }
		    });
            } 
        });

      } );

</script>
@endpush