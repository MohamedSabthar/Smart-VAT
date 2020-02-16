<?php

namespace App\Http\Controllers\vat;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat;
use App\Vat_payer;


class SlaughteringTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    public function sloughteringShopProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
       // $industrialTypes = Industrial_type::all();

        return view('vat.industrial.industrialProfile', ['vatPayer'=>$vatPayer]);
    }

}
