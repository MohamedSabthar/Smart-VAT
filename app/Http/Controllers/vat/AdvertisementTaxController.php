<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advertisement_tax;

class AdvertisementTaxController extends Controller
{
    public function advertisementPayment($id)
    {
        $vatPayer = Vat_payer::find($id);
        return view('vat.advertisement.advertisementPayment', ['vatPayer'=>$vatPayer]);
    }


}
