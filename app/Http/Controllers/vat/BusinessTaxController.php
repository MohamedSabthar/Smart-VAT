<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBusinessRequest;
use App\Http\Requests\BusinessTaxReportRequest;

use App\Vat;
use App\Vat_payer;
use App\Business_type;
use App\Business_tax_payment;
use App\Business_tax_shop;
use App\Business_tax_due_payment;
use App\Assessment_range;

use App\Jobs\BusinessTaxNoticeJob;

use Auth;
use Carbon\Carbon;

//report Generation
use PDF;
use Illuminate\Support\Facades\DB;
use App\Reports\BusinessReport;

class BusinessTaxController extends Controller
{
    private $records;

    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    
    /**
     * funtion to calculate business tax
     */
    private function calculateTax($anualWorth, $assessmentAmmount, $dueAmount)
    {
        $currentDate = now()->toArray();
        $businessTax = Vat::where('name', 'Business Tax')->firstOrFail();
        return $anualWorth*($businessTax->vat_percentage/100)+$assessmentAmmount+$dueAmount;
    }
    
    
    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['duePaymentValue'] = [];
            $data['duePayments']=[];
            $currentDate = now()->toArray();                                        // get the currrent date properties
            $year = $currentDate['year'];
            $i =0;
            
            foreach ($data['payerDetails']->buisness as $shop) {
                $assessmentAmmount = $shop->businessType->assessment_ammount;       //assessment amount
                $dueAmount = $shop->due == null ? 0 : $shop->due->due_ammount;      //last due ammount which is not yet paid
                $data['duePaymentValue'][$i] = $this->calculateTax($shop->anual_worth, $assessmentAmmount, $dueAmount);
                $data['duePayments'][$i]=  Business_tax_payment::where('shop_id', $shop->id)->where('created_at', 'like', "%$year%")->first(); //getting the latest payment if paid else null
                $i++;
            }
        }
        return response()->json($data, 200);
    }

    public function viewQuickPayments()
    {
        return view('vat.business.buisnessQuickPayments');
    }

    
    public function acceptQuickPayments(Request $request)
    {
        $shopIds = $request->except(['_token']);
        
        if (count($shopIds)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }
        
        foreach ($shopIds as $shopId => $val) {
            $businessTaxShop=Business_tax_shop::findOrFail($shopId);                                //get the VAT payer id
            $payerId = $businessTaxShop->payer->id;
            $assessmentAmmount = $businessTaxShop->businessType->assessment_ammount;
            $dueAmount = $businessTaxShop->due == null ? 0 : $businessTaxShop->due->due_ammount;   //last due ammount which is not yet paid
            $duePayment = $this->calculateTax($businessTaxShop->anual_worth, $assessmentAmmount, $dueAmount);
            $businessTaxPyament = new Business_tax_payment;
            $businessTaxPyament->payment = $duePayment;
            $businessTaxPyament->shop_id = $shopId;
            $businessTaxPyament->payer_id =$payerId;
            $businessTaxPyament->user_id = Auth::user()->id;

            // if there was a duepayment update it to zero
            if ($businessTaxShop->due != null && $businessTaxShop->due->due_ammount!=0) {
                $lastDue = Business_tax_due_payment::where('shop_id', $businessTaxShop->id)->first();
                $lastDue->due_ammount = 0;
                $lastDue->save();
            }

            $businessTaxPyament->save();
        }
    
        return redirect()->back()->with('status', 'Payments successfully accepted');
    }


    public function latestPayment()
    {
        $payments = Business_tax_payment::all();
        // $payerName = Business_tax_payment::findOrFail(payer_id)->vatPayer->full_name;
        return view('vat.business.latestPayments', ['payments'=>$payments]);
    }
    

    public function buisnessProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $businessTypes = Business_type::all();

        return view('vat.business.businessProfile', ['vatPayer'=>$vatPayer,'businessTypes'=>$businessTypes]);
    }


    public function businessPayments($shop_id)
    {
        $businessTaxShop = Business_tax_shop::findOrFail($shop_id);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $businessTaxShop->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $assessmentAmmount = $businessTaxShop->businessType->assessment_ammount;
            $dueAmount = $businessTaxShop->due == null ? 0 : $businessTaxShop->due->due_ammount;   //last due ammount which is not yet paid
            $duePayment = $this->calculateTax($businessTaxShop->anual_worth, $assessmentAmmount, $dueAmount);
        }
       
        return view('vat.business.businessPayments', ['businessTaxShop'=>$businessTaxShop,'paid'=>$paid,'duePayment'=>$duePayment]);
    }
    
    // register new business
    public function registerBusiness($id, AddBusinessRequest $request)
    {
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $businessTaxShop = new Business_tax_shop();
        $businessTaxShop->registration_no = $request->assesmentNo;
        $businessTaxShop->anual_worth = $request->annualAssesmentAmount;
        $businessTaxShop->shop_name = $request->businessName;
        $businessTaxShop->phone = $request->phoneno;
        $businessTaxShop->door_no = $request->doorno;
        $businessTaxShop->street = $request->street;
        $businessTaxShop->city = $request->city;
        $businessTaxShop->type = $request->type;
        $businessTaxShop->employee_id =Auth::user()->id; // get releted employee id
        $businessTaxShop->payer_id =$id;

        $businessTaxShop ->save();
        
        return redirect()->route('business-profile', ['id'=>$vatPayer->id])->with('status', 'New Business Added successfully');
    }

    //Report Generation
    public function businessReportGeneration()                                                                       //directs the report genaration view
    {
        return view('vat.business.businessReportGeneration');
    }


    public function generateReport(BusinessTaxReportRequest $request)                                              //get the star date and the end date for the report generation
    {
        $reportData = BusinessReport::generateBusinessReport();
        $dates = (object)$request->only(["startDate","endDate"]);
          
        $records=Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();
    
        $records = Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.business.businessReportView', ['dates'=>$dates,'records'=>$records]);
        } elseif ($request->has('SummaryReport')) {
            return view('vat.business.businessSummaryReport', ['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        }
    }


    public function TaxPdf(BusinessTaxReportRequest $request)                                                      //pdf generation library function
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $ShopCount=Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->count('shop_id');
        $pdf->loadHTML($this->TaxReportHTML($records, $dates, $Paymentsum, $ShopCount));
        

       
        return $pdf->stream();
    }


    public function TaxReportHTML($records, $dates, $Paymentsum, $ShopCount)
    {
        $output = "
        <h3 align='center'>Businness Tax Report from $dates->startDate to $dates->endDate </h3>
        <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
         <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>SHOP</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT DATE</th>
   
       
       
      </tr>
        ";
        foreach ($records as $record) {
            $output .= '
         <tr>
         <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->nic.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->full_name.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->shop_id.' - '.$record->businessTaxShop->shop_name.'</td>
          <td style="border: 1px solid; padding:12px;">'.'Rs. '.number_format($record->payment, 2).'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->updated_at.'</td>
           
         </tr>
         ';
        }
        
        $output .= '</table>';
        $output .= "<br>Total Shops : ".$ShopCount;
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }
    public function summaryPdf(BusinessTaxReportRequest $request)                         //Summary Report PDF
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->summaryReportHTML($records, $dates, $sum));
        

        return $pdf->stream();
    }
    public function summaryReportHTML($records, $dates, $sum)
    {
        $reportData = BusinessReport::generateBusinessReport();
        $output = "
         <h3 align='center'>Businness Summary Report from $dates->startDate to $dates->endDate </h3>
         <table width='100%' style='border-collapse: collapse; border: 0px;'>
          <tr>
        <th style='border: 1px solid; padding:12px;' width='20%'>Business Type</th>
        <th style='border: 1px solid; padding:12px;' width='10%'>Total Payments</th>
    
    
       </tr>
         ";
        foreach ($reportData as $description => $total) {
            $output .= '
          <tr>
           <td style="border: 1px solid; padding:12px;">'.$description.'</td>
           <td style="border: 1px solid; padding:12px;">'.'Rs.' .number_format($total, 2).'.00</td>
           
          </tr>
          ';
        }
       
        
        $output .= '</table>';
        $output .= "<br>Total Payements : Rs. ".number_format($sum, 2)."/=";
        return $output;
    }



    //delete business
    public function removeBusiness($shop_id)
    {
        $businessTaxShop = Business_tax_shop::find($shop_id);
        $businessTaxShop-> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }
    //trash business
    public function trashBusiness($payer_id)
    {
        $businessTaxShop = Business_tax_shop::onlyTrashed()->where('payer_id', $payer_id)->get();
        return view('vat.business.trashBusiness', ['businessTaxShop'=>$businessTaxShop]);
    }
    // restore business
    public function restoreBusiness($id)
    {
        $businessTaxShop = Business_tax_shop::onlyTrashed()->where('id', $id)->restore($id);
        return redirect()->route('trash-business', ['businessTaxShop'=>$businessTaxShop])->with('status', 'Business restore successful');
    }
    //soft delete business payment
    public function removePayment($id)
    {
        $businessTaxPyament = Business_tax_payment::find($id);
        $businessTaxShop = $businessTaxPyament->businessTaxShop;

        //restore the dueAmout
        $restoreDue = Business_tax_due_payment::where('shop_id', $businessTaxPyament->businessTaxShop->id)->first();
        $recalculatedDue = $this->calculateTax(-$businessTaxShop->anual_worth, -$businessTaxShop->businessType->assessment_ammount, $businessTaxPyament->payment) ;
        if ($restoreDue==null) {
            $restoreDue = new Business_tax_due_payment;
            $restoreDue->shop_id = $businessTaxPyament->shop_id;
            $restoreDue->payer_id = $businessTaxPyament->payer_id;
        }
        
        if ($recalculatedDue!=0) {
            $restoreDue->due_ammount =  $recalculatedDue ;
            $restoreDue->save();
        }
        $businessTaxPyament -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //trash payment
    public function trashPayment($id)
    {
        $businessTaxPyament = Business_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
        
        return view('vat.business.trashPayment', ['businessTaxPyament'=>$businessTaxPyament]);
    }
    
    //restore payment
    public function restorePayment($id)
    {
        $businessTaxPyament = Business_tax_payment::onlyTrashed()->where('id', $id)->restore($id);
        return redirect()->route('trash-payment', ['businessTaxPyament'=>$businessTaxPyament])->with('status', 'Payment restore successful');
    }

    // premanent delete payment
    public function destory($id)
    {
        $businessTaxPyament = Business_tax_payment::onlyTrashed()->where('id', $id)->first();
        $businessTaxPyament->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful');
    }


    public function reciveBusinessPayments($shop_id, Request $request)
    {
        $businessTaxShop=Business_tax_shop::findOrFail($shop_id);
        $payerId =  $businessTaxShop->payer->id;  //get the VAT payer id
        $businessTaxPyament = new Business_tax_payment;
        $businessTaxPyament->payment = $request->payment;
        $businessTaxPyament->shop_id = $shop_id;
        $businessTaxPyament->payer_id =$payerId;
        $businessTaxPyament->user_id = Auth::user()->id;
        
        // if there was a duepayment update it to zero
        if ($businessTaxShop->due != null && $businessTaxShop->due->due_ammount!=0) {
            $lastDue = Business_tax_due_payment::where('shop_id', $businessTaxShop->id)->first();
            $lastDue->due_ammount = 0;
            $lastDue->save();
        }


        $businessTaxPyament->save();

        return redirect()->back()->with('status', 'Payment added successfuly');
    }


    public function getBusinestypes(Request $request)
    {
        $search = $request->search;
        $businessTax = Vat::where('route', 'business')->firstOrFail();
        $assessmentRangeId =  Assessment_range::where('start_value', '<', $request->assessmentAmmount)
                                 ->where(function (Builder $query) use ($request) {
                                     $query->where('end_value', '>', $request->assessmentAmmount)
                                ->orWhere('end_value', '=', null);
                                 })
                                ->where('vat_id', $businessTax->id)
                                ->firstOrFail()->id;
                                
        $businessTypes = Business_type::where('assessment_range_id', $assessmentRangeId)->
        where('description', 'like', "%$search%");
        $data = $businessTypes->get(['id','description']);
        
        return response()->json(array("results"=>$data), 200);
    }

    public function sendNotice($id)
    {
        $currentDate = Carbon::now()->toArray();
        $year = $currentDate['year'];
        $taxPayment=Business_tax_payment::where('shop_id', $id)->where('created_at', 'like', "%$year%")->first();

        //if already paid for this year don't allow to send notification
        if ($taxPayment!=null) {
            return redirect()->back()->with('warning', "Tax already paid for this year for this business");
        }

        $vatPayerMail = Business_tax_shop::find($id)->payer->email;
        //pushing mail to the queue
        dispatch(new  BusinessTaxNoticeJob($vatPayerMail, $id));
        return redirect()->back()->with('status', 'Mail queued successfully');
    }
}