<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Vat;
use App\Vat_payer;
use App\Business_type;

use App\Http\Requests\AddBusinessRequest;
use App\Business_tax_payment;
use App\Business_tax_shop;
use App\Assessment_range;

use App\Jobs\BusinessTaxNoticeJob;

use Auth;
use App\Http\Requests\BusinessTaxReportRequest;
//report Generation
use PDF;
use Illuminate\Support\Facades\DB;
use App\Reports\BusinessReport;

class BusinessTaxController extends Controller
{   private $records;
    public function __construct()
    {
        //$this->middleware(['auth'=>'verified']);
        //$this->middleware('vat');
    }
    
    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['payerShops'] = $data['payerDetails']->buisness;
            $data['duePayments']=[];
            $currentDate = now()->toArray();    // get the currrent date properties
            $year = $currentDate['year'];
            $i =0;
            foreach ($data['payerShops'] as $shop) {
                $data['duePayments'][$i]=  Business_tax_payment::where('shop_id', $shop->id)->where('created_at', 'like', "%$year%")->first();
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
            $businessTaxShop=Business_tax_shop::findOrFail($shopId);  //get the VAT payer id
            $payerId = $businessTaxShop->payer->id;
            $lastPaymentDate = $businessTaxShop->payments->pluck('created_at')->last(); // get the last payment date
            $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
            $assessmentAmmount = $businessTaxShop->businessType->assessment_ammount;
            
            $duePayment = $this->calculateTax($businessTaxShop->anual_worth, $assessmentAmmount, $lastPaymentDate);
            $businessTaxPyament = new Business_tax_payment;
            $businessTaxPyament->payment = $duePayment;
            $businessTaxPyament->shop_id = $shopId;
            $businessTaxPyament->payer_id =$payerId;
            $businessTaxPyament->user_id = Auth::user()->id;
    
            $businessTaxPyament->save();
        }
    
        return redirect()->back()->with('status', 'Payments successfully accepted');
    }


    public function latestPayment()
    {
        return view('vat.business.latestPayments');
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
        $businessTax = Vat::where('name', 'Business Tax')->firstOrFail();
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $businessTaxShop->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            // dd($businessTax->id);
            $duePayment = $businessTaxShop->anual_worth * ($businessTax->vat_percentage/100);   //Tax due payment ammount
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
    {   $reportData = BusinessReport::generateBusinessReport();
        $dates = (object)$request->only(["startDate","endDate"]);
          
        $records=Business_tax_payment::whereBetween('created_at',[$dates->startDate,$dates->endDate])->get();
    
        $records = Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates       
       if($request->has('TaxReport'))
        {
            return view('vat.business.businessReportView',['dates'=>$dates,'records'=>$records]);
        }
        else if($request->has('SummaryReport'))
        {
            return view('vat.business.businessSummaryReport',['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        }
      
        
    }

    public function TaxPdf(BusinessTaxReportRequest $request)                                                                    //Tax Report PDF                                          
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Business_tax_payment::whereBetween('created_at',[$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates  
        $sum=Business_tax_payment::whereBetween('created_at',[$dates->startDate,$dates->endDate])->sum('payment');
        $pdf->loadHTML($this->TaxReportHTML($records,$dates,$sum));
        

       
        return $pdf->stream();
    }

    public function TaxReportHTML($records,$dates,$sum)                                                         //HTML script for the report pdfp
    { 
    
     $output = "
     <h3 align='center'>Businness Tax Report from $dates->startDate to $dates->endDate </h3>
     <table width='100%' style='border-collapse: collapse; border: 0px;'>
      <tr>
    <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
    <th style='border: 1px solid; padding:12px;' width='10%'>SHOP ID</th>
    <th style='border: 1px solid; padding:12px;' width='20%'>VAT PAYER'S ID</th>
    <th style='border: 1px solid; padding:12px;' width='20%'>VAT PAYER'S NAME</th>
    <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
   </tr>
     ";  
     foreach($records as $record)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.'Rs. '.$record->payment.'</td>
       <td style="border: 1px solid; padding:12px;">'.$record->shop_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$record->payer_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->first_name.'</td>
        <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->nic.'</td>
        
      </tr>
      ';
     }
     
     $output .= '</table>';
     $output .= "<br>Total Payements : Rs.$sum.00/=";
     return $output;
    }
       
    public function summaryPdf(BusinessTaxReportRequest $request)                         //Summary Report PDF                                          
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Business_tax_payment::whereBetween('created_at',[$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates  
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->summaryReportHTML($records,$dates,$sum));
        

        return $pdf->stream();
    }
    public function summaryReportHTML($records,$dates,$sum)
    {   $reportData = BusinessReport::generateBusinessReport();
        $output = "
         <h3 align='center'>Businness Summary Report from $dates->startDate to $dates->endDate </h3>
         <table width='100%' style='border-collapse: collapse; border: 0px;'>
          <tr>
        <th style='border: 1px solid; padding:12px;' width='20%'>Business Type</th>
        <th style='border: 1px solid; padding:12px;' width='10%'>Total Payments</th>
    
    
       </tr>
         ";  
         foreach($reportData as $description => $total)
         {
          $output .= '
          <tr>
           <td style="border: 1px solid; padding:12px;">'.$description.'</td>
           <td style="border: 1px solid; padding:12px;">'.'Rs.' .$total.'.00</td>
           
          </tr>
          ';
         }
       
        
         $output .= '</table>';
         $output .= "<br>Total Payements : Rs.$sum.00/=";
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
    public function restoreBusiness($id){
        $businessTaxShop = Business_tax_shop::onlyTrashed()->where('id', $id)->restore($id);
        return redirect()->route('trash-business', ['businessTaxShop'=>$businessTaxShop])->with('status','Business restore successful');
    }

    //soft delete business payment
    public function removePayment($id)
    {
        $businessTaxPyament = Business_tax_payment::find($id);
        $businessTaxPyament -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //trash payment
    public function trashPayment($id){
        $businessTaxPyament = Business_tax_payment::onlyTrashed()->where('payer_id', $id)->get(); 
        return view('vat.business.trashPayment',['businessTaxPyament'=>$businessTaxPyament]);
       
    }
    //restore payment
    public function restorePayment($id){
        $businessTaxPyament = Business_tax_payment::onlyTrashed()->where('id', $id)->restore($id);
        return redirect()->route('trash-payment', ['businessTaxPyament'=>$businessTaxPyament])->with('status','Payment restore successful');
    }
    // premanent delete payment
    public function destory($id)
    {
        $businessTaxPyament = Business_tax_payment::onlyTrashed()->where('id', $id)->first();
        //dd($businessTaxPyament);
        $businessTaxPyament->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful'); 
    }

    public function reciveBusinessPayments($shop_id, Request $request)
    {
        $payerId=Business_tax_shop::findOrFail($shop_id)->payer->id;  //get the VAT payer id
        
        $businessTaxPyament = new Business_tax_payment;
        $businessTaxPyament->payment = $request->payment;
        $businessTaxPyament->shop_id = $shop_id;
        $businessTaxPyament->payer_id =$payerId;
        $businessTaxPyament->user_id = Auth::user()->id;
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
        return response()->json(array("results"=>$data
       ), 200);
    }

    public function sendNotice($id)
    {
        $currentDate = Carbon::now()->toArray();
        $year = $currentDate['year'];
        $taxPayment=Business_tax_payment::where('shop_id', $id)->where('created_at', 'like', "%$year%")->first();

        if ($taxPayment!=null) {
            return redirect()->back()->with('warning', "Tax already paid for this year for this business");
        }

        $vatPayerMail = Business_tax_shop::find($id)->payer->email;
        //pushing mail to the queue
        dispatch(new  BusinessTaxNoticeJob($vatPayerMail, $id));
        return redirect()->back()->with('status', 'Mail queued successfully');
    }
}
