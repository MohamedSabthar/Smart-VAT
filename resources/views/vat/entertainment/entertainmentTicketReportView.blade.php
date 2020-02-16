@extends('layouts.app')

@section('title','Entertainmet Report Generation')
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
                <h3 class="mb-0 text-center"><span class="text-uppercase">Entertainment Tax Report for Ticket payments
                        from
                        {{ $dates->startDate }} to {{ $dates->endDate }}</span></h3>
            </div>
            @if($records->all()!=null)
            <button onclick="javascript:document.getElementById('dates').submit();" class="btn btn-danger">Convert to
                PDF</button>
            <table id="entertainment_tax_report" class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{__('menu.VAT Payers NIC')}}</th>
                        <th class="text-center">{{ __('menu.VAT Payer Name')}}</th>
                        <th class="text-center">{{ __('menu.Payment')}}</th>
                        <th class="text-center">{{ __("menu.Payment Date")}}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($records as $record)
                    <tr>
                        <td class="text-center">{{ $record->vatPayer->nic }}</td>
                        <td>{{ $record->vatPayer->full_name }}</td>
                        <td>Rs. {{ number_format($record->payment, 2) }}</td>
                        <td class="text-center">{{ $record->created_at }}</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            @else
            <div class="jumbotron bg-trnasparent text-center">No Payments data</div>
            @endif




            <form method="POST" action="{{route('entertainment-ticket-tax-report-pdf')}}" class="d-none" id="dates">
                @csrf
                <input name="startDate" value="{{ $dates->startDate }}">
                <input name="endDate" value="{{ $dates->endDate }}">

            </form>
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