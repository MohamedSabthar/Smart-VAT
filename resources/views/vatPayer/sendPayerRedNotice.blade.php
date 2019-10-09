@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('title','Email')

@section('sidebar')
@if (Auth::user()->role=='admin')
@include('admin.include.sidebar')
@else
@include('employee.include.sidebar')
@endif
@endsection

@section('header')
@endsection

@section('pagecontent')

<div class="row">
	<div class="col">

		<div class="card shadow">
			<div class="card-header bg-transparent">
				<h3 class="mb-0"><span class="text-uppercase">Register Payer</span></h3>
			</div>
			
			<div class="card-body ">

                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        {{-- <ul>
                            @foreach($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul> --}}
                    </div>
                @endif

                {{-- Form to send email --}}
                    <form method="POST" action="#">
                            @csrf
                            <div class="form-group row pt-3">
                                <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                                    {{__('menu.First Name')}}</label>
                                <div class="col-md-10 ">
                                    <input class="form-control @error('first_name') is-invalid  @enderror" type="text"
                                        value="{{old('first_name')}}" id="first_name" name="first_name">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input"
                                    class="col-md-2 col-form-label form-control-label">{{__('menu.Email')}}</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        value="{{old('email')}}" id="email" name="email">  
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input"
                                    class="col-md-2 col-form-label form-control-label">{{__('menu.Email')}}</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        value="{{old('email')}}" id="email" name="email">  
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                    <input class=" btn btn-primary float-right" name="send" value="Send">
                            </div>



                    </form>		

            </div>	
        </div>
    </div>
</div>