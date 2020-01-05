<?php

namespace App\Http\Controllers\vat;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Industrial_type;
use App\Assessment_range;
use App\Industrial_tax_shop;
use App\Industrial_tax_payment;
use App\Http\Requests\AddBusinessRequest;

class IndustrialTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    
    private function calculateTax($anualWorth, $assessmentAmmount, $lastPaymentDate)
    {
        $currentDate = now()->toArray();
        $industrialTax = Vat::where('route', 'industrial')->firstOrFail();

        // dd($anualWorth*($industrialTax->vat_percentage/100)+$assessmentAmmount);
        if ($lastPaymentDate!=null) {
            return ($anualWorth*($industrialTax->vat_percentage/100)+$assessmentAmmount)*($currentDate['year']-$lastPaymentDate['year']);
        }
        
        return $anualWorth*($industrialTax->vat_percentage/100)+$assessmentAmmount;
    }

    public function industrialProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $industrialTypes = Industrial_type::all();

        return view('vat.industrial.industrialProfile', ['vatPayer'=>$vatPayer,'industrialTypes'=>$industrialTypes]);
    }

    public function getIndustrialtypes(Request $request)
    {
        $search = $request->search;
       
        $industrialTax = Vat::where('route', 'industrial')->firstOrFail();
       
        $assessmentRangeId =  Assessment_range::where('vat_id', $industrialTax->id)->where('start_value', '<', $request->assessmentAmmount)
                            ->where(function (Builder $query) use ($request) {
                                $query->where('end_value', '>', $request->assessmentAmmount)
                                ->orWhere('end_value', '=', null);
                            })
                            ->firstOrFail()->id;

        $industrialTypes = Industrial_type::where('assessment_range_id', $assessmentRangeId)->
        where('description', 'like', "%$search%");
        $data = $industrialTypes->get(['id','description']);
        return response()->json(array("results"=>$data
       ), 200);
    }

    public function industrialPayments($shop_id)
    {
        $industrialTaxShop = Industrial_tax_shop::findOrFail($shop_id);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $industrialTaxShop->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $assessmentAmmount = $industrialTaxShop->industrialType->assessment_ammount;
            $duePayment = $this->calculateTax($industrialTaxShop->anual_worth, $assessmentAmmount, $lastPaymentDate);
        }
       
        return view('vat.industrial.industrialPayments', ['industrialTaxShop'=>$industrialTaxShop,'paid'=>$paid,'duePayment'=>$duePayment]);
    }

    // register new industrial shop
    public function registerIndustrialShop($id, AddBusinessRequest $request)
    {
        // dd('indus');
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $industrialTaxShop = new Industrial_tax_shop();
        $industrialTaxShop->registration_no = $request->assesmentNo;
        $industrialTaxShop->anual_worth = $request->annualAssesmentAmount;
        $industrialTaxShop->shop_name = $request->businessName;
        $industrialTaxShop->phone = $request->phoneno;
        $industrialTaxShop->door_no = $request->doorno;
        $industrialTaxShop->street = $request->street;
        $industrialTaxShop->city = $request->city;
        $industrialTaxShop->type = $request->type;
        $industrialTaxShop->employee_id =Auth::user()->id; // get releted employee id
        $industrialTaxShop->payer_id =$id;
 
        $industrialTaxShop ->save();
         
        return redirect()->route('industrial-profile', ['id'=>$vatPayer->id])->with('status', 'New Industrial shop Added successfully');
    }

    public function reciveIndustrialPayments($shop_id, Request $request)
    {
        // dd('indus');
        $payerId=Industrial_tax_shop::findOrFail($shop_id)->payer->id;  //get the VAT payer id
        
        $industrialTaxPyament = new Industrial_tax_payment;
        $industrialTaxPyament->payment = $request->payment;
        $industrialTaxPyament->shop_id = $shop_id;
        $industrialTaxPyament->payer_id =$payerId;
        $industrialTaxPyament->user_id = Auth::user()->id;
        $industrialTaxPyament->save();

        return redirect()->back()->with('sucess', 'Payment added successfuly');
    }

    //soft delete industrial payment
    public function removePayment($id)
    {
        $industrialTaxPyament = Industrial_tax_payment::find($id);
        $industrialTaxPyament -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //soft delete industrial shop
    public function removeIndustrialShop($shop_id)
    {
        $industrialTaxShop = Industrial_tax_shop::find($shop_id);
        $industrialTaxShop-> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    public function viewQuickPayments()
    {
        return view('vat.industrial.industrialQuickPayments');
    }

    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['duePaymentValue'] = [];
            $data['duePayments']=[];
            $currentDate = now()->toArray();    // get the currrent date properties
            $year = $currentDate['year'];
            $i =0;
            
            foreach ($data['payerDetails']->industrial as $shop) {
                $lastPaymentDate = $shop->payments->pluck('created_at')->last(); // get the last payment date
                $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
                $assessmentAmmount = $shop->industrialType->assessment_ammount;
                $data['duePaymentValue'][$i] = $this->calculateTax($shop->anual_worth, $assessmentAmmount, $lastPaymentDate);
                $data['duePayments'][$i]=  Industrial_tax_payment::where('shop_id', $shop->id)->where('created_at', 'like', "%$year%")->first(); //getting the latest payment if paid else null
                $i++;
            }
        }
        return response()->json($data, 200);
    }


    public function acceptQuickPayments(Request $request)
    {
        $shopIds = $request->except(['_token']);
        
        if (count($shopIds)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }
        
        foreach ($shopIds as $shopId => $val) {
            $industrialTaxShop=Industrial_tax_shop::findOrFail($shopId);  //get the VAT payer id
            $payerId = $industrialTaxShop->payer->id;
            $lastPaymentDate = $industrialTaxShop->payments->pluck('created_at')->last(); // get the last payment date
            $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
            $assessmentAmmount = $industrialTaxShop->industrialType->assessment_ammount;
            
            $duePayment = $this->calculateTax($industrialTaxShop->anual_worth, $assessmentAmmount, $lastPaymentDate);
            $industrialTaxPyament = new Industrial_tax_payment;
            $industrialTaxPyament->payment = $duePayment;
            $industrialTaxPyament->shop_id = $shopId;
            $industrialTaxPyament->payer_id =$payerId;
            $industrialTaxPyament->user_id = Auth::user()->id;
    
            $industrialTaxPyament->save();
        }
    
        return redirect()->back()->with('status', 'Payments successfully accepted');
    }

    public function trashPayment($id)
    {
        $industrialTaxPyament = Industrial_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
        return view('vat.industrial.trashPayment', ['industrialTaxPyament'=>$industrialTaxPyament]);
    }

    //restore payment
    public function restorePayment($id)
    {
        $industrialTaxPyament = Industrial_tax_payment::onlyTrashed()->where('id', $id);
        $shopId = $industrialTaxPyament->first()->shop_id;
        $industrialTaxPyament->restore();
        return redirect()->route('industrial-payments', ['shop_id'=>$shopId])->with('status', 'Payment restored successfully');
    }

    public function trashIndustrialShop($payer_id)
    {
        $industrialTaxShop = Industrial_tax_shop::onlyTrashed()->where('payer_id', $payer_id)->get();
        return view('vat.industrial.trashIndustrialShop', ['industrialTaxShop'=>$industrialTaxShop]);
    }


    public function restoreIndustrialShop($id)
    {
        $industrialTaxShop = Industrial_tax_shop::onlyTrashed()->where('id', $id);
        $payerId = $industrialTaxShop->first()->payer_id;
        $industrialTaxShop->restore();
        return redirect()->route('industrial-profile', ['id'=>$payerId])->with('status', 'Industrial shop restored successfully');
    }

    // premanent delete payment
    public function destory($id)
    {
        $indusrtialTaxPyament = Industrial_tax_payment::onlyTrashed()->where('id', $id)->first();
        //dd($indusrtialTaxPyament);
        $indusrtialTaxPyament->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful');
    }
}