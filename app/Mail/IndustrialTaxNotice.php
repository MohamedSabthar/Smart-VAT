<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Industrial_tax_shop;
use App\Vat;

use Carbon\Carbon;

class IndustrialTaxNotice extends Mailable
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
        $industrial = Industrial_tax_shop::find($this->id);
        $date = Carbon::now();
        $year = $date->toArray()['year'];
        $duePayment = $this->calculateTax($this->id);
        return $this->markdown('mail.industrialTaxNotice', ['industrial'=>$industrial,'date'=>$date,'year'=>$year,'duePayment'=>$duePayment]);
    }

    private function calculateTax($shopId)
    {
        $industrialTaxShop=Industrial_tax_shop::findOrFail($shopId);  //get the VAT payer id
        // $payerId = $industrialTaxShop->payer->id;
       
        $assessmentAmmount = $industrialTaxShop->businessType->assessment_ammount;
            
       
        $businessTax = Vat::where('name', 'Business Tax')->firstOrFail();
        $dueAmmount = $industrialTaxShop->due==null ? 0 : $industrialTaxShop->due->due_ammount;
        return $industrialTaxShop->anual_worth*($businessTax->vat_percentage/100)+$assessmentAmmount+$dueAmmount;
    }
}