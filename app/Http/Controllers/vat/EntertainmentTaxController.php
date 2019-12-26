<?php

namespace App\Http\Controllers\Vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vat_payer;

class EntertainmentTaxController extends Controller
{
    public function entertainmentProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        return view('vat.entertainment.entertainmentPayments', ['vatPayer'=>$vatPayer]);
    }
}
