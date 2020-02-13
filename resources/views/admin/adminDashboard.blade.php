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
                        <a class="dropdown-item" href="{{route('business-generate-report')}}">Generate report</a>
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
                        <a class="dropdown-item" href="{{route('industrial-generate-report')}}">Generate report</a>

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

                        <a class="dropdown-item" href="{{route('entertainment-generate-ticket-report')}}">Ticket payment
                            report</a>
                        <a class="dropdown-item"
                            href="{{route('entertainment-generate-performance-report')}}">Performance payment
                            report</a>

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


{{-- shop rent quick access --}}
<div class="col-xl-3 col-md-6">
    <div class="card bg-gradient-secondary border-0 my-2">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase  mb-0 text-default">Shop Rent Tax</h3>
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
                            href="{{route('payer-registration',['requestFrom'=>'shop-rent'])}}">Register payer</a>
                        <a class="dropdown-item" href="{{route('get-shop-rent-quick-payments')}}">Quick payments</a>
                        <a class="dropdown-item" href="{{route('shop-rent-generate-report')}}">Generate report</a>

                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
                <a href="{{route('shoprent')}}" class="text-nowrap text-primary font-weight-600" target="_blank">New
                    Window</a>
            </p>
        </div>
    </div>
</div>
{{-- end of shop rent quick access --}}


{{-- Booking TAX quick access --}}
<div class="col-xl-3 col-md-6">
    <div class="card bg-gradient-secondary border-0 my-2">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase  mb-0 text-default">Booking Tax</h3>
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
                            href="{{route('payer-registration',['requestFrom'=>'booking'])}}">Register payer</a>
                        <a class="dropdown-item" href="{{route('industrial-generate-report')}}">Generate report</a>

                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
                <a href="{{route('booking')}}" class="text-nowrap text-primary font-weight-600" target="_blank">New
                    Window</a>
            </p>
        </div>
    </div>
</div>
{{-- end of Booking TAX quick access --}}


{{-- Booking TAX quick access --}}
<div class="col-xl-3 col-md-6">
    <div class="card bg-gradient-secondary border-0 my-2">
        <!-- Card body -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase  mb-0 text-default">Advertisement Tax</h3>
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
                            href="{{route('payer-registration',['requestFrom'=>'advertisement'])}}">Register payer</a>
                        <a class="dropdown-item" href="{{route('industrial-generate-report')}}">Generate report</a>

                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-sm">
                <a href="{{route('booking')}}" class="text-nowrap text-primary font-weight-600" target="_blank">New
                    Window</a>
            </p>
        </div>
    </div>
</div>
{{-- end of Booking TAX quick access --}}







@endsection

@section('pageContent')
{{-- <div class="row">
    <div class="col">

        <div class="card shadow">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Icons</h3>
            </div>


            <div class="card-body">

            </div>




        </div>
    </div>
</div> --}}
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
        
        $('#searchName').on( 'keyup', function () { //individulat column search
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });

      } );

</script>
@endpush