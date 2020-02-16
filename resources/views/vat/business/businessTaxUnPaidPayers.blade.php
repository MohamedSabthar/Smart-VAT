@extends('layouts.app')

@section('title','Business Report Generation')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">


@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection


@section('pageContent')

<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-header bg-transparent">
                <h3 class="mb-0 text-center"><span class="text-uppercase">Businness Tax Unpaid payer for year
                        {{$year}}</span></h3>
            </div>
            @if($payersDue->all()!=null)
            <a href="{{route('business-un-paid-payers-pdf')}}" class="btn btn-danger">Convert to PDF</a>

            <table id="business_tax_report" class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{__('menu.VAT Payers NIC')}}</th>
                        <th class="text-center">{{ __('menu.VAT Payer Name')}}</th>
                        <th class="text-center">{{ __('menu.Shop')}}</th>
                        <th class="text-center">{{ __('menu.Due Payment')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($payersDue as $payerDue)
                    <tr>
                        <td class="text-center">{{ $payerDue->payer->nic }}</td>
                        <td class="text-center">{{ $payerDue->payer->full_name }}</td>
                        <td class="text-center">{{ $payerDue->shop_id."-".$payerDue->businessTaxShop->shop_name }}</td>
                        <td class="text-center">Rs. {{ number_format($payerDue->due_ammount, 2) }}</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            @else
            <div class="jumbotron bg-trnasparent text-center">No Un-paid VAT payers</div>
            @endif

        </div>
        <br>


    </div>
</div>




@endsection





@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>
@endpush