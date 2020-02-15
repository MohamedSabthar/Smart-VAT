<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdvertisementRequest;
use App\Advertisement_tax;
use App\Vat;
use App\Vat_payer;


class AdvertisementTaxController extends Controller
{
   
    public function advertisementProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $advertisementTaxType = Advertisement_tax::all();

        return view('vat.advertisement.advertisementPayment', ['vatPayer'=>$vatPayer,'advertisementTaxType'=>$advertisementTaxType]);
    }

    
    public function registerAdvertisementPayment($id, AddAdvertisementRequest $request)
    {
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $advertisementTaxPayment = new advertisement_tax_payment();
        $advertisementTaxPayment ->description = $request->description;
        $advertisementTaxPayment ->type = $request->type;
        $advertisementTaxPayment ->square_feet = $request->squarefeet;
        $advertisementTaxPayment ->employee_id =Auth::user()->id; // get releted employee id
        $advertisementTaxPayment ->payer_id =$id;
    
        $advertisementTaxPayment ->save();
        dd($advertisementTaxPayment);
        return redirect()->route('advertisement-register', ['id'=>$vatPayer->id])->with('status', 'New Advertisement Added successfully');
    }

}
