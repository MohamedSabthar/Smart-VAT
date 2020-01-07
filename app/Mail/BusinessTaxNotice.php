<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Business_tax_shop;
use App\Vat;

use Carbon\Carbon;

class BusinessTaxNotice extends Mailable
{
    use Queueable, SerializesModels;
    private $id;
    private $duePayment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $business = Business_tax_shop::find($this->id);
        $date = Carbon::now();
        $year = $date->toArray()['year'];
        $duePayment = $this->calculateTax($this->id);
        return $this->markdown('mail.businessTaxNotice', ['business'=>$business,'date'=>$date,'year'=>$year,'duePayment'=>$duePayment]);
    }

    private function calculateTax($shopId)
    {
        $businessTaxShop=Business_tax_shop::findOrFail($shopId);  //get the VAT payer id
        // $payerId = $businessTaxShop->payer->id;
        $lastPaymentDate = $businessTaxShop->payments->pluck('created_at')->last(); // get the last payment date
            $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
            $assessmentAmmount = $businessTaxShop->businessType->assessment_ammount;
            
        $currentDate = now()->toArray();
        $businessTax = Vat::where('name', 'Business Tax')->firstOrFail();
        if ($lastPaymentDate!=null) {
            return ($businessTaxShop->anual_worth*($businessTax->vat_percentage/100)+$assessmentAmmount)*($currentDate['year']-$lastPaymentDate['year']);
        }
        
        return $businessTaxShop->anual_worth*($businessTax->vat_percentage/100)+$assessmentAmmount;
    }
}