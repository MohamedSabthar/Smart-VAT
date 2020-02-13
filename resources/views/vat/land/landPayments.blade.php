@extends('layouts.app')

@section('title','Land Payment')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Payment List</h5>
                    <span class=" font-weight-bold mb-0">924</span>
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


<div class="col-xl-3 col-lg-6"
    onclick="javascript:window.open(`{{route('land-trash-payment',['id'=>$landTaxPremises->payer->id])}}`,'_self')"
    style="cursor:pointer">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3 class="card-title text-uppercase text-muted mb-0">
                        <center>Restore Pyament</center>
                    </h3>
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
<div class="pt-5">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{asset('assets/img/theme/business.jpg')}}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('land-profile',['id'=>$landTaxPremises->payer->id])}}"
                            class="btn btn-sm btn-default float-right">{{__('menu.view owner')}}</a>
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="test-left pt-5">
                        <h3 class="d-inline">{{__('menu.Premises Name')}} : </h3>
                        {{ucwords($landTaxPremises->land_name)}}
                        <div class="pt-1">
                            <h3 class="d-inline">{{__('menu.Address')}} : </h3> {{ucwords($landTaxPremises->address)}}
                        </div>

                        <div class="pt-1">
                            <h3 class="d-inline">{{__('menu.Assesment No.')}} : </h3>
                            {{$landTaxPremises->registration_no}}
                        </div>

                        <hr>

                        <div class="pt-1">
                            <h3 class="d-inline"> {{__('menu.Annual worth')}} : </h3>
                            {{number_format($landTaxPremises->worth,2)}}  
                        </div>
                        <hr>

                        <div class="pt-1">
                            <h3 class="d-inline">{{__('menu.Phone No')}} : </h3> {{$landTaxPremises->phone}}
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 order-xl-1">
            {{-- Payment Notice --}}
            @if (!$paid)
            <div class="card shadow text-center mb-3 p-4">
                <div class="card-body bg-white border-0">
                    <h1 style="font-weight: 400;">{{__('menu.Due Payment : Rs.')}} {{number_format($duePayment,2)}}</h1>
                    <button class="btn btn-success mx-auto my-1" data-toggle="modal"
                        onclick="javascript:event.preventDefault()"
                        data-target="#confirm-land-payment">{{__('menu.Accept Payment')}}</button>

                </div>
            </div>
            {{-- payment form --}}
            <form action="{{route('receive-land-payments',['land_id'=>$landTaxPremises->id])}}"
                id="accept-payment" method="POST" hidden>
                @csrf
                <input type="text" name="payment" value="{{$duePayment}}">
            </form>
            {{-- end of payment form --}}
            {{-- Confirmation modal for adding business for the registered VAT payer--}}
            <div class=" modal fade" id="confirm-land-payment" tabindex="-1" role="dialog"
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

                            <p>Confirmation needed to add payment for <br>
                                shop : {{$landTaxPremises->land_name}} </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" id="redirect" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('accept-payment').submit()">{{__('menu.Accept Payment')}}</button>
                        </div>

                    </div>
                </div>
            </div>
            {{-- End of confirmation modal --}}

            @else
            <div class="card shadow text-center mb-3 p-4">
                <div class="card-body bg-white border-0">
                    <h1 style="font-weight: 400;">{{__('menu.No Due payments')}}</h1>

                </div>
            </div>
            @endif
            {{-- end of Pyament Notice --}}


            <div class="card shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{__('menu.Payment History')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive py-4">
                    {{-- Industrial TAX payments table --}}
                    <table id="land_payments_table" class="table  px-5">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('menu.Receipt No.')}}</th>
                                <th>{{__('menu.Payment Date')}}</th>
                                <th>{{__('menu.Payment')}}</th>
                                <th></th>

                            </tr>
                        </thead>
                        <thead id="search_inputs">
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" id="searchAssesmentNo"
                                        placeholder="{{__('menu.Search Assesment No.')}}" /></th>
                                <th><input type="text" class="form-control form-control-sm" id="searchPaymentDate"
                                        placeholder="{{__('menu.Search Payment date')}}" /></th>
                                <th></th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($landTaxPremises->payments as $payments)
                            <tr>
                                <td>{{$payments->id}}</td>
                                <td class="text-center">{{date("m-d-Y",strtotime($payments->created_at))}}</th>
                                <td>{{ number_format($payments->payment,2)}}</td>


                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


                                            <form id="remove-payment"
                                                action="{{route('remove-land-payment',['id'=>$payments->id])}}"
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
                                <th>{{__('menu.Payment Date')}}</th>
                                <th>{{__('menu.Payment')}}</th>

                                <th></th>
                            </tr>
                        </thead>

                    </table>
                    {{-- end of Industrial TAX payments table --}}
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

        var id = '#land_payments_table';                      //data table id
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
        $('#searchAssesmentNo').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });
            $('#searchPaymentDate').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });
      } );

</script>
@endpush