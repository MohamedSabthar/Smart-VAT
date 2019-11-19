@extends('layouts.app')

@section('title','Business Payment')

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom-data-table.css')}}">
@endpush

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
                    <h5 class="card-title text-uppercase text-muted mb-0">Payment List</h5>
                    <span class=" font-weight-bold mb-0">924</span>
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

@endsection

@section('pageContent')

<div class="row">
    <div class="col">
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0"><span class="text-uppercase">Accept payments</span></h3>
            </div>

            <div class="card-body">

                <form method="POST" action="{{route('register')}}">
                    @csrf
                    <div class="form-group row pt-3">
                        <label for="example-week-input" class="col-md-2 col-form-label form-control-label">NIC</label>
                        <div class="col-md-10">
                            <input class="form-control @error('nic') is-invalid @enderror" type="text"
                                value="{{old('nic')}}" id="nic" name="nic" placeholder="Enter vat payer's NIC">

                            <span id="error_nic" class="invalid-feedback" role="alert">
                                @error('nic')
                                <strong>{{ $message }}</strong>
                                @enderror
                            </span>



                        </div>
                    </div>


                </form>

                <div id="payer-details"></div> {{-- dynamicaly adding payer details --}}
                <div id="shop-details">

                </div> {{-- dynamicaly adding payer details --}}

            </div>

        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function(){

		var _token = $('meta[name="csrf-token"]').attr('content');

		$('#nic').keyup(function(e){
            if (e.keyCode != 16){
        
			var nic = $('#nic').val();

            $('#payer-details').html('')
            $('#shop-details').html('')
                
			
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token,
                }
            });
				
            $.ajax({
            url:"{{ route('check-business-payments') }}", 
            method:"POST",
            data: {'nic':nic},
            success:function(result){
                console.log(result);
				
                if(result.payerDetails==null ){
                    $('#nic').addClass('is-invalid');

                    nic!='' ? $('#error_nic').html('<strong>NIC not mached</strong>') : $('#error_nic').html('<strong>Please enter the NIC</strong>');
            ;
                    $('#payer-details').html('')
              
                }
                else{
                    $('#nic').removeClass('is-invalid');
                    $('#error_nic').html('');
                    // console.log(result.payerDetails)
                    $('#payer-details')
                        .html(`
                        <div class='pt-3'><h3 class='d-inline'>Name :</h3> ${result.payerDetails.full_name} </div>
                        <div class='pt-1'><h3 class='d-inline'>Address :</h3> ${result.payerDetails.address} </div>
                        <div class='pt-1'><h3 class='d-inline'>Phone No :</h3> ${result.payerDetails.phone} </div>
                        <div class='pt-1'><h3 class='d-inline'>E-mail :</h3> ${result.payerDetails.email} </div>
                        `)
                        var i = 0
                        $('#shop-details').append(`<div class="table-responsive">
    <div>
            <form method='POST' action="{{route('test')}}">
            @csrf
    <table class="mt-3 table align-items-center">
        <thead class="thead-light">
            <tr>
                <th scope="col">
                    Shop Name
                </th>
                <th scope="col">
                    ammount
                </th>
                <th scope="col">
                    status
                </th>
                
            </tr>
        </thead>
       
        <tbody class="list">
        </tbody>
        <input type="submit" value="Pay" class="btn btn-primary">
        </form>`);
                        result.payerShops.forEach(element => {
                            // console.log(element)
                            // $('#shop-details').append(`${element.shop_name} ${result.duePayments[i]==null ? 'not paid' : 'paid' } </br>`)
                            $('#shop-details tbody').append(`<tr>
                               <td scope="row"> ${element.shop_name} </td>
                               <td> 890 </td>
                                 <td class='d-flex px-3'> 
									
                                                            <input  name=${element.id} type="checkbox" ${ result.duePayments[i]!=null ? 'checked disabled' :'' } >
									
								</label>
                                ${ result.duePayments[i]==null ? '' :'paid' } 
                                 </td>
                                </tr>`)
                            
                            i++

                        });
                    }
                }
		    });
     } });
	});
</script>
@endpush