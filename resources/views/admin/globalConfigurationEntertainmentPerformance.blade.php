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



<div class="mt--6 container-fluid d-flex align-items-center">


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
    </div>
    {{-- end of Alert notifications --}}
</div>

<a href="{{route('global-conf-entertainment-update')}}" class="m-3 btn btn-secondary"> Go to Entertainment Ticket Tax
    configuration </a>

<div class="col-11 m-3 card shadow">
    <div class="card-header bg-transparent">
        <h3 class="mb-0"><span class="text-uppercase">Add Entertainment Performance Type</span></h3>
    </div>

    <div class="card-body bg-secondary ">
        <form method="POST" action="{{route('add-entertainment-performance-type')}}" id="add-entertainment-type">
            @csrf

            <div class="row">
                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Type Description </label>
                    <div class="col-md-7">

                        <input type="text" class="form-control  d-inline @error('description') is-invalid @enderror"
                            id="description" name="description" value="{{old('description')}}"
                            placeholder="Enter entertainment type description">
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Initial charge </label>
                    <div class="col-md-7">

                        <input type="number" step="0.01"
                            class="form-control  d-inline @error('amount') is-invalid @enderror" id="initial"
                            name="amount" value="{{old('amount')}}" placeholder="Enter The initial amount">
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>





                </div>


                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Additional charge </label>
                    <div class="col-md-7">

                        <input type="number" step="0.01"
                            class="form-control  d-inline @error('additionalAmmount') is-invalid @enderror"
                            id="additionalAmmount" name="additionalAmmount" value="{{old('additionalAmmount')}}"
                            placeholder="Enter The Additional Ammount per day">
                        @error('additionalAmmount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>




                    <input type="submit" value="Add" class="btn btn-primary col-md-2 mx-3 mt-3 mt-md-0"
                        onclick="javascript:event.preventDefault()" data-target="#confirm-add-entertainment-type"
                        data-toggle="modal">
                </div>



            </div>


            {{-- Confirmation modal for update entertainment details--}}
            <div class=" modal fade" id="confirm-add-entertainment-type" tabindex="-1" role="dialog"
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

                            <p>Are you sure? Do you wish to Add this entertainment type?<br></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('add-entertainment-type').submit();">{{__('menu.Yes')}}</button>
                        </div>

                    </div>
                </div>
            </div>
            {{-- End of confirmation modal --}}

        </form>

    </div>


</div>



<div class="col-11 m-3 card shadow" id="update-type-card">
    <div class="card-header bg-transparent">
        <h3 class="mb-0"><span class="text-uppercase">Update Entertainment performance Type</span></h3>
    </div>

    <div class="card-body bg-secondary ">
        <form method="POST" action="{{route('update-entertainment-performance-type')}}" id="update-entertainment-type">
            @csrf
            @method('put')
            <input type="hidden" value="{{old('updateId')}}" id="update-id" name="updateId">

            <div class="row">
                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Type Description </label>
                    <div class="col-md-7">

                        <input type="text"
                            class="form-control  d-inline @error('updateDescription') is-invalid @enderror"
                            id="update-description" name="updateDescription" value="{{old('updateDescription')}}"
                            placeholder="Enter entertainment type description">
                        @error('updateDescription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Initial charge </label>
                    <div class="col-md-7">

                        <input type="number" step="0.01"
                            class="form-control  d-inline @error('updateAmount') is-invalid @enderror"
                            id="update-initial" name="updateAmount" value="{{old('updateAmount')}}"
                            placeholder="Enter The initial Amount">
                        @error('updateAmount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>



                </div>


                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Additional charge </label>
                    <div class="col-md-7">

                        <input type="number" step="0.01"
                            class="form-control  d-inline @error('updateAdditionalAmount') is-invalid @enderror"
                            id="update-additional" name="updateAdditionalAmount"
                            value="{{old('updateAdditionalAmount')}}" placeholder="Enter The additonal Amount per day">
                        @error('updateAdditionalAmount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <input type="submit" value="Update" class="btn btn-primary col-md-2 mx-3 mt-3 mt-md-0"
                        onclick="javascript:event.preventDefault()" data-target="#confirm-update-entertainment-type"
                        data-toggle="modal">
                </div>


            </div>


            {{-- Confirmation modal for update entertainment details--}}
            <div class=" modal fade" id="confirm-update-entertainment-type" tabindex="-1" role="dialog"
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

                            <p>Are you sure? Do you wish to update this entertainment type?<br></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('update-entertainment-type').submit();">{{__('menu.Yes')}}</button>
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


<div class="mt--4 row ">
    <div class="col-xl-10 order-xl-1">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-item-center">
                    <div class="col">
                        <h3 class="mb-0">
                            <span class="text-uppercase">{{__('menu.Entertainment Performance Types')}}</span>
                        </h3>
                        <hr class="mt-4 mb-0">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="TicketTypesTable" class="table">
                        <thead class="thead-light">
                            <tr>


                                <th>{{__('menu.Type')}}</th>
                                <th>{{__('menu.Amount (LKR)')}}</th>
                                <th>{{__('menu.Additional ammount (LKR)')}}</th>


                                <th></th>
                            </tr>
                        </thead>
                        <thead id="search_inputs">
                            <tr>

                                <th><input type="text" class="form-control form-control-sm" id="searchType"
                                        placeholder="{{__('menu.Search Type')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAmount"
                                        placeholder="{{__('menu.Search Amount')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAdditionalAmount"
                                        placeholder="{{__('menu.Search Additinal amount')}}" />
                                </th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entertainmentTypes as $type)
                            <tr>

                                <td>{{$type->description}}</td>
                                <td>{{number_format($type->amount,2)}}</td>
                                <td>{{number_format($type->additional_amount,2)}}</td>

                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                            <button class="dropdown-item update-btn" data-value="{{$type}}">
                                                {{__('menu.Update')}}</button>
                                        </div>

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                        <thead class="thead-light">
                            <tr>

                                <th>{{__('menu.Type')}}</th>
                                <th>{{__('menu.Amount (LKR)')}}</th>
                                <th>{{__('menu.Additional ammount (LKR)')}}</th>


                                <th></th>
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

    @if(!$errors->any())
    $('#update-type-card').hide();
    @endif

    $('.update-btn').on('click', function() {
        var ticketType = $(this).data('value')
        $('#update-id').val(ticketType.id);
        $('#update-description').val(ticketType.description)
        $('#update-initial').val(ticketType.amount)
        $('#update-additional').val(ticketType.additional_amount)
        $('html, body').animate({
            scrollTop: $("#update-type-card").offset().top
        }, 100)
        $('#update-type-card').slideDown("slow")

    });



    var id = '#TicketTypesTable'; //data table id
    var table = $(id).DataTable({
        "pagingType": "full_numbers",
        "sDom": '<' +
            '<"row"' +
            '<"col-sm-12 col-md-6 px-md-5"l>' +
            '<"col-sm-12 col-md-6 px-md-5"f>' +
            '>' +
            '<"py-2"t>' +
            '<"row"' +
            '<"py-3 col-sm-12 col-md-6 px-md-5"i>' +
            '<"py-3 col-sm-12 col-md-6 px-md-5 px-sm-3"p>>' +
            '>'
    }); //table object

    $(id + '_length select').removeClass(
    'custom-select custom-select-sm'); //remove default classed from selector

    //individulat column search
    $('#searchType').on('keyup', function() {
        table
            .columns(0)
            .search(this.value)
            .draw();
    });

    $('#searchAmount').on('keyup', function() {
        table
            .columns(1)
            .search(this.value)
            .draw();
    });
    $('#searchAdditionalAmount').on('keyup', function() {
        table
            .columns(2)
            .search(this.value)
            .draw();
    });

    $(document).mouseup(function(e) {
        container = $('#update-type-card')

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.slideUp("slow");
        }
    });

});
</script>
@endpush