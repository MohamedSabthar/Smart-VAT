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

			@if(session('taxPayment'))
			<div class="card shadow text-justify mb-3 p-4">
				<div class="card-body bg-white border-0">
					<h1 style="font-weight: 400;">{{__('menu.Tax payment : Rs.')}}
						{{number_format(session('taxPayment'),2)}}
					</h1>
					@if (session('retunTaxPayment'))
					<h1 style="font-weight: 400;">{{__('menu.Returned tax payment : Rs.')}}
						{{number_format(session('retunTaxPayment'),2)}}
					</h1>
					@endif
				</div>
			</div>
			@endif


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

			{{-- update security deposit payment card --}}
			<div class="card bg-secondary shadow mb-5 " id="update-payment-card">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Update payment')}}</span>
							</h3>
						</div>

					</div>
				</div>
				<div class="card-body">
					{{-- booking payment update form --}}
					<form method="POST"
						action="{{route('update-entertainment-ticket-payments',['id'=> $vatPayer->id])}}"
						id="ticket-update-payment-form">
						@csrf
						@method('put')

						<input type="text" value="{{old('paymentId')}}" id="paymentId" name="paymentId" hidden>

						
						<div class="form-group row">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Event Venue')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('updatePlaceAddress') is-invalid  @enderror"
									type="text" value="{{old('updatePlaceAddress')}}" id="updatePlaceAddress"
									name="updatePlaceAddress">
								@error('updatePlaceAddress')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Quoted Ticket')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('updateQuotedTickets') is-invalid  @enderror"
									type="number" value="{{old('updateQuotedTickets')}}" id="updateQuotedTickets"
									name="updateQuotedTickets">
								@error('updateQuotedTickets')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Returned Tickets')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('updateReturnedTickets') is-invalid  @enderror"
									type="number" value="{{old('updateReturnedTickets')}}" id="updateReturnedTickets"
									name="updateReturnedTickets">
								@error('updateReturnedTickets')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Ticket Price')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('updateTicketPrice') is-invalid  @enderror"
									type="number" step="0.01" value="{{old('updateTicketPrice')}}"
									id="updateTicketPrice" name="updateTicketPrice">
								@error('updateTicketPrice')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>


						<div class="form-group">
							{{-- <input class=" btn btn-primary float-right" value="{{__('menu.Add payment')}}"
							type="submit"> --}}
							<button class="btn btn-primary float-right" data-toggle="modal"
								onclick="javascript:event.preventDefault()"
								data-target="#confirm-update-ticket-payment">{{__('menu.Update payment')}}</button>

						</div>


					</form>
					{{-- end of Entertainment update payment form --}}

					{{-- Confirmation modal for update ticket payments--}}
					<div class=" modal fade" id="confirm-update-ticket-payment" tabindex="-1" role="dialog"
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

									<p>Confirmation needed to update ticket payment for <br>
										{{$vatPayer->full_name}}-{{$vatPayer->nic}} </p>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link"
										onclick="javascript:location.reload()">Cancel</button>
									<button type="button" id="redirect" class="btn  btn-primary ml-auto"
										onclick="javascript:document.getElementById('ticket-update-payment-form').submit();">{{__('menu.Confirm')}}</button>
								</div>

							</div>
						</div>
					</div>
					{{-- End of confirmation modal --}}

				</div>
			</div>
			{{-- end of update ticket payment card --}}


			{{-- Recevie ticket payment card --}}
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
					{{-- Booking payment form --}}
					<form method="POST" action="{{route('receive-entertainment-payments',['id'=> $vatPayer->id])}}"
						id="ticket-payment-form">
						@csrf
					<div class="form-group row">
						<label for="business-type"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Event Venue')}}</label>
						<div class="col-md-10">

							<select id="place" name="place" class="form-control @error('place') is-invalid  @enderror">
								<option value=""></option>
								{{-- only for testing need to implement Ajax searchBuisness --}}
								@foreach ($bookingTaxType as $place)
								<option value="{{$place->id}}" @if(old('place')==$place->id) selected
									@endif>{{$place->place_description}}
								</option>
								@endforeach
							</select>
							@error('place')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="business-type"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Event')}}</label>
						<div class="col-md-10">

							<select id="event" name="event" class="form-control @error('event') is-invalid  @enderror">
								<option value=""></option>
								{{-- only for testing need to implement Ajax searchBuisness --}}
								@foreach ($bookingTaxType as $event)
								<option value="{{$event->id}}" @if(old('event')==$event->id) selected
									@endif>{{$event->event_description}}
								</option>
								@endforeach
							</select>
							@error('event')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
						<div class="form-group">
							{{-- <input class=" btn btn-primary float-right" value="{{__('menu.Add payment')}}"
							
							type="submit"> --}}
							<button class="btn btn-primary float-right" data-toggle="modal"
								onclick="javascript:event.preventDefault()"
								data-target="#confirm-ticket-payment">{{__('menu.Add payment')}}</button>
						</div>
					</form>
					{{-- end of Entertainment payment form --}}

					{{-- Confirmation modal for adding ticket payments--}}
					<div class=" modal fade" id="confirm-ticket-payment" tabindex="-1" role="dialog"
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

									<p>Confirmation needed to add a ticket payment for <br>
										{{$vatPayer->full_name}}-{{$vatPayer->nic}} </p>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link"
										onclick="javascript:location.reload()">Cancel</button>
									<button type="button" id="redirect" class="btn  btn-primary ml-auto"
										onclick="javascript:document.getElementById('ticket-payment-form').submit();">{{__('menu.Confirm')}}</button>
								</div>

							</div>
						</div>
					</div>
					{{-- End of confirmation modal --}}

				</div>
			</div>
			{{-- end of Receive payment card --}}




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

            //toggle transition for history card
        $("#payment-history").hide();

				@if(!$errors->any())
				$("#update-payment-card").hide();
				@endif

        $(".veiw-history").on('click',function(){
						$("#update-payment-card").hide();
            $("#payment-history").slideToggle("slow");
        });

				$('.toggle-update').on('click',function(){
					$("#payment-history").hide();
					$("#update-payment-card").slideToggle("slow");
					// setting form values
					var payment = $(this).data('value');
					console.log(payment);
					$("#paymentId").val(payment.id);
					$("#updateTicketType").val(payment.type_id);
					$("#updatePlaceAddress").val(payment.place_address);
					$("#updateQuotedTickets").val(payment.quoted_tickets);
					$("#updateReturnedTickets").val(payment.returned_tickets);
					$("#updateTicketPrice").val(payment.ticket_price);


				});


      } );

</script>
@endpush