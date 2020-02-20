<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Land_tax;
use App\Vat;

use Carbon\Carbon;

class LandTaxNotice extends Mailable
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
        $land = Land_tax::find($this->id);
        $date = Carbon::now();
        $year = $date->toArray()['year'];
        $duePayment = $this->calculateTax($this->id);
        return $this->markdown('mail.landTaxNotice', ['land'=>$land, 'date'=>$date, 'year'=>$year,'duePayment'=>$duePayment]);
    }

    private function calculateTax($landId)
    {
        $landTaxPremises = Land_tax::findOrFail($landId);  //get vat payer id
        
        $landTax = Vat::where('name', 'Land Tax')->firstOrFail();
        $dueAmount = $landTaxPremises->due==null? 0 : $landTaxPremises->due->due_amount;
        return $landTaxPremises->worth*($landTax->vat_percentage/100) + $dueAmount;
        // return $landWorth*($landTax->vat_percentage/100)+ $dueAmount; 
    }
}
