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

<div class="col-11 m-3 card shadow ">
    <div class="card-header bg-transparent">
        <h3 class="mb-0"><span class="text-uppercase">Update Land Tax</span></h3>
    </div>

    <div class="card-body bg-secondary ">


        <form method="POST" action="{{route('update-land-percentage')}}" id="update-land-details">
            @csrf
            @method('put')
            <div class="row">
                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Land Tax percentage </label>
                    <div class="col-md-7">

                        <input type="text" class="form-control  d-inline @error('vatPercentage') is-invalid @enderror"
                            id="vatPercentage" name="vatPercentage"
                            value="{{old('vatPercentage',number_format($land->vat_percentage,2))}}"
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
                        Land Tax Due date </label>
                    <div class="col-md-7">

                        <input type="date" class="form-control  d-inline @error('dueDate') is-invalid @enderror"
                            id="dueDate" name="dueDate" value="{{old('dueDate',$land->due_date)}}"
                            placeholder="Enter The Due date month/date/0004">
                        @error('dueDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <input type="submit" id="register" value="Update" class="btn btn-primary col-md-2 mx-3 mt-3 mt-md-0"
                        onclick="javascript:event.preventDefault()" data-target="#confirm-update-land"
                        data-toggle="modal">
                </div>



            </div>


            {{-- Confirmation modal for update business details--}}
            <div class=" modal fade" id="confirm-update-land" tabindex="-1" role="dialog"
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

                            <p>Are you sure you wish to update Land Tax details ?<br></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" id="redirect" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('update-land-details').submit();">{{__('menu.Yes')}}</button>
                        </div>

                    </div>
                </div>
            </div>
            {{-- End of confirmation modal --}}

        </form>

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
          '<"px-0 text-center d-flex ">l'+
          't'+
          '<"d-flex justify-content-center p-4"p>'+
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