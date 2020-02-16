<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdvertisementRequest;
use App\Advertisement_tax;
use App\Advertisement_tax_payment;
use Auth;
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
        $advertisementTaxPayment = new Advertisement_tax_payment();
        $advertisementTaxPayment ->description = $request->description;
        $advertisementTaxPayment ->type = $request->type;
        $advertisementTaxPayment ->square_feet = $request->squarefeet;
        $advertisementTaxPayment ->price =$request->price;
        $advertisementTaxPayment ->final_payment = $this->calculateTax($request->price, $request->squarefeet);
        $advertisementTaxPayment ->employee_id =Auth::user()->id; // get releted employee id
        $advertisementTaxPayment ->payer_id =$id;
       
        $advertisementTaxPayment ->save();
        return redirect()->route('advertisement-profile', ['id'=>$vatPayer->id])->with('status', 'New Advertisement Added successfully');
    }
    
    public function removePayment($id)
    {
        $advertisementTaxPayment = Advertisement_tax_payment::find($id);
        $advertisementTaxPayment -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //trash payment
    public function trashPayment($id)
    {
        $advertisementTaxPayment = Advertisement_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
        return view('vat.advertisement.trashPayment', ['advertisementTaxPayment'=>$advertisementTaxPayment]);
    }
    
    //restore payment
    public function restorePayment($id)
    {
        $advertisementTaxPayment = Advertisement_tax_payment::onlyTrashed()->where('id', $id)->restore($id);
        return redirect()->route('trash-payment', ['advertisementTaxPayment'=>$advertisementTaxPayment])->with('status', 'Payment restore successful');
    }
    public function calculateTax($price,$squarefeet){
        $currentDate = now()->toArray();
        $advertisementTaxType = Vat::where('route', 'advertisement')->firstOrFail();
        return $price*$squarefeet*($advertisementTaxType->vat_percentage/100)+($price*$squarefeet);

    }
    
}
