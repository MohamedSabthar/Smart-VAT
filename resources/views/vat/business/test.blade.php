@extends('layouts.app')

@section('title','Business Report Generation')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">

@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('pageContent')

<div class="input-daterange datepicker row align-items-center">
    <div class="col">
        <div class="form-group">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                </div>
                <input class="form-control" placeholder="Start date" type="text" value="06/18/2019">
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                </div>
                <input class="form-control" placeholder="End date" type="text" value="06/22/2019">
            </div>
        </div>
    </div>
</div>
		

 @endsection


 @push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>
<script src="{{asset('assets\js\plugins\bootstrap-datepicker\dist\js\bootstrap-datepicker.min.js')}}"></script>
@endpush
