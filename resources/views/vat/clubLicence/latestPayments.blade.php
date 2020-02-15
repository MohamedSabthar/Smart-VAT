@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">

@endpush

@section('title','Latestpayment')

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
                {{-- Business Tax Latest Payments table--}}
                <table id="club_licence_payments_table" class="table px--5">
                    <thead class="thead-light">
                        <tr>
                            <th>{{__('menu.Assesment No.')}}</th>
                            <th>{{__('menu.Owner Name')}}</th>
                            <th>{{__('menu.Payment(LRK)')}}</th>
                            <td>{{__('menu.Club Name')}}</td>
                            <th>{{__('menu.Date')}}</th>
                            @if (Auth::user()->role=='admin')
                            <th>{{__('menu.Payment received by')}}</th>
                            @endif
                            <th></th>
                        </tr>
                    </thead>
                            {{-- Column wise searching --}}
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchaAssesmentNo"
                                    placeholder="{{__('menu.Assesment No.')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchOwnerName"
                                    placeholder="{{__('menu.Owner Name')}}" /></th>
                            <th></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchShopName"
                                    placeholder="{{__('menu.Club Name')}}" /></th>
                            <th><input type="date" class="form-control form-control-sm" id="searchDate"
                                    placeholder="{{__('menu.Date')}}" /></th>
                        </tr>
                    </thead>
                         {{-- End of seaching --}}
                    <tbody>
                       
                        @foreach ($payments as $payment)
                        <tr>
                        <td>{{$payment->id}}</td>
                        <td>{{$payment->vatPayer->full_name}}</td>
                        <td>{{$payment->payment}}</td>
                        <td>{{$payment->licenceTaxClub->club_name}}</td>
                        <td>{{$payment->created_at->format('Y-m-d')}}</td>
                        @if (Auth::user()->role=='admin')
                        <td>{{$payment->user->name}}</td>
						@endif
                        </tr>
                        @endforeach
                    </tbody>
                    <thead class="thead-light">
                        <th>{{__('menu.Assesment No.')}}</th>
                        <th>{{__('menu.Owner Name')}}</th>
                        <th>{{__('menu.Payment(LRK)')}}</th>
                        <td>{{__('menu.Club Name')}}</td>
                        <th>{{__('menu.Date')}}</th>
                        @if (Auth::user()->role=='admin')
                        <th>{{__('menu.Payment received by')}}</th>
                        @endif

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

        var id = '#business_payments_table';                  //data table id
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
        
        //individulate column search
        $('#searchOwnerName').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
		});

		$('#searchaAssesmentNo').on( 'keyup', function () { 
		table
			.columns( 0 )
			.search( this.value )
			.draw();
		});

		$('#searchShopName').on( 'keyup', function () { 
		table
			.columns( 3 )
			.search( this.value )
			.draw();
		});

		$('#searchDate').on( 'keyup', function () { 
		table
			.columns( 4 )
			.search( this.value )
			.draw();
		});

	} );

</script>
@endpush