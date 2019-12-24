@extends('layouts.app')

@section('title','Business Profile')

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
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
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
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
            </p>
        </div>
    </div>
</div>

<div class="col-xl-3 col-lg-6" onclick="javascript:window.open(`{{route('latest')}}`,'_self')" style="cursor:pointer">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase text-muted mb-0">Latest Payments</h3>
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
    onclick="javascript:window.open(`{{route('trash-business',['id'=>$vatPayer->id])}}`,'_self')"
    style="cursor:pointer">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase text-muted mb-0">
                        <center>Restore Business</center>
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
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-sm btn-success mr-4 update-profile">{{__('menu.Update Details')}}</a>
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
        <div class="card bg-secondary shadow mb-5 hide" id="business-registration">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0"><span class="text-uppercase">{{__('menu.Add new Business')}}</span></h3>
                    </div>

                </div>
            </div>
            <div class="card-body">
                {{-- Buisness registration form --}}
                <form method="POST" action="{{route('business-register',['id'=> $vatPayer->id])}}">
                    @csrf
                    <div class="form-group row pt-3">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Assesment No.')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('assesmentNo') is-invalid  @enderror" type="text"
                                value="{{old('assesmentNo')}}" id="assesmentNo" name="assesmentNo" autofocus>
                            @error('assesmentNo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Annual Assesment Amount')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('annualAssesmentAmount') is-invalid  @enderror"
                                type="text" value="{{old('annualAssesmentAmount')}}" id="annualAssesmentAmount"
                                name="annualAssesmentAmount">

                            <span class="invalid-feedback" id="invalidAnnualAssesmentAmount" role="alert">
                                <strong>dfafjkladfj</strong>
                            </span>
                            @error('annualAssesmentAmount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Business Name')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('businessName') is-invalid  @enderror" type="text"
                                value="{{old('businessName')}}" id="businessName" name="businessName">
                            @error('businessName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="business-type"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Business type')}}</label>
                        <div class="col-md-10">

                            <select id="type" name="type" class="form-control @error('type') is-invalid  @enderror">
                                <option value=""></option>
                                {{-- only for testing need to implement Ajax searchBuisness --}}
                                @foreach ($businessTypes as $type)
                                <option value="{{$type->id}}">{{$type->description}}
                                    {{'('.$type->ranges->start_value .'-'. $type->ranges->end_value .')'}}
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
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Phone No')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('phoneno') is-invalid  @enderror" type="text"
                                value="{{old('phoneno')}}" id="phoneno" name="phoneno">
                            @error('phoneno')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Door No')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('doorNo') is-invalid  @enderror" type="text"
                                value="{{old('doorNo')}}" id="doorNo" name="doorNo">
                            @error('doorNo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Street')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('street') is-invalid  @enderror" type="text"
                                value="{{old('street')}}" id="street" name="street">
                            @error('street')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.City')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('city') is-invalid  @enderror" type="text"
                                value="{{old('city')}}" id="city" name="city">
                            @error('city')
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
                {{-- end of Buisness registration form --}}
            </div>
        </div>
        {{-- Update profile card --}}
        <div class="card bg-secondary shadow mb-5 hide" id="Update-VATpayer-Info">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0"><span class="text-uppercase">{{__('menu.Update Profile')}}</span></h3>
                        </div>
    
                    </div>
                </div>
                <div class="card-body">
                    {{-- Update VAT payer profile form --}}
                    <form method="POST" id="VATpayer-details-form"
                        action="{{route('update-vat-payer',['id'=> $vatPayer->id])}}">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                                {{__('menu.First Name')}}</label>
                            <div class="col-md-10 ">
                                <input class="form-control @error('first_name') is-invalid  @enderror" type="text"
                                    value="{{old('first_name',$vatPayer->first_name)}}" id="first_name" name="first_name">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-md-2 col-form-label form-control-label">
                                {{__('menu.Last Name')}}</label>
                            <div class="col-md-10">
                                <input class="form-control @error('last_name') is-invalid @enderror" type="text"
                                    value="{{old('last_name',$vatPayer->last_name)}}" id="last_name" name="last_name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-email-input"
                                class="col-md-2 col-form-label form-control-label">{{__('menu.Email')}}</label>
                            <div class="col-md-10">
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    value="{{old('email',$vatPayer->email)}}" id="email" name="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-md-2 col-form-label form-control-label">
                                {{__('menu.Phone No')}}</label>
                            <div class="col-md-10">
                                <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                    value="{{old('phone',$vatPayer->phone)}}" id="phone" name="phone">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row  pt-3">
                                <label for="example-week-input"
                                    class="col-md-2 col-form-label form-control-label">{{__('menu.NIC')}}</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('nic') is-invalid @enderror" type="text"
                                        value="{{old('nic',$vatPayer->nic)}}" id="nic" name="nic">
                                    <span id="error_nic" class="invalid-feedback" role="alert">
        
                                    </span>
                                    @error('nic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-md-2 col-form-label form-control-label ">{{__('menu.Door No.')}}</label>
                            <div class="col-md-10 ">
                                <input class="form-control @error('doorNo') is-invalid  @enderror" type="text"
                                    value="{{old('doorNo',$vatPayer->doorNo)}}" id="doorNo" name="doorNo">
                                @error('doorNo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-md-2 col-form-label form-control-label ">{{__('menu.Street')}}</label>
                            <div class="col-md-10 ">
                                <input class="form-control @error('street') is-invalid  @enderror" type="text"
                                    value="{{old('street',$vatPayer->street)}}" id="street" name="street">
                                @error('street')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-md-2 col-form-label form-control-label ">{{__('menu.City')}}</label>
                            <div class="col-md-10 ">
                                <input class="form-control @error('city') is-invalid  @enderror" type="text"
                                    value="{{old('city',$vatPayer->city)}}" id="city" name="city">
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-right" data-toggle="modal"
                                onclick="javascript:event.preventDefault()"
                                data-target="#confirm-update-VATpayer">{{__('menu.Update')}}</button>
                        </div>

                        {{-- Confirmation modal --}}
                        <div class="modal fade" id="confirm-update-VATpayer" tabindex="-1" role="dialog"
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
										<p>Are you sure you wish to Update the details of {{$vatPayer->full_name}} ?
										</p>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-link"
											onclick="javascript:location.reload()">Cancel</button>
										<button type="button" class="btn  btn-primary ml-auto" data-dismiss="modal"
											onclick="javascript:document.getElementById('VATpayer-details-form').submit();">Confirm</button>
									</div>

								</div>
							</div>
						</div>
                        {{-- end of Confirmation modal --}}
    
                    </form>
                    {{-- end of Update VAT payer profile form  --}}
                </div>
            </div>
            

        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">
                            <span class="text-uppercase">{{$vatPayer->first_name}} '{{__('menu.s businesses')}}</span>
                        </h3>
                        <hr class="mt-4 mb-0">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- Business shops table --}}
                    <table id="business_shops_table" class="table">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:250px;">{{__('menu.Assesment No.')}}</th>
                                <th style="width:300px;">{{__('menu.Business Name')}}</th>
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
                                        placeholder="{{__('menu.Search Business Name')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchPhone"
                                        placeholder="{{__('menu.Search Phone')}}" />
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vatPayer->buisness as $buisness)
                            <tr>
                                <td class="text-center">{{$buisness->id}}</td>
                                <td>{{$buisness->shop_name}}</td>
                                <td>{{$buisness->phone}}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{route('business-payments',['shop_id'=>$buisness->id])}}">
                                                {{__('menu.View Payments')}}</a>
                                            <a class="dropdown-item"
                                                href="{{route('remove-business',['shop_id'=>$buisness->id])}}">
                                                {{__('menu.Remove Buisness')}}</a>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('menu.Assesment No.')}}</th>
                                <th>{{__('menu.Business Name')}}</th>
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


        var id = '#business_shops_table';                      //data table id
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

        //toggle transition for update profile
        $("#Update-VATpayer-Info").hide();
        $(".update-profile").on('click',function(){
            $("#Update-VATpayer-Info").slideToggle("slow");
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