@extends('layouts.app')

@section('title','Trash Payments')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')

<div class="col-xl-4 col-lg-6" onclick="javascript:window.open(`{{route('entertainment')}}`,'_self')"
    style="cursor:pointer">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase text-center text-muted mb-0">
                    {{__('menu.Entertainment Tax Payers')}}
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
<div class="col-xl-4 col-lg-6"
	onclick="javascript:window.open(`{{route('entertainment-generate-ticket-report')}}`,'_self')"
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
	onclick="javascript:window.open(`{{route('entertainment-generate-performance-report')}}`,'_self')"
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
    <div class="col-xl-12 order-xl-1">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-item-center">
                    <div class="col">
                        <h3 class="mb-0">
                            <span class="text-uppercase">{{__('menu.Trash Payments')}}</span>
                        </h3>
                        <hr class="mt-4 mb-0">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="trash_ticket_payment" class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('menu.Receipt No.')}}</th>
                                <th>{{__('menu.Place Addr')}}</th>
                                <th>{{__('menu.Quoted Tickets')}}</th>
                                <th>{{__('menu.Ticket Price')}}</th>
                                <th>{{__('menu.Returned Tickets')}}</th>
                                <th>{{__('menu.Returned Payment')}}</th>
                                <th>{{__('menu.Final Payment')}}</th>
                                <th>{{__('menu.Payment Date')}}</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <thead id="search_inputs">
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" id="searchAssesmentNo"
                                        placeholder="{{__('menu.Search Assesment No.')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAddress"
                                        placeholder="{{__('menu.Search Address')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAddress"
                                        placeholder="{{__('menu.Quoted Tickets')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAddress"
                                        placeholder="{{__('menu.Ticket Price')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAddress"
                                        placeholder="{{__('menu.Returned Tickets')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchReturnedPayment"
                                        placeholder="{{__('menu.Search Returnded Payments')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchPayment"
                                        placeholder="{{__('menu.Search Payment')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchPaymentDate"
                                        placeholder="{{__('menu.Search Payment date')}}" /></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($entertainmentTicketPayment as $payments)
                            <tr>
                                <td>{{$payments->id}}</td>
                                <td class="text-center">{{$payments->place_address}}</th>

                                <td>{{ $payments->quoted_tickets}}</td>
                                <td>{{ $payments->ticket_price}}</td>
                                <td>{{ $payments->treturned_tickets==null ? 'N/A' : $payments->treturned_tickets}}</td>
                                <td>{{ number_format($payments->returned_payment,2)}}</th>
                                <td>{{ number_format($payments->payment,2)}}</td>

                                <td class="text-center">{{date("m-d-Y",strtotime($payments->created_at))}}</th>

                                <td>
                                    <a class="btn btn-outline-success btn-sm "
                                        href="{{route('restore-entertainment-payment',['id'=>$payments->id])}}">
                                        {{__('menu.Restore')}}</a>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


                                            <form id="remove-payment"
                                                action="{{route('entertainment-remove-ticket-payment-permanent',['id'=>$payments->id])}}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" value="{{__('menu.Remove Payment')}}"
                                                    class="dropdown-item">

                                            </form>

                                        </div>

                                    </div>
                                </td>


                            </tr>
                            @endforeach


                        </tbody>
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('menu.Receipt No.')}}</th>
                                <th>{{__('menu.Place Addr')}}</th>
                                <th>{{__('menu.Quoted Tickets')}}</th>
                                <th>{{__('menu.Ticket Price')}}</th>
                                <th>{{__('menu.Returned Tickets')}}</th>
                                <th>{{__('menu.Returned Payment')}}</th>
                                <th>{{__('menu.Final Payment')}}</th>
                                <th>{{__('menu.Payment Date')}}</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>

                    </table>

                </div>

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

        var id = '#trash_ticket_payment';                      //data table id
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
          //individulat column search
        $('#searchAssesmentNo').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            
            $('#searchAddress').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });

            $('#searchQuotedTickets').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
            });

            $('#searchTicketPrice').on( 'keyup', function () { 
            table
                .columns( 3 )
                .search( this.value )
                .draw();
            });
            $('#searchReturnTickets').on( 'keyup', function () { 
            table
                .columns( 4 )
                .search( this.value )
                .draw();
            });
            

           
            $('#searchReturnedPayment').on( 'keyup', function () { 
            table
                .columns( 5 )
                .search( this.value )
                .draw();
            });
            $('#searchPayment').on( 'keyup', function () { 
            table
                .columns( 6 )
                .search( this.value )
                .draw();
            });
            $('#searchPaymentDate').on( 'keyup', function () { 
            table
                .columns( 7 )
                .search( this.value )
                .draw();
            }); 
            
      } );

</script>
@endpush