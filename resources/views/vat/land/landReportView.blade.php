@extends('layouts.app')

@section('title','Land Report Generation')
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
                <h3 class="mb-0 text-center"><span class="text-uppercase">Land Tax Report from {{ $dates->startDate }} to {{ $dates->endDate }}</span></h3>
            </div>
            <table id="business_tax_report" class="table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:250px;" class="text-center">{{__('menu.Payment')}}</th>
                        <th style="width:300px;"class="text-center">{{ __('menu.Premises ID')}}</th>
                        <th style="width:300px;"class="text-center">{{ __('menu.Address')}}</th>
                        <th style="width:300px;"class="text-center">{{ __('menu.VAT Payer ID')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($records as $records)
                    <tr>
                        <td class="text-center">{{$records->payment}}</td>
                        <td class="text-center">{{$records->land_id}}</td>
                        <td class="text-center">{{$records->landTax->address}}</td>
                        <td class="text-center">{{$records->payer_id}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
               
            </table>
        
            

            <form method="POST" action="{{route('land-tax-report-pdf')}}" class="d-none" id="dates">
                @csrf
                        <input name="startDate" value="{{ $dates->startDate }}">
                        <input  name ="endDate" value="{{ $dates->endDate }}">
            
            </form>
        </div>
        <br>
        <div class="col" align="right">
            <button onclick="javascript:document.getElementById('dates').submit();" class="btn btn-danger">Convert into PDF</button>
        </div>
    </div>
</div>




@endsection





@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>
@endpush