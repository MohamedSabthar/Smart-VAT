@extends('layouts.app')

@section('title','Slaughtering Payment')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-3 col-lg-6" onclick="javascript:window.open(`{{route('slaughtering')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-center text-muted mb-0">
						{{__('menu.Slaughtering Tax Payers')}}
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
						<div class="pt-2 text-center">
							<a href="{{route('vat-payer-profile',['id'=>$vatPayer->id])}}"
								class="btn btn-sm btn-danger">{{__('menu.Update Details')}}</a>
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
					{{-- Slaughtering TAX payments table --}}
					<table id="slaughtering_payments_table" class="table  px-5">
						<thead class="thead-light">
							<tr>
								<th>{{__('menu.Payment')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th>{{__('menu.Animal Count')}}</th>
								<th>{{__('menu.Slaughtering Type')}}</th>
								
								<th></th>

							</tr>
						</thead>
						
						<tbody>

							@foreach ($vatPayer->slaughtering as $payments)
							<tr>
								<td>{{$payments->payment}}</td>
						
                                <td class="text-center">{{date("m-d-Y",strtotime($payments->created_at))}}</td>
								<td>{{$payments->animal_count}}</td>
								<td>{{$payments->slaughteringType->description}}</td>

								<td class="text-right">
									<div class="dropdown">
										<a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
											data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


											
											<a class="dropdown-item toggle-update" data-value="{{$payments}}">
												Update payment</a>
										</div>

									</div>
								</td>


							</tr>
							@endforeach


						</tbody>
						<thead class="thead-light">
							<tr>
								<th>{{__('menu.Payment')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th>{{__('menu.Animal Count')}}</th>
								<th>{{__('menu.Slaughtering Type')}}</th>

								<th></th>

							</tr>
						</thead>

					</table>
					{{-- end of entertainment TAX payments table --}}
				</div>
			</div>
			{{-- end of payment history card --}}

			{{-- update ticket payment card --}}
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
					{{-- Slaughtering payment update form --}}
					<form method="POST"
						action="{{route('update-slaughtering-payments',['id'=> $vatPayer->id])}}"
						id="slaughtering-update-form">
						@csrf
						@method('put')  {{-- for updates --}}

						<input type="text" value="{{old('paymentId')}}" id="paymentId" name="paymentId" hidden>

						<div class="form-group row">
							<label for="ticket-type"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Slaughtering type')}}</label>
							<div class="col-md-10">

								<select id="updateslaughteringType" name="updateslaughteringType"
									class="form-control @error('updateslaughteringType') is-invalid  @enderror">

									<option value="" disabled selected>Select a slaughtering type</option>

									@foreach ($slaughteringTypes as $type)
									<option value="{{$type->id}}" @if(old('updateslaughteringType')==$type->id) selected
										@endif>{{$type->description}} -
										{{$type->amount}}
									</option>
									@endforeach


								</select>
								@error('updateslaughteringType')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Animal Count')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('updateAnimalCount') is-invalid  @enderror"
									type="text" value="{{old('updateAnimalCount')}}" id="updateAnimalCount"
									name="updateAnimalCount">
								@error('updateAnimalCount')
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
								data-target="#confirm-update-slaughtering-payment">{{__('menu.Update payment')}}</button>

						</div>


					</form>
					{{-- end of Slughtering update form --}}

					{{-- Confirmation modal for update slughtering payments--}}
					<div class=" modal fade" id="confirm-update-slaughtering-payment" tabindex="-1" role="dialog"
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

									<p>Confirmation needed to update slaughtering payment for <br>
										{{$vatPayer->full_name}}-{{$vatPayer->nic}} </p>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link"
										onclick="javascript:location.reload()">Cancel</button>
									<button type="button" id="redirect" class="btn  btn-primary ml-auto"
										onclick="javascript:document.getElementById('slaughtering-update-form').submit();">{{__('menu.Confirm')}}</button>
								</div>

							</div>
						</div>
					</div>
					{{-- End of confirmation modal --}}

				</div>
			</div>
			{{-- end of update slaughtering payment card --}}


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
    

			{{-- Recevie slaughtering record card --}}
			 <div class="card bg-secondary shadow mb-5 hide">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Add new Slaughtering Record')}}</span>
							</h3>
						</div>

					</div>
				</div>
				<div class="card-body">
					{{-- slaughtering payment form --}}
					<form method="POST" action="{{route('receive-slaughtering-payments',['id'=> $vatPayer->id])}}"
						id="ticket-payment-form">
						@csrf
						<div class="form-group row">
							<label for="ticket-type"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Slaughtering type')}}</label>
							<div class="col-md-10">

								<select id="slaughteringType" name="slaughteringType"
									class="form-control @error('slaughteringType') is-invalid  @enderror">

									<option value="" disabled selected>Select a Slaughtering type</option>

									@foreach ($slaughteringTypes as $type)
									<option value="{{$type->id}}" @if(old('slaughteringType')==$type->id) selected
										@endif>{{$type->description}} -
										{{$type->amount}}
									</option>
									@endforeach


								</select>
								@error('slaughteringType')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input"
								class="col-md-2 col-form-label form-control-label ">{{__('menu.Animal Count')}}</label>
							<div class="col-md-10 ">
								<input class="form-control @error('animal_Count') is-invalid  @enderror" type="text"
									value="{{old('animal_Count')}}" id="animal_Count" name="animal_Count">
								@error('animal_Count')
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
								data-target="#confirm-slaughtering-payment">{{__('menu.Add')}}</button>

						</div>


					</form>
					{{-- end of Slaughtering payment form --}}

					{{-- Confirmation modal for adding sloughtering payments--}}
					<div class=" modal fade" id="confirm-slaughtering-payment" tabindex="-1" role="dialog"
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

									<p>Confirmation needed to add a slaughtering payment for <br>
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

        var id = '#slaughtering_payments_table';                      //data table id
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
					$("#updateslaughteringType").val(payment.type_id);
					$("#updateAnimalCount").val(payment.animal_count);
				


				});


      } );

</script>
@endpush