<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdvertisementRequest;
use App\Http\Requests\AdvertisementTaxReportRequest;
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
        $advertisementTaxPayment = Advertisement_tax_payment::onlyTrashed()->where('id', $id);
        // dd($advertisementTaxPayment->get());
        $payerId = $advertisementTaxPayment->first()->payer_id;
        $advertisementTaxPayment->restore($id);
        return redirect()->route('advertisement-profile', ['id'=>$payerId])->with('status', 'Payment restore successful');
    }
    public function calculateTax($price,$squarefeet){
        $currentDate = now()->toArray();
        $advertisementTaxType = Vat::where('route', 'advertisement')->firstOrFail();
        return $price*$squarefeet*($advertisementTaxType->vat_percentage/100)+($price*$squarefeet);

    }
    public function advertisementReportGeneration()                                                                       //directs the report genaration view
    {
        return view('vat.advertisement.advertisementReportGeneration');
    }
    public function generateReport(AdvertisementTaxReportRequest $request){
        $dates = (object)$request->only(["startDate","endDate"]);
        $records = Advertisement_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
  
            return view('vat.advertisement.advertisementReportView', ['dates'=>$dates,'records'=>$records]);
       
     }
    public function TaxPdf(AdvertisementTaxReportRequest $request){

        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Advertisement_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Advertisement_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('final_payment');
        $pdf->loadHTML($this->TaxReportHTML($records, $dates, $Paymentsum));
        

       
        return $pdf->stream();

    }

    public function TaxReportHTML($records, $dates, $Paymentsum)
    {
        $output = "
        <h3 align='center'>Advertisement Tax Report from $dates->startDate to $dates->endDate </h3>
        <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
         <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT DATE</th>
   
       
       
      </tr>
        ";
        foreach ($records as $record) {
            $output .= '
         <tr>
         <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->nic.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->full_name.'</td>
          <td style="border: 1px solid; padding:12px;">'.'Rs. '.number_format($record->final_payment, 2).'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->updated_at.'</td>
           
         </tr>
         ';
        }
        
        $output .= '</table>';
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }

}
