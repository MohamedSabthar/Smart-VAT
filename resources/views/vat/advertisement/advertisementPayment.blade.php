@extends('layouts.app')

@section('title','Advertisement Payment')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-4 col-lg-6" onclick="javascript:window.open(`{{route('advertisement')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						{{__('menu.Advertisement Tax Payers')}}
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



<div class="col-xl-4 col-lg-6" onclick="javascript:window.open(`{{route('advertisement-generate-report')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">{{__('menu.Report Generation')}}</h3>
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
<div class="col-xl-4 col-lg-6"
    onclick="javascript:window.open(`{{route('advertisement-trash-payment',['payer_id'=>$vatPayer->id])}}`,'_self')"
    style="cursor:pointer">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase text-muted mb-0">
                        <center>{{__('menu.Restore Payment')}}</center>
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
        @if(url()->previous()==route('payer-registration',['requestFrom'=>'advertisement']))
        <div class="alert alert-primary alert-dismissible fade show col-8 mb-5" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-inner--text mx-2">
                Click here to add new business
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
<div class ="pt-5">
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
                    <a href="#" class="btn btn-sm btn-success mr-4 add-buissness">{{__('menu.[+] Advertisement')}}</a>
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
                                <th>{{__('menu.Advertisement type')}}</th>
								<th>{{__('menu.Final Payment')}}</th>
								<th>{{__('menu.Payment Date')}}</th>
								<th></th>

							</tr>
						</thead>
						<thead id="search_inputs">
							<tr>
								<th><input type="text" class="form-control form-control-sm" id="searchAssesmentNo"
										placeholder="{{__('menu.Search Assesment No.')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchFinalPayment"
										placeholder="{{__('menu.Search Payment')}}" /></th>
								<th><input type="text" class="form-control form-control-sm" id="searchPaymentDate"
										placeholder="{{__('menu.Search Payment date')}}" /></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
                            @foreach($vatPayer->advertisementTaxPayment as $payments)
                            <tr>
                                <td>{{$payments->id}}</td>
                                <td>{{$payments->description}}</td>
                                <td>{{ number_format($payments->final_payment,2)}}</td>
                                <td class="text-center">{{date("m-d-Y",strtotime($payments->created_at))}}</th>
                                <td class="text-right">
									<div class="dropdown">
										<a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
											data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
											<form
												action="{{route('remove-advertisement-payment',['id'=>$payments->id])}}"
												method="POST">
												@csrf
												@method('delete')
												<input type="submit" value="{{__('menu.Remove Payment')}}"
													class="dropdown-item">

											</form>
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
                                <th>{{__('menu.Receipt No.')}}</th>
                                <th>{{__('menu.Advertisement type')}}</th>
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

        <div class="card bg-secondary shadow mb-5 hide" id="business-registration">
            <div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0"><span class="text-uppercase">{{__('menu.Add new Advertisement payment')}}</span>
							</h3>
						</div>

				</div>
	   	    </div>	
            <div class="card-body">
                {{-- Advertisement tax registration form --}}
                <form method="POST" action="{{route('advertisement-register',['id'=> $vatPayer->id])}}"
                    id="business-shop-register">
					@csrf
					<div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Description')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('description') is-invalid  @enderror" type="text"
                                value="{{old('description')}}" id="description" name="description">
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
					</div>
					<div class="form-group row">
						<label for="business-type"
							class="col-md-2 col-form-label form-control-label ">{{__('menu.Advertisement type')}}</label>
						<div class="col-md-10">

							<select id="type" name="type" class="form-control @error('type') is-invalid  @enderror">
							<option value="" disabled selected>Select a Advertisement type</option>
								{{-- only for testing need to implement Ajax searchBuisness --}}
								@foreach ($advertisementTaxType as $type)
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
					<div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Square feet')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('squarefeet') is-invalid  @enderror" type="text"
                                value="{{old('squarefeet')}}" id="squarefeet" name="squarefeet">
                            @error('squarefeet')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Price per square foot')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('price') is-invalid  @enderror" type="text"
                                value="{{old('price')}}" id="price" name="price">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right" data-toggle="modal"
                            onclick="javascript:event.preventDefault()"
                            data-target="#confirm-register-business">{{__('menu.Add')}}</button>
                    </div>


                    {{-- Confirmation modal for adding business for the registered VAT payer--}}
                    <div class=" modal fade" id="confirm-register-business" tabindex="-1" role="dialog"
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

                                    <p>Confirmation needed to add a business for <br>
                                        {{$vatPayer->full_name}}-{{$vatPayer->nic}} </p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link"
                                        onclick="javascript:location.reload()">Cancel</button>
                                    <button type="button" id="redirect" class="btn  btn-primary ml-auto"
                                        onclick="javascript:document.getElementById('business-shop-register').submit();">{{__('menu.Confirm')}}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End of confirmation modal --}}

                </form>
                {{-- end of Industrial shop registration form --}}
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
        $("#business-registration").hide();
        $(".add-buissness").on('click',function(){
            $("#business-registration").slideToggle("slow");
        });
        $('#type').select2({
            placeholder: "Select business type here",
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
                placeholder: "Select business type here",
            allowClear: true,
            ajax: {
                url: "{{route('get-business-types')}}",
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
            // minimumInputLength: 1,
        
            });
            // $.ajax({
            //     url: "{{route('get-business-types')}}",
            //     type:"POST",
            //     data: { assessmentAmmount : assessmentAmmount },
            //     success:function(data){
            //                 // alert(data);
            //                 console.log(data);
            //                 $('ul#select2-type-results').empty()
            //     },error:function(){ 
            //                 alert("error!!!!");
            //             }
            // });
           }
        })
            
    } );
</script>
@endpush