<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat_payer;
use App\Http\Requests\UpdateVatPayerProfileRequest;

class PayerUpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
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
        $vatPayer->door_no = $request->doorNo;
        $vatPayer->street = $request->street;
        $vatPayer->city = $request->city;
             
        $vatPayer->save();
        return redirect()->back()->with('status', 'VAT Payer details updated successful');
    }

    public function vatPayerProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        return view('vatPayer.updateVatPayerProfile', ['vatPayer'=>$vatPayer]);
    }
}