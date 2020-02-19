@extends('layouts.app')

@section('title','Vat Payer Profile')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
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
                    <a href="#" class="btn"></a>
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


        {{-- Start  from here --}}
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">
                            <span class="text-uppercase">{{$vatPayer->first_name}} '{{__('menu.s profile')}}</span>
                        </h3>
                        <hr class="mt-4 mb-0">
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Update VAT payer profile form --}}
                <form method="POST" id="vat-payer-details-form"
                    action="{{route('update-vat-payer',['id'=> $vatPayer->id])}}">
                    @csrf
                    {{-- @method('put') --}}
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
                            {{__('menu.Middle Name')}}</label>
                        <div class="col-md-10">
                            <input class="form-control @error('middle_name') is-invalid @enderror" type="text"
                                value="{{old('middle_name',$vatPayer->middle_name)}}" id="middle_name"
                                name="middle_name">
                            @error('middle_name')
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
                                value="{{old('doorNo',$vatPayer->door_no)}}" id="doorNo" name="doorNo">
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
                            data-target="#confirm-update-vat-payer">{{__('menu.Update')}}</button>
                    </div>

                    {{-- Confirmation modal --}}
                    <div class="modal fade" id="confirm-update-vat-payer" tabindex="-1" role="dialog"
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
                                        onclick="javascript:document.getElementById('vat-payer-details-form').submit();">Confirm</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- end of Confirmation modal --}}

                </form>
                {{-- end of Update VAT payer profile form  --}}
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

        
            
    } );
</script>
@endpush