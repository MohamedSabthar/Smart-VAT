<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat_payer;
use App\Business_type;
use App\Business_tax_shop;
use App\Http\Request\UpdateVATpayerProfileRequest;

class PayerController extends Controller
{
    public function payer()
    {
        return view('vatPayer.payerDashboard');
    }

    public function register()
    {
        $businessTypes = Business_type::all();
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
        $vatPayer = Vat_payer::find($id);
   
   
        $businessTaxShop = Business_tax_shop::find($id);
        return view('vat.business.payerPaymentList',['vatPayer'=>$vatPayer,'businessTaxShops'=>$businessTaxShop]);
    }

    public function updateVATpayerProfile($id, UpdateVATpayerProfileRequest $request)
    {
        $vatPayer = Vat_payer::findOrFail($id);

        //update new VAT Payer details
        $vatPayer->first_name = $request->first_name;
        $vatPayer->middle_name = $request->middle_name;
        $vatPayer->last_name = $request->last_name;

        $vatPayer->nic = $request->nic;
        $vatPayer->email = $request->email;
        $vatPayer->phone = $request->phone;

        $vatPayer->save();
        return redirect()->back()->with('status', 'VAT Payer details updated successful');


    }

}