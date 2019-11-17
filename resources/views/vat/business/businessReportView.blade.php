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
                <h3 class="mb-0 text-center"><span class="text-uppercase">Businness Tax Report from {{ $dates->startDate }} to {{ $dates->endDate }}</span></h3>
            </div>

            <table id="business_tax_report" class="table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:250px;">{{__('menu.Payment')}}</th>
                        <th style="width:300px;">{{ __('menu.ShopID')}}</th>
                        <th style="width:300px;">{{ __('menu.Vat Payer ID')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($records as $records)
                    <tr>
                        <td class="text-center">{{$records->payment}}</td>
                        <td>{{$records->shop_id}}</td>
                        <td>{{$records->payer_id}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
               
            </table>

            

        </div>
    </div>
</div>




@endsection





@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>
@endpush