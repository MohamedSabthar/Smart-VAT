@extends('layouts.app')

@section('title','Trash Shop Rent')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-4 col-lg-6" onclick="javascript:window.open(`{{route('shoprent')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">
						{{__('menu.Shop Rent payers')}}
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

<div class="col-xl-4 col-lg-6" onclick="javascript:window.open(`{{route('shop-rent-generate-report')}}`,'_self')"
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

<div class="col-xl-4 col-lg-6" onclick="javascript:window.open(`{{route('get-shop-rent-quick-payments')}}`,'_self')"
	style="cursor:pointer">
	<div class="card card-stats mb-4 mb-xl-0">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<h3 class="card-title text-uppercase text-muted mb-0">{{__('menu.Quick payments')}}</h5>
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
                            <span class="text-uppercase">{{__('menu.Trash Shop Rent')}}</span>
                        </h3>
                        <hr class="mt-4 mb-0">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="trash_industrial" class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>{{__('menu.Assesment No.')}}</th>
                                <th>{{__('menu.Shop Name')}}</th>
                                <th>{{__('menu.Phone')}}</th>
                                <th>{{__('menu.Action')}}</th>

                            </tr>
                        </thead>
                        <thead id="search_inputs">
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" id="searchId"
                                        placeholder="{{__('menu.Search Id')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAssesmentNo"
                                        placeholder="{{__('menu.Search Assesment No.')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchBuisness"
                                        placeholder="{{__('menu.Search Industrial Shop')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchPhone"
                                        placeholder="{{__('menu.Search Phone')}}" />
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shopRentTax as $shoprent)
                            <tr>
                                <td>{{$shoprent->id}}</td>
                                <td>{{$shoprent->registration_no}}</td>
                                <td>{{$shoprent->shop_name}}</td>
                                <td>{{$shoprent->phone}}</td>

                                <td>
                                    <a class="btn btn-outline-success btn-sm "
                                        href="{{route('restore-shop-rent',['id'=>$shoprent->id])}}">
                                        {{__('menu.Restore')}}</a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>{{__('menu.Assesment No.')}}</th>
                                <th>{{__('menu.Shop Name')}}</th>
                                <th>{{__('menu.Phone')}}</th>
                                <th>{{__('menu.Action')}}</th>

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

        var id = '#trash_industrial';                      //data table id
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
             $('#searchId').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            $('#searchAssesmentNo').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });
            $('#searchBuisness').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
            });
            $('#searchPhone').on( 'keyup', function () { 
            table
                .columns( 3 )
                .search( this.value )
                .draw();
            });
      } );

</script>
@endpush