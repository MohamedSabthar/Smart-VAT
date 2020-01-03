@extends('layouts.app')

@section('title','Industrial Payment')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-3 col-lg-6" onclick="javascript:window.open(`{{route('industrial')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						Industrial payers
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

<div class="col-xl-3 col-lg-6" {{-- onclick="javascript:window.open(`{{route('industrial-generate-report')}}`,'_self')
	--}} style="cursor:pointer">
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

<div class="col-xl-3 col-lg-6" onclick="javascript:window.open(`{{route('get-industrial-quick-payments')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">Quick payments</h5>
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
		@elseif(session('error'))
		<div class="alert alert-danger alert-dismissible fade show col-8 mb-5" role="alert">
			<span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
			<span class="alert-inner--text mx-2"><strong class="mx-1">Error!</strong>{{session('error')}}</span>
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

<div class="row">
	<div class="col">
		<div class="card bg-secondary shadow">
			<div class="card-header bg-white border-0">
				<h3 class="mb-0"><span class="text-uppercase">Accept payments</span></h3>
			</div>

			<div class="card-body">

				<form>
					@csrf
					<div class="form-group row pt-3">
						<label for="example-week-input" class="col-md-2 col-form-label form-control-label">NIC</label>
						<div class="col-md-10">
							<input class="form-control @error('nic') is-invalid @enderror" type="text"
								value="{{old('nic')}}" id="nic" name="nic" placeholder="Enter vat payer's NIC">
							<span id="error_nic" class="invalid-feedback" role="alert">
								@error('nic')
								<strong>{{ $message }}</strong>
								@enderror
							</span>
						</div>
					</div>
				</form>
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
									onclick="javascript:document.getElementById('industrial-quick-payments').submit();">{{__('menu.Confirm')}}</button>
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
			</div>

		</div>
	</div>
</div>
@endsection

@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>

<script>
	$(document).ready(function(){

		var _token = $('meta[name="csrf-token"]').attr('content');

		$('#nic').keyup(function(e){
            if (e.keyCode != 16 && e.keyCode != 32){
							$('#shop-details tbody').html('');
        
			var nic = $('#nic').val();

            $('#payer-details').html('')
            $('#shop-details').html('')
                			
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token,
                }
            });
				
            $.ajax({
                url:"{{ route('check-industrial-payments') }}", 
                method:"POST",
                data: {'nic':nic},
                success:function(result){
                    console.log(result);
                    if(result.payerDetails==null ){
                        $('#nic').addClass('is-invalid');
                        nic!='' ? $('#error_nic').html('<strong>NIC not mached</strong>') 
                                : $('#error_nic').html('<strong>Please enter the NIC</strong>');
                        $('#payer-details').html('');
                    }
                    else{
                        $('#nic').removeClass('is-invalid');
                        $('#error_nic').html('');
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
					<div class='pt-3'>
					<h3 class='d-inline'>Name :</h3> 
					${result.payerDetails.full_name} 
					</div>
					<div class='pt-1'><h3 class='d-inline'>Address :</h3> ${result.payerDetails.address} </div>
					<div class='pt-1'><h3 class='d-inline'>Phone No :</h3> ${result.payerDetails.phone} </div>
					<div class='pt-1'><h3 class='d-inline'>E-mail :</h3> ${result.payerDetails.email} </div>
			</div>
		</div>`);

                        var i = 0
                        $('#shop-details').append(
                            `<div class="table-responsive">
                                <div class="card px-3">
                                    <form method='POST' action="{{route('industrial-quick-payments')}}" id="industrial-quick-payments">
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
						data-target="#confirm-quick-payments">{{__('menu.Add')}}</button>
						</form>
																		
																	</div>
																</div>`
																);
												var nullToken = 0;
                        result.payerDetails.industrial.forEach(element => {
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
    });
</script>
@endpush