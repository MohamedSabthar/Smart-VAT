<?php

namespace App\Http\Controllers\vat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop_rent_tax;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Http\Requests\AddShopRentRequest;


class ShopRentTaxController extends Controller
{
    //

    public function shoprentProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        //$industrialTypes = Industrial_type::all();

        return view('vat.shopRent.shopRentProfile', ['vatPayer'=>$vatPayer]);
    }


    public function registerShopRent($id, AddShopRentRequest $request)
    {
        
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $shopRentTax = new Shop_rent_tax();
        $shopRentTax->registration_no = $request->assesmentNo;
        $shopRentTax->anual_worth = $request->annualAssesmentAmount;
        $shopRentTax->shop_name = $request->businessName;
        $shopRentTax->phone = $request->phoneno;
        $shopRentTax->door_no = $request->doorno;
        $shopRentTax->street = $request->street;
        $shopRentTax->city = $request->city;
        $shopRentTax->employee_id = Auth::user()->id; // get releted employee id
        $shopRentTax->payer_id =$id;
 
        $shopRentTax ->save();
         
        return redirect()->route('shop-rent-profile', ['id'=>$vatPayer->id])->with('status', 'New shop Rent Added successfully');
    }
}
