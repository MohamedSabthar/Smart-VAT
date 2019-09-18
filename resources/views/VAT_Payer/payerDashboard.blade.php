@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">

@endpush

@section('title','Dashboard')

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



@endsection

@section('pageContent')
<div class="row">
    <div class="col">

        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">VAT Payer Listing</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a class="btn btn-icon btn-success text-white" href="{{route('register-vat-payer')}}">
                            <span><i class="fas fa-user-plus"></i></span>
                            <span class="btn-inner--text">Register</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive py-4">
                <table id="example" class="table  px-5">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.User ID')}}</th>
                            <th>{{__('menu.Employee Name')}}</th>
                            <th>{{__('menu.Username')}}</th>
                            <th>{{__('menu.Email')}}</th>
                            <th>{{__('menu.Registerd By')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchId"
                                    placeholder="{{__('menu.Search User ID')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchName"
                                    placeholder="{{__('menu.Search Name')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchUsername"
                                    placeholder="{{__('menu.Search Username')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchEmail"
                                    placeholder="{{__('menu.Search Email')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchAdmin"
                                    placeholder="{{__('menu.Search Admin')}}" /></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><a href="{{route('vat-payer-profile')}}">Herrod Chandler</a></td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>33</td>
                            <td>$162,700</td>
                        </tr>
                        <tr>
                            <td><a href="{{route('vat-payer-profile')}}">Herrod Chandler</a></td>
                            <td>Integration Specialist</td>
                            <td>New York</td>
                            <td>61</td>
                            <td>2012/12/02</td>
                            <td>$372,000</td>
                        </tr>
                        <tr>
                            <td><a href="{{route('vat-payer-profile')}}">Herrod Chandler</a></td>
                            <td>Sales Assistant</td>
                            <td>San Francisco</td>
                            <td>59</td>
                            <td>$137,500</td>
                        </tr>
                        <tr>
                            <td>Rhona Davidson</td>
                            <td>Integration Specialist</td>
                            <td>Tokyo</td>
                            <td>55</td>
                            <td>$327,900</td>
                        </tr>
                        <tr>
                            <td>Colleen Hurst</td>
                            <td>Javascript Developer</td>
                            <td>San Francisco</td>
                            <td>39</td>
                            <td>$205,500</td>
                        </tr>
                        <tr>
                            <td>Sonya Frost</td>
                            <td>Software Engineer</td>
                            <td>Edinburgh</td>
                            <td>23</td>
                            <td>$103,600</td>
                        </tr>
                        {{-- @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->id}}</th>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->userName}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->admin->name}}</td>

                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item"
                                        href="{{route('employee-profile',['id'=>$employee->id])}}">View profile</a>
                                </div>

                            </div>
                        </td>


                        </tr>
                        @endforeach --}}


                    </tbody>
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.User ID')}}</th>
                            <th>{{__('menu.Employee Name')}}</th>
                            <th>{{__('menu.Username')}}</th>
                            <th>{{__('menu.Email')}}</th>
                            <th>{{__('menu.Registerd By')}}</th>
                            <th></th>
                        </tr>
                    </thead>

                </table>
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
          "pagingType": "full_numbers"

        });            //table object

        $(id+'_filter').addClass('pr-5');         //adding padding to table elements
        $(id+'_info').addClass('pl-5');
        $(id+'_paginate').addClass('pr-5');
        $(id+'_length').addClass('pl-5')


        $(id+'_length select').removeClass('custom-select custom-select-sm'); //remove default classed from selector
        
        //individulat column search
        $('#searchName').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });
            $('#searchId').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            $('#searchUsername').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
            });
            $('#searchEmail').on( 'keyup', function () { 
            table
                .columns( 3 )
                .search( this.value )
                .draw();
            });
            $('#searchAdmin').on( 'keyup', function () { 
            table
                .columns( 4 )
                .search( this.value )
                .draw();
            });




      } );

</script>
@endpush