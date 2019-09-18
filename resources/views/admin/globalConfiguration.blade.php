@extends('layouts.app')

@section('title','Industrial Tax')

@section('sidebar')
@includeWhen(Auth::user()->role=='admin','admin.include.sidebar')
@includeWhen(Auth::user()->role=='employee','employee.include.sidebar')
@endsection

@section('header')
<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Traffic</h5>
                    <span class="h2 font-weight-bold mb-0">350,897</span>
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                <span class="text-nowrap">Since last month</span>
            </p>
        </div>
    </div>
</div>

<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">New users</h5>
                    <span class="h2 font-weight-bold mb-0">2,356</span>
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                <span class="text-nowrap">Since last week</span>
            </p>
        </div>
    </div>
</div>

<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                    <span class="h2 font-weight-bold mb-0">924</span>
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                <span class="text-nowrap">Since yesterday</span>
            </p>
        </div>
    </div>
</div>

<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                    <span class="h2 font-weight-bold mb-0">49,65%</span>
                </div>
                <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-percent"></i>
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                <span class="text-nowrap">Since last month</span>
            </p>
        </div>
    </div>
</div>
@endsection

@section('pageContent')
<div class="row">
    <div class="mb-4 col-lg-6 col-sm-12">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">VAT & Fine %</h3>
                <hr class="mt-4 mb-0">
            </div>
            <div class="table-responsive">
                <table id="vat_table" class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>VAT Category</th>
                            <th>VAT % </th>
                            <th>Fine %</th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchVAT"
                                    placeholder="Search VAT category" /></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vats as $vat)
                        <tr>
                            <td class="text-center">{{$vat->name}}</td>
                            <td>{!! $vat->vat_percentage ? $vat->vat_percentage : 'N/A' !!}</td>
                            <td>{!! $vat->fine_percentage ? $vat->fine_percentage : 'N/A' !!}</td>



                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">View profile</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead class="thead-light">
                        <tr>
                            <th>VAT Category</th>
                            <th>VAT % </th>
                            <th>Fine %</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="mb-4 col-lg-6 col-sm-12">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">Assessment Ranges</h3>
                <hr class="mt-4 mb-0">
            </div>
            <div class="table-responsive" style="width:100%">
                <table id="assessment_table" class="table  ">
                    <thead class="thead-light">
                        <tr>
                            <th>VAT Category</th>
                            <th>Start Value </th>
                            <th>End Value</th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead id="search_inputs">
                        <tr>
                            <th><input type="text" class="form-control form-control-sm" id="searchAssessment"
                                    placeholder="Search VAT category" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchStartValue"
                                    placeholder="Search start value" /></th>
                            <th><input type="text" class="form-control form-control-sm" id="searchEndValue"
                                    placeholder="Search end value" /></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assessment_ranges as $assessment_range)
                        <tr>
                            <td class="text-center">{{$assessment_range->vat->name}}</td>
                            <td>{{$assessment_range->start_value}}</td>
                            <td>{{$assessment_range->end_value}}</td>


                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="#">View profile</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead class="thead-light">
                        <tr>
                            <th>VAT Category</th>
                            <th>Start Value </th>
                            <th>End Value</th>

                            <th></th>
                        </tr>
                    </thead>
                </table>
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

        var vat_table = $('#vat_table').DataTable({
          "pagingType": "full_numbers",
          "sDom": '<'+
          '<" px-0 text-center d-flex justify-content-center"l>'+
          't'+
          '<"d-flex justify-content-center pt-4"p>'+
          '>'
        });     
 
        $('#vat_table_length select').removeClass('custom-select custom-select-sm'); //remove default classed from selector
        
        //individulat column search
        $('#searchVAT').on( 'keyup', function () { 
            vat_table
                .columns( 0 )
                .search( this.value )
                .draw();


                assessment_table
                .columns( 0 )
                .search( this.value )
                .draw();
            });





        var assessment_table = $('#assessment_table').DataTable({
          "pagingType": "full_numbers",
          "sDom": '<'+
          '<"px-0 text-center d-flex justify-content-center"l>'+
          't'+
          '<"d-flex justify-content-center pt-4"p>'+
          '>'
        });     
 
        $('#assessment_table_length select').removeClass('custom-select custom-select-sm'); //remove default classed from selector
        
       
        
        //individulat column search
        $('#searchAssessment').on( 'keyup', function () { 
            assessment_table
                .columns( 0 )
                .search( this.value )
                .draw();
            });

            $('#searchStartValue').on( 'keyup', function () { 
            assessment_table
                .columns( 1 )
                .search( this.value )
                .draw();
            });

            $('#searchEndValue').on( 'keyup', function () { 
            assessment_table
                .columns( 2 )
                .search( this.value )
                .draw();
            });






      } );

</script>
@endpush