@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('title','Dashboard')

@section('sidebar')
@include('employee.include.sidebar')
@endsection

@section('header')
{{-- <div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
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
</div> --}}

@isset($authorizedVat['business'])
{{-- Buisness quick access --}}
<div class="col-xl-3 col-md-6">
    <div class="card bg-gradient-secondary border-0 my-2">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase  mb-0 text-default">Business Tax</h3>
                    <span class="h5 font-weight-bold mb-0 text-gray">Total VAT payers :
                        {{$vatPayerCount->business}}</span>

                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"
                            href="{{route('payer-registration',['requestFrom'=>'business'])}}">Register payer</a>
                        <a class="dropdown-item" href="{{route('get-business-quick-payments')}}">Quick payments</a>
                        <a class="dropdown-item" href="{{route('business')}}">Search payers</a>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
                <a href="{{route('business')}}" class="text-nowrap text-primary font-weight-600" target="_blank">New
                    Window</a>
            </p>
        </div>
    </div>
</div>
{{-- end of Business quick access --}}
@endisset


@isset($authorizedVat['industrial'])
{{-- Inudtrial quick access --}}
<div class="col-xl-3 col-md-6">
    <div class="card bg-gradient-secondary border-0 my-2">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase  mb-0 text-default">Industrial Tax</h3>
                    <span class="h5 font-weight-bold mb-0 text-gray">Total VAT payers :
                        {{$vatPayerCount->industrial}}</span>

                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"
                            href="{{route('payer-registration',['requestFrom'=>'industrial'])}}">Register payer</a>
                        <a class="dropdown-item" href="{{route('get-industrial-quick-payments')}}">Quick payments</a>
                        <a class="dropdown-item" href="{{route('industrial')}}">Search payers</a>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
                <a href="{{route('industrial')}}" class="text-nowrap text-primary font-weight-600" target="_blank">New
                    Window</a>
            </p>
        </div>
    </div>
</div>
{{-- end of Industrial quick access --}}
@endisset

@isset($authorizedVat['entertainment'])
{{-- Entertainment quick access --}}
<div class="col-xl-3 col-md-6">
    <div class="card bg-gradient-secondary border-0 my-2">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase  mb-0 text-default">Entertainment Tax</h3>
                    <span class="h5 font-weight-bold mb-0 text-gray">Total VAT payers :
                        {{$vatPayerCount->entertainment}}</span>

                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item"
                            href="{{route('payer-registration',['requestFrom'=>'entertainment'])}}">Register payer</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="{{route('entertainment')}}">Search payers</a>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
                <a href="{{route('entertainment')}}" class="text-nowrap text-primary font-weight-600"
                    target="_blank">New
                    Window</a>
            </p>
        </div>
    </div>
</div>
{{-- end of Entertainment quick access --}}
@endisset


@endsection

@section('pageContent')

@endsection

@push('script')
{{-- <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
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
        
        $('#searchName').on( 'keyup', function () { //individulat column search
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });

      } );

</script> --}}
@endpush