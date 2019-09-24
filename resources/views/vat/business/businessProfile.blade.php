@extends('layouts.app')

@section('title','Dashboard')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush

@section('sidebar')
@include('admin.include.sidebar')
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
<div class="pt-5">
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
                        <a href="#" id="add-buissness" class="btn btn-sm btn-success mr-4">[+] Buissness</a>
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="text-left pt-5">
                        <h3 class="d-inline">Name : </h3> {{$vatPayer->full_name}}
                        <div class="pt-1">
                            <h3 class="d-inline">Address : </h3> {{$vatPayer->address}}
                        </div>

                        <div class="pt-1">
                            <h3 class="d-inline"> NIC : </h3> {{$vatPayer->nic}}
                        </div>

                        <hr class="my-4">

                        <div class=" mt-4">
                            <h3 class="d-inline"> E-Mail : </h3> {{$vatPayer->email}} <a href="#"></a>
                        </div>
                        <div class="pt-1">
                            <h3 class="d-inline"> Phone No : </h3> {{$vatPayer->phone}}
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
                    <form method="POST" action="{{route('register')}}">

                        @csrf
                        <div class="form-group row pt-3">
                            <label for="example-text-input"
                                class="col-md-2 col-form-label form-control-label ">{{__('menu.Assesment No.')}}</label>
                            <div class="col-md-10 ">
                                <input class="form-control @error('name') is-invalid  @enderror" type="text"
                                    value="{{old('name')}}" id="name" name="name" autofocus>
                                @error('name')
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
                            <label for="example-text-input"
                                class="col-md-2 col-form-label form-control-label ">{{__('menu.Business Name')}}</label>
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
                            <label for="business-type" class="col-md-2 col-form-label form-control-label ">{{__('menu.Business type')}}</label>
                            <div class="col-md-10">

                                <select id="type" class="form-control">

                                    {{-- only for testing need to implement Ajax searchBuisness --}}
                                    @foreach ($businessTypes as $type)
                                    <option value="{{$type->id}}">{{$type->description}}</option>
                                    @endforeach


                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-md-2 col-form-label form-control-label ">{{__('menu.Business Address')}}</label>
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
                        <div class="form-group">
                            <input class=" btn btn-primary float-right" value="Submit" type="submit">
                        </div>
                    </form>
                    <!-- <hr class="my-4 mt-7">		 -->
                </div>
            </div>
            <!-- business list -->

            <div class="card shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"><span class="text-uppercase">{{$vatPayer->first_name}} 's
                                    businesses</span>

                            </h3>
                            <hr class="mt-4 mb-0">
                        </div>

                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example" class="table">
                            <thead class="thead-light">
                                <tr>

                                    <th style="width:400px;">{{__('menu.Business Name')}}</th>
                                    <th> Shop Phone</th>
                                </tr>
                            </thead>
                            <thead id="search_inputs">
                                <tr>
                                    <th><input type="text" class="form-control form-control-sm" id="searchBuisness"
                                            placeholder="search buisness name" />
                                    </th>
                                    <th><input type="text" class="form-control form-control-sm" id="searchPhone"
                                            placeholder="search phone number" />
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vatPayer->buisness as $buisness)
                                <tr>

                                    <td>{{$buisness->shop_name}}</td>
                                    <td>{{$buisness->phone}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead class="thead-light">
                                <tr>

                                    <th>{{__('menu.Business Name')}}</th>
                                    <th>Shop Phone</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    </form>
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
        $('#searchBuisness').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            $('#searchPhone').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });


            //toggle transition for buisness registration form
            $("#business-registration").hide();
            $("#add-buissness").on('click',function(){
                $("#business-registration").slideToggle("slow");
            });


            $('#type').select2({
    placeholder: 'Select a buisness type'
});
            
      } );

      

</script>
@endpush