<?php

namespace App\Http\Controllers\vat;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Assessment_range;  // #check this is the same and chnge if necessary
use App\Land_tax;
use App\Land_tax_payment;
use App\Http\Requests\AddLandRequest; 


class LandTaxController extends Controller
{
    public function _construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware(['vat']);
    }

    private function calculateTax($landWorth, $assessmentAmmount)
    {
        $currentDate = now()->toArray();
        $landTax = Vat::where('route', 'land')->firstOrFail();
        
        // Payments have to made on renting day itself, no amounts fines taken forward
        return $landWorth*($landTax->vat_percentage/100)+$assessmentAmmount;

    }

    public function landProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        // include if the types of lans available
        return veiw('vat.land.landProfile', ['vatPayer'=>$vatPayer]);
    }

    public function landPayments($land_id)
    {
        $landTax = Land_tax::findOrFail($land_id);
        $currentDate = now()->toArray();  // get the current date propoties
        $lastPaymentDate = $landTax->payments->pluck('created_at')->last();  // get the last payment date
        
        $duePayment = 0.0;
        $duePayment = $this->calculateTax($landTax->worth, $assessmentAmmount);

         return veiw('vat.land.landPayments', ['landTax'=>$landTax, 'duePayment'=>$duePayment]);  
    }

    // register new Premises for Land tax
    public function registerLand($id, AddLandRequest $request)
    {
        $vatPayer = Vat_payer:: find($id);  // get vat payer id
        $landTaxPremises = new Land_tax();
        $landTaxPremises->registration_no = $request->assesmentNo;
        $landTaxPremises->worth = $request->assesmentAmount;
        $landTaxPremises->land_name = $request->landName;  // check in blade
        $landTaxPremises->phone = $request->phoneNo;
        $landTaxPremises->door_no = $request->doorNo;
        $landTaxPremises->street = $request->street;
        $landTaxPremises->city = $request->city;
        $landTaxPremises->employee_id =Auth::user()->id; // get releted employee id
        $landTaxPremises->payer_id =$id;

        $landTaxPremises ->save();
        
        return redirect()->route('land-profile', ['id'=>$vatPayer->id])->with('status', 'New Premises Added successfully');
    }

    public function receiveLandPayments($land_id, Request $request)
    {
        $payerId = Land_tax::findOrFail($land_id)->payer->id;   // getting vat payer Id

        $landTaxPayment = new Land_tax_payment;
        $landTaxPayment->payment = $request->payment;
        $landTaxPayment->land_id = $land_id;
        $landTaxPayment->payment = $payerId;
        $landTaxPayment->payment = Auth::user()->id;
        $landTaxPayment->save();

        return redirect('status','Payment added Successfully'); 
    }

     //soft delete land payments
    public function removePayment($id)
    {
        $landTaxPayment = Land_tax_payment::find($land_id);
        $landTaxPayment = delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }

     //soft delete Lands(premises)
    public function removeLandPremises($land_id)
    {
        $landTaxPremises = Land_tax::find($land_id);
        $landTaxPremises->delete();
        return redirect()->back()->with('status','Deleted Successfully');

    }

    public function veiwQuickPayments()
    {
        return veiw('vat.land.landQuickPayments');
    }

    // check payments
    // accept quick payments  ($)

    public function trashPayment()
    {
        $landTaxPayment = Land_tax_payment::onlyTrashed()->where('payer_id',$id)->get();
        return view('vat.land.trashPayment', ['landTaxPayment'=>$landTaxPayment]);
    }

    public function restorePayment($id)
    {
        $landTaxPayment = Land_tax_payment::onlyTrashed()->where('id',$id);
        $shopId = $landTaxPayment->first()->land_id;
        $landTaxPayment->restore();
        return redirect()->route('land-payment', ['land_id'=>$landId])->with('status', 'Payment restored successfully');
    }

    public function trashLandPremises($payer_id)
    {
        $landTaxPremises = Land_tax::onlyTrashed()->where('payer_id',$payer_id)->get();
        return veiw('vat.land.trashLandPremises', ['landTaxPremises'=>$landTaxPremises]);
    }

    public function restoreLandPremises($id)
    {
        $landTaxPremises = Land_tax::onlyTrashed()->where('id',$id);
        $payerId = $landTaxPremises->first()->payer_id;
        $landTaxPremises->restore();
        return redirect()->route('land-profile', ['id'=>$payerId])->with('status','Premises restored successfully');
    }

}
