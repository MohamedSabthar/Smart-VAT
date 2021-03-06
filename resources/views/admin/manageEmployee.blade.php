@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('title','Dashboard')

@section('sidebar')
@include('admin.include.sidebar')
@endsection

@section('header')
<!--div class="col-xl-3 col-lg-6">
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
</div>-->

<div class="container-fluid d-flex align-items-center">
    {{-- Alert notifications --}}
    <div class="col">

        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show col-8 mb-5" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-inner--text mx-2"><strong class="mx-1">Success!</strong>{{session('status')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{-- alert only displayed; if the page redirected by registration request --}}
        @if (url()->previous()==route('register'))
        <div class="alert alert-info alert-dismissible fade show col-8 mb-5" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-inner--text mx-2"><strong class="mx-1">Need to Assign-vat categories!</strong><a
                    href="#assignVat" class="btn btn-sm btn-primary mx-3">Click me</a></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @elseif($errors->any())
        <div class="alert alert-danger alert-dismissible fade show col-8 mb-5" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-inner--text mx-2">
                <strong class="mx-1">Error!</strong>
                Data you entered is/are incorrect
                <a href="#" class="btn btn-sm btn-primary mx-3 update-info">view</a>
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
<div class="row px--9">
    <div class="col">

        <div class="card shadow ">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-6 card-header">
                        <h3 class="mb-0 d-inline pr-2">Employees</h3> <span>registered under Smart VAT </span>
                    </div>
                    <div class="col-6 text-right">
                        <button class="btn btn-sm btn-icon btn-3 btn-success text-white" data-toggle="tooltip"
                            data-placement="right" title="Click to registern an employee to the system"
                            onclick="javascript:window.open('{{route('register')}}','_self')">
                            <span><i class="fas fa-user-plus"></i></span>
                            <span class="btn-inner--text">Register</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                {{-- Employees table --}}
                <table id="employees_table" class="table">
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


                        @foreach ($employees as $employee)
                        <tr>
                            <td class="text-center">{{$employee->id}}</th>
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
                        @endforeach


                    </tbody>
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.User ID')}} </th>
                            <th>{{__('menu.Employee Name')}}</th>
                            <th>{{__('menu.Username')}}</th>
                            <th>{{__('menu.Email')}}</th>
                            <th>{{__('menu.Registerd By')}}</th>
                            <th></th>
                        </tr>
                    </thead>

                </table>
                {{-- end of Employees table --}}
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

        var id = '#employees_table';                      //data table id
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

      });
</script>
@endpush