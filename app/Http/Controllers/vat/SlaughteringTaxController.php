<?php


namespace App\Http\Controllers\vat;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat;
use App\Vat_payer;
use App\Slaughtering_type;
use App\Slaguhtering_tax_payment;

use App\Http\Requests\AddSlaughteringPaymentRequest;
use App\Http\Requests\UpdateSlaughteringPaymentRequest;


class SlaughteringTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    public function sloughteringProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $slaughteringTypes = Slaughtering_type::all();

        return view('vat.slaughtering.slaughteringProfile', ['vatPayer'=>$vatPayer],['slaughteringTypes'=>$slaughteringTypes]);
    }


    public function calculateSlaughteringTax($slaughteringType,$animal_Count)
    {
        $slaughteringType = Slaughtering_type::find($slaughteringType);
        
        return $animal_Count*$slaughteringType->amount;
    }


    public function reciveSlaughteringPayments($id, AddSlaughteringPaymentRequest $request)
    {
        $slaughteringPayment = new Slaguhtering_tax_payment;
        
        $slaughteringPayment->type_id = $request->slaughteringType;
        $slaughteringPayment->animal_count=$request->animal_Count;
        $slaughteringPayment->payer_id = $id;
        $slaughteringPayment->user_id = Auth::user()->id;
        $taxPayment = $this->calculateSlaughteringTax($request->slaughteringType,$request->animal_Count);
        $slaughteringPayment->payment = $taxPayment;
        $slaughteringPayment->save();
        
        return redirect()->back()->with('status', 'Payments successfully accepted')->with('taxPayment', $taxPayment);
    }


    public function updateSlaughteringPayment($id, UpdateSlaughteringPaymentRequest $request)
    {
        

        $slaughteringPayment = Slaguhtering_tax_payment::find($request->paymentId);
        $slaughteringPayment->type_id = $request->updateslaughteringType;
        
        $slaughteringPayment->animal_count=$request->updateAnimalCount;
        $slaughteringPayment->payer_id = $id;
        $slaughteringPayment->user_id = Auth::user()->id;
        $taxPayment = $this->calculateSlaughteringTax($request->updateslaughteringType,$request->updateAnimalCount);
        $slaughteringPayment->payment = $taxPayment;
        $slaughteringPayment->save();




        return redirect()->back()->with('status', 'Payments successfully updated')->with('taxpayment', $taxPayment);
    }

}
