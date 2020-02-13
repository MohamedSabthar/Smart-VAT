{{-- Update profile card --}}
        <div class="card bg-secondary shadow mb-5 hide" id="Update-business-info">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0"><span class="text-uppercase">{{__('menu.Update Business')}}</span></h3>
                    </div>

                </div>
            </div>
            <div class="card-body">
                {{-- Update VAT payer profile form --}}
                <form method="POST" id="VATpayer-details-form"
                    action="{{route('update-vat-payer',['id'=> $vatPayer->id])}}">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Business Name')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('businessName') is-invalid  @enderror" type="text"
                                value="{{old('businessName',$vatPayer->businessTaxShop->shop_name)}}" id="businessName" name="businessName">
                            @error('businessName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-time-input" class="col-md-2 col-form-label form-control-label">
                            {{__('menu.Phone No')}}</label>
                        <div class="col-md-10">
                            <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                value="{{old('phone',$vatPayer->phone)}}" id="phone" name="phone">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Door No.')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('doorNo') is-invalid  @enderror" type="text"
                                value="{{old('doorNo',$vatPayer->door_no)}}" id="doorNo" name="doorNo">
                            @error('doorNo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.Street')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('street') is-invalid  @enderror" type="text"
                                value="{{old('street',$vatPayer->street)}}" id="street" name="street">
                            @error('street')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input"
                            class="col-md-2 col-form-label form-control-label ">{{__('menu.City')}}</label>
                        <div class="col-md-10 ">
                            <input class="form-control @error('city') is-invalid  @enderror" type="text"
                                value="{{old('city',$vatPayer->city)}}" id="city" name="city">
                            @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right" data-toggle="modal"
                            onclick="javascript:event.preventDefault()"
                            data-target="#confirm-update-VATpayer">{{__('menu.Update')}}</button>
                    </div>

                    {{-- Confirmation modal --}}
                    <div class="modal fade" id="confirm-update-VATpayer" tabindex="-1" role="dialog"
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
                                    <p>Are you sure you wish to Update the details of {{$vatPayer->full_name}} ?
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link"
                                        onclick="javascript:location.reload()">Cancel</button>
                                    <button type="button" class="btn  btn-primary ml-auto" data-dismiss="modal"
                                        onclick="javascript:document.getElementById('VATpayer-details-form').submit();">Confirm</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- end of Confirmation modal --}}

                </form>
                {{-- end of Update VAT payer profile form  --}}
            </div>
        </div>