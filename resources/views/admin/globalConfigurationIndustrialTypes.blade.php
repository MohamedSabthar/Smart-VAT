@extends('layouts.app')

@section('title','Trash Payments')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
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

<div class="col-11 m-3 card shadow">
    <div class="card-header bg-transparent">
        <h3 class="mb-0"><span class="text-uppercase">Add new Industrial Type</span></h3>
    </div>

    <div class="card-body bg-secondary ">
        <form method="POST" action="{{route('add-industrial-type',['id'=>$assessmentRange->id])}}"
            id="add-industrial-type">
            @csrf

            <div class="row">
                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Type Description </label>
                    <div class="col-md-7">

                        <input type="text" class="form-control  d-inline @error('description') is-invalid @enderror"
                            id="description" name="description" value="{{old('description')}}"
                            placeholder="Enter industrial type description">
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Assessment Amount </label>
                    <div class="col-md-7">

                        <input type="number" step="0.01"
                            class="form-control  d-inline @error('amount') is-invalid @enderror" id="amount"
                            name="amount" value="{{old('amount')}}" placeholder="Enter The assessment amount">
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <input type="submit" value="Add" class="btn btn-primary col-md-2 mx-3 mt-3 mt-md-0"
                        onclick="javascript:event.preventDefault()" data-target="#confirm-add-industrial-type"
                        data-toggle="modal">
                </div>



            </div>


            {{-- Confirmation modal for update industrial details--}}
            <div class=" modal fade" id="confirm-add-industrial-type" tabindex="-1" role="dialog"
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

                            <p>Are you sure? Do you wish to Add this Industrial type?<br></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('add-industrial-type').submit();">{{__('menu.Yes')}}</button>
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
        <h3 class="mb-0"><span class="text-uppercase">Update Industrial Type</span></h3>
    </div>

    <div class="card-body bg-secondary ">
        <form method="POST" action="{{route('update-industrial-type')}}" id="update-industrial-type">
            @csrf
            @method('put')
            <input type="hidden" value="{{old('updateId')}}" id="update-id" name="updateId">

            <div class="row">
                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Type Description </label>
                    <div class="col-md-7">

                        <input type="text"
                            class="form-control  d-inline @error('updatedDescription') is-invalid @enderror"
                            id="update-description" name="updatedDescription" value="{{old('updatedDescription')}}"
                            placeholder="Enter industrial type description">
                        @error('updatedDescription')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12 ">
                    <label for="example-text-input" class="col-md-2 col-form-label form-control-label ">
                        Assessment Amount </label>
                    <div class="col-md-7">

                        <input type="number" step="0.01"
                            class="form-control  d-inline @error('updatedAmount') is-invalid @enderror"
                            id="update-amount" name="updatedAmount" value="{{old('updatedAmount')}}"
                            placeholder="Enter The assessment updatedAmount">
                        @error('updatedAmount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <input type="submit" value="Update" class="btn btn-primary col-md-2 mx-3 mt-3 mt-md-0"
                        onclick="javascript:event.preventDefault()" data-target="#confirm-update-industrial-type"
                        data-toggle="modal">
                </div>



            </div>


            {{-- Confirmation modal for update industrial details--}}
            <div class=" modal fade" id="confirm-update-industrial-type" tabindex="-1" role="dialog"
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

                            <p>Are you sure? Do you wish to update this Industrial type?<br></p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link"
                                onclick="javascript:location.reload()">Cancel</button>
                            <button type="button" class="btn  btn-primary ml-auto"
                                onclick="javascript:document.getElementById('update-industrial-type').submit();">{{__('menu.Yes')}}</button>
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
    <div class="col-xl-12 order-xl-1">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-item-center">
                    <div class="col">
                        <h3 class="mb-0">
                            <span class="text-uppercase">{{__('menu.Industrial Range Types')}}</span>
                        </h3>
                        <hr class="mt-4 mb-0">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="trash_payment" class="table">
                        <thead class="thead-light">
                            <tr>

                                <th>{{__('menu.Id')}}</th>
                                <th>{{__('menu.Type')}}</th>
                                <th>{{__('menu.Amount (LKR)')}}</th>


                                <th></th>
                            </tr>
                        </thead>
                        <thead id="search_inputs">
                            <tr>
                                <th><input type="text" class="form-control form-control-sm" id="searchId"
                                        placeholder="{{__('menu.Search Id')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchType"
                                        placeholder="{{__('menu.Search Type')}}" />
                                </th>
                                <th><input type="text" class="form-control form-control-sm" id="searchAmount"
                                        placeholder="{{__('menu.Search Amount')}}" />
                                </th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessmentRange->industrialRangeTypes as $type)
                            <tr>
                                <td>{{$type->id}}</td>
                                <td>{{$type->description}}</td>
                                <td>{{number_format($type->assessment_ammount,2)}}</td>

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

                                <th>{{__('menu.Id')}}</th>
                                <th>{{__('menu.Type')}}</th>
                                <th>{{__('menu.Amount (LKR)')}} </th>

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

        $('.update-btn').on('click',function(){
                var businessType = $(this).data('value')
                $('#update-id').val(businessType.id)
                $('#update-description').val(businessType.description)
                $('#update-amount').val(businessType.assessment_ammount)
                $('html, body').animate({
                scrollTop: $("#update-type-card").offset().top
                    }, 100)
                $('#update-type-card').slideDown("slow")
               
            });

      
            
        var id = '#trash_payment';                      //data table id
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
            $('#searchId').on( 'keyup', function () { 
            table
                .columns( 0 )
                .search( this.value )
                .draw();
            });

            $('#searchType').on( 'keyup', function () { 
            table
                .columns( 1 )
                .search( this.value )
                .draw();
            });
            $('#searchAmount').on( 'keyup', function () { 
            table
                .columns( 2 )
                .search( this.value )
                .draw();
            });

            $(document).mouseup(function(e) 
{
    container =   $('#update-type-card')

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.slideUp("slow");
    }
});
            
      } );

</script>
@endpush