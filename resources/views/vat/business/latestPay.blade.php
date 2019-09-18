@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">

@endpush

@section('title','Latestpayment')

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
<div class="row">
    <div class="col">

        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-6 card-header">
                        <h3 class="mb-0">{{__('menu.Latest Payment')}}</h3>
                    </div>
                    
                </div>
            </div>

            <div class="table-responsive">
                <table id="example" class="table  ">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.Assesment No.')}}</th>
                            <th>{{__('menu.Owner Name')}}</th>
                            <th>{{__('menu.Payment(LRK)')}}</th>
                            <th>{{__('menu.Date')}}</th>
                            <th>{{__('menu.Registerd By')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchaAssesmentNo."
                                    placeholder="{{__('menu.Assesment No.')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchOwnerName"
                                    placeholder="{{__('menu.Owner Name')}}" /></th>
                            
                        </tr>
                    </thead>
                    <thead class="thead-light">
                        <tr>
                            <th>01</th>
                            <th>perera</th>
                            <th>2000</th>
                            <th>9/18/2019</th>
                            <th>john</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection