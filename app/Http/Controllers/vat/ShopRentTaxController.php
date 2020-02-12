<?php

namespace App\Http\Controllers\vat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddShopRentRequest;
use App\Http\Requests\ShopRentTaxReportRequest;
use App\Shop_rent_tax;
use App\Shop_rent_tax_payment;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Shop_rent_tax_due_payment;


class ShopRentTaxController extends Controller
{
    //

    public function shoprentProfile($id)
    {
        $vatPayer = Vat_payer::find($id);

        return view('vat.shopRent.shopRentProfile', ['vatPayer'=>$vatPayer]);
    }


    public function registerShopRent($id, AddShopRentRequest $request)
    {
        
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $shopRentTax = new Shop_rent_tax();
        $shopRentTax->registration_no = $request->assesmentNo;
        $shopRentTax->key_money =$request->keyMoney;
        $shopRentTax->month_worth = $request->monthAssesmentAmount;
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
  

    private function calculateTax($assessmentAmmount, $dueAmount)
    {
        $currentDate = now()->toArray();
        $shopRentTax = Vat::where('route', 'shoprent')->firstOrFail();
        return $assessmentAmmount*($shopRentTax->vat_percentage/100)+$assessmentAmmount+$dueAmount;
    }
    public function shopRentPayments($shop_id)
    {
        $shopRentTax = Shop_rent_tax::findOrFail($shop_id);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $shopRentTax->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        
        if ($lastPaymentDate!=null && $currentDate['month'] == $lastPaymentDate['month']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $assessmentAmmount = $shopRentTax->month_worth;
            $dueAmount = $shopRentTax->due == null ? 0 : $shopRentTax->due->due_ammount; 
            $duePayment = $this->calculateTax($shopRentTax->month_worth,$dueAmount);
          
        }
        return view('vat.shopRent.shopRentPayment', ['shopRentTax'=>$shopRentTax,'paid'=>$paid,'duePayment'=>$duePayment]);
    } 
    
    public function reciveshopRentPayments($shop_id, Request $request)
    {
        $payerId=Shop_rent_tax::findOrFail($shop_id)->payer->id;  //get the VAT payer id
        
        $shoprentTaxpayment = new Shop_rent_tax_payment;
        $shoprentTaxpayment->payment = $request->payment;
        $shoprentTaxpayment->shop_id = $shop_id;
        $shoprentTaxpayment->payer_id =$payerId;
        $shoprentTaxpayment->user_id = Auth::user()->id;
        $shoprentTaxpayment->save();

        return redirect()->back()->with('sucess', 'Payment added successfuly');
    }

    public function viewQuickPayments()
    {
        return view('vat.shopRent.shopRentQuickPayments');
    }

    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['duePaymentValue'] = [];
            $data['duePayments']=[];
            $currentDate = now()->toArray();    // get the currrent date properties
            $month = $currentDate['month'];
            $i =0;
            
            foreach ($data['payerDetails']->shoprent as $shop) {
                $assessmentAmmount = $shop->month_worth;       //assessment amount
                $dueAmount = $shop->due == null ? 0 : $shop->due->due_ammount;      //last due ammount which is not yet paid
                $data['duePaymentValue'][$i] = $this->calculateTax($shop->month_worth,$dueAmount);
                $data['duePayments'][$i]=  Shop_rent_tax_payment::where('shop_id', $shop->id)->where('created_at', 'like', "%$month%")->first(); //getting the latest payment if paid else null
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
            $shopRentTax= Shop_rent_tax::findOrFail($shopId);  //get the VAT payer id
            $payerId = $shopRentTax->payer->id;
            $lastPaymentDate = $shopRentTax->payments->pluck('created_at')->last(); // get the last payment date
            $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
            $assessmentAmmount = $shopRentTax->month_worth;
            
            $duePayment = $this->calculateTax($shopRentTax->month_worth,$dueAmount);
            $shoprentTaxpayment = new Shop_rent_tax_payment;
            $shoprentTaxpayment->payment = $duePayment;
            $shoprentTaxpayment->shop_id = $shopId;
            $shoprentTaxpayment->payer_id =$payerId;
            $shoprentTaxpayment->user_id = Auth::user()->id;
    
            $shoprentTaxpayment->save();
        }
    
        return redirect()->back()->with('status', 'Payments successfully accepted');
    }

    public function shopRentReportGeneration()                                                                       //directs the report genaration view
    {
        return view('vat.shoprent.shopRentReportGeneration');
    }

    public function generateReport(ShopRentTaxReportRequest $request){
       // $reportData = BusinessReport::generateBusinessReport();
        $dates = (object)$request->only(["startDate","endDate"]);
          
        $records=Shop_rent_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();
    
        $records = Shop_rent_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.shoprent.shopRentReportView', ['dates'=>$dates,'records'=>$records]);
       
        }
        
    }
    public function removePayment($id)
    {
        $shoprentTaxpayment =  Shop_rent_tax_payment::find($id);
        $shoprentTaxpayment->delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    
    public function trashPayment($id)
    {
        $shoprentTaxpayment = Shop_rent_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
        return view('vat.shopRent.trashPayment', ['shoprentTaxpayment'=>$shoprentTaxpayment]);
    }

    //restore payment
    public function restorePayment($id)
    {
        $shoprentTaxpayment = Shop_rent_tax_payment::onlyTrashed()->where('id', $id);
        $shopId = $shoprentTaxpayment->first()->shop_id;
        $shoprentTaxpayment->restore();
        return redirect()->route('shop-rent-payments', ['shop_id'=>$shopId])->with('status', 'Payment restored successfully');
    }


    public function removeShopRent($shop_id)
    {
        $shopRentTax = Shop_rent_tax::find($shop_id);
        $shopRentTax-> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    public function trashShopRent($payer_id)
    {
        $shopRentTax = Shop_rent_tax::onlyTrashed()->where('payer_id', $payer_id)->get();
        return view('vat.shopRent.trashRentShop', ['shopRentTax'=>$shopRentTax]);
    }

    public function restoreShopRent($id)
    {
        $shopRentTax = Shop_rent_tax::onlyTrashed()->where('id', $id);
        $payerId = $shopRentTax->first()->payer_id;
        $shopRentTax->restore();
        return redirect()->route('shop-rent-profile', ['id'=>$payerId])->with('status', 'shop restored successfully');
    }

}
