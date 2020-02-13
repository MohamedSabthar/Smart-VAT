<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat_payer;
use App\Business_tax_shop;
use App\Business_type;
use Illuminate\Support\Arr;
use App\Http\Requests\UpdateVATpayerProfileRequest;

class PayerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }
    
    public function payer()
    {
        return view('vatPayer.payerDashboard');
    }

    public function register()
    {
        $businessTypes = Business_type::all();       //returning all business types
        return view('vatPayer.registerPayer', ['businessTypes'=>$businessTypes]);
    }

    public function profile()
    {
        return view('vatPayer.payerProfile');
    }

    public function businesslist()
    {
        return view('vatPayer.payerBusinessList');
    }
    public function businessPaymentList($id)
    {
        $vatPayer = Vat_payer::find($id);  // finding appropriate VAT payer according to the  id
        $businessTaxShop = Business_tax_shop::find($id);

        return view('vat.business.payerPaymentList', ['vatPayer'=>$vatPayer,'businessTaxShops'=>$businessTaxShop]);
    }

    public function updateVATpayerProfile($id, UpdateVATpayerProfileRequest $request)
    {
        $vatPayer = Vat_payer::findOrFail($id);

        //update new VAT Payer details
        $vatPayer->first_name = $request->first_name;
        $vatPayer->middle_name = $request->middle_name;
        $vatPayer->last_name = $request->last_name;
        $vatPayer->email = $request->email;
        $vatPayer->phone = $request->phone;
        $vatPayer->nic = $request->nic;
        $vatPayer->doorNo = $request->doorNo;
        $vatPayer->street = $request->street;
        $vatPayer->city = $request->city;
             
        $vatPayer->save();
        return redirect()->back()->with('status', 'VAT Payer details updated successful');
    }
}