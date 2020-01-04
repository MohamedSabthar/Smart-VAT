@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('title','Global configuration')

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')

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

            </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show col-8 mb-5" role="alert">
            <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-inner--text mx-2"><strong class="mx-1">Error!</strong>{{session('error')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
    {{-- end of Alert notifications --}}
</div>

<div class="col-11 m-3 card shadow">
    <div class="card-header bg-transparent">
        <h3 class="mb-0"><span class="text-uppercase">Update Business Tax</span></h3>
    </div>

    <div class="card-body bg-secondary ">


        <form method="POST" action="{{route('update-business-percentage')}}" id="update-business-details">
            @csrf
            @method('put')
            <div class="row">
                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Business Tax percentage </label>
                    <div class="col-md-7">

                        <input type="text" class="form-control  d-inline @error('vatPercentage') is-invalid @enderror"
                            id="vatPercentage" name="vatPercentage"
                            value="{{old('vatPercentage',number_format($business->vat_percentage,2))}}"
                            placeholder="Enter vat percentage">
                        @error('vatPercentage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Business Tax Due date </label>
                    <div class="col-md-7">

                        <input type="date" class="form-control  d-inline @error('dueDate') is-invalid @enderror"
                            id="dueDate" name="dueDate" value="{{old('dueDate',$business->due_date)}}"
                            placeholder="Enter The Due date month/date/0004">
                        @error('dueDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <input type="submit" id="register" value="Update" class="btn btn-primary col-md-2 mx-3 mt-3 mt-md-0"
                        onclick="javascript:event.preventDefault()" data-target="#confirm-update-business"
                        data-toggle="modal">
                </div>



            </div>


            {{-- Confirmation modal for update business details--}}
            <div class=" modal fade" id="confirm-update-business" tabindex="-1" role="dialog"
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

                            <p>Are you sure you wish to update Business Tax details ?<br></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" id="redirect" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('update-business-details').submit();">{{__('menu.Yes')}}</button>
                        </div>

                    </div>
                </div>
            </div>
            {{-- End of confirmation modal --}}

        </form>

    </div>


</div>


@endsection

@section('pageContent')

<div class="row">
    <div class="mb-4 col-lg-6 col-sm-12">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">{{__('menu.Assessment Ranges of Business Tax')}}</h3>
                <hr class="mt-4 mb-0">
            </div>
            <div class="table-responsive px-5" style="width:100%">
                {{-- Assessment ranges table --}}
                <table id="assessment_table" class="table">
                    <thead class="thead-light">
                        <tr>

                            <th>{{__('menu.Start Value (LKR)')}} </th>
                            <th>{{__('menu.End Value (LKR)')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>

                            <th><input type="text" class="form-control form-control-sm" id="searchStartValue"
                                    placeholder="{{__('menu.Search start value')}}" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchEndValue"
                                    placeholder="{{__('menu.Search end value')}}" /></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($business->assessmentRanges as $range)
                        <tr>

                            <td>{{  number_format( $range->start_value,2)}}</td>
                            <td>{{ $range->end_value!=null ? number_format($range->end_value,2) : 'Above'}}
                            </td>


                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item"
                                            href="{{route('view-business-range-types',['id'=>$range->id])}}">view
                                            types</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead class="thead-light">
                        <tr>

                            <th>{{__('menu.Start Value (LKR)')}} </th>
                            <th>{{__('menu.End Value (LKR)')}}</th>

                            <th></th>
                        </tr>
                    </thead>
                </table>
                {{-- end of Assessment ranges table --}}
            </div>
        </div>
    </div>
    <div class="mb-4 col-lg-6 col-sm-12">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">{{__('menu.Assessment Ranges of Business Tax')}}</h3>
                <hr class="mt-4 mb-0">
            </div>
            <div class="card-bdoy">


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

        
        var assessment_table = $('#assessment_table').DataTable({
          "pagingType": "full_numbers",
          "sDom": '<'+
          '<"px-0 text-center d-flex justify-content-center"l>'+
          't'+
          '<"d-flex justify-content-center pt-4"p>'+
          '>'
        });     
 
        $('#assessment_table_length select').removeClass('custom-select custom-select-sm'); //remove default classed from selector
       

        $('#searchStartValue').on( 'keyup', function () { 
        assessment_table
            .columns( 0 )
            .search( this.value )
            .draw();
        });

        $('#searchEndValue').on( 'keyup', function () { 
        assessment_table
            .columns( 1 )
            .search( this.value )
            .draw();
        });

    });
</script>
@endpush